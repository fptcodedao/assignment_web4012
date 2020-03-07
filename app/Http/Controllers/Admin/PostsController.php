<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\PostRequest;
use App\Models\Admin;
use App\Models\Post;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostsController extends Controller
{
    protected $postsRepository;

    /**
     * PostsController constructor.
     * @param PostRepositoryInterface $postsRepository
     */
    public function __construct(PostRepositoryInterface $postsRepository)
    {
//        $this->authorizeResource(Post::class, 'post');
        $this->postsRepository = $postsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser($user, 'viewAny', Post::class);
        return view('admin.posts.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function data(Request $request){
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Post::class);

        $columns = $this->postsRepository->getTableColumns(['deleted_at', 'updated_at', 'created_at', 'published', 'status']);

        $limit = $request->input('length');
        $limit = ($limit) ? $limit : 10;
        $start = $request->input('start');
        $start = ($start) ? $start : 0;
        $order = $columns[$request->input('order.0.column')];
        $order = ($order) ? $order : ['id'];
        $dir = $request->input('order.0.dir');
        $dir = ($dir) ? $dir : 'desc';

        $search = $request->input('search.value');

        $posts = $this->postsRepository;
        if (Gate::forUser($user)->denies('fullPost')){
            $posts = $posts->where('admin_id', $user->id);
        }


        $posts = $posts->where(function ($q) use ($columns, $search){
            foreach($columns as $column){
                $q->orWhere($column, 'like', '%'.$search.'%');
            }
        });

        $totalData = $totalFiltered = $search ? $posts->count() : $this->postsRepository->count();

        $posts = $posts->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)->with(['admin', 'category'])->get();

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $posts
        );
        return response()->json($json_data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'create', Post::class);
        return view('admin.posts.create');
    }

    /**
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PostRequest $request)
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'create', Post::class);
        $data = $request->all(['title', 'description', 'thumb_img', 'published']);
        $data['status'] = 1;
        $data['admin_id'] = \Auth::guard('admin')->user()->id;
        $categories = $request->input('category_id');
        $data['seo_title'] = $request->input('seo_title') ? $request->input('seo_title') : $data['title'];
        $data['seo_description'] = strip_tags(str_limit($data['description'], 100, '...'));
        try{
            $post = $this->postsRepository->create($data);
            foreach($categories as $category){
                $post->category()->attach($category);
            }
        }catch (\Exception $e){
            return response()->json([
                'error' => true,
                'msg' => $e->getMessage()
            ]);
        }
        return response()->json([
            'error' => false,
            'msg' => $post->title
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function edit(Post $post, $id)
    {
        try{
            $user = \Auth::guard('admin')->user();
            $post = $this->postsRepository->with('category')->findOrFail($id);
            if(Gate::forUser($user)->denies('update', $post)){
                return redirect()->route('dashboard.posts.index')->withErrors(['permission' => 'Bạn không có quyền truy cập']);
            }
        }catch(ModelNotFoundException $exception){
            return redirect()->route('dashboard.posts.index')->withErrors($exception->getMessage());
        }
//        dd($post);
        return view('admin.posts.update', compact('post'));
    }

    /**
     * @param PostRequest $request
     * @param $id
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, Post $post, $id)
    {
        $data = $request->all(['title', 'description', 'thumb_img', 'published']);
        $categories = $request->input('category_id');
        try{
            $post = $this->postsRepository->findOrFail($id);
            $user = \Auth::guard('admin')->user();
            $this->authorizeForUser( $user, 'update', $post);
            $post->update($data);
            $post->category()->detach();
            $post->category()->attach($categories);
        }catch(\Exception $exception){

        }
        return response()->json([
            'updated' => true
        ]);
    }

    /**
     * @param Post $post
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    public function destroy(Post $post, int $id)
    {
        $post = $this->postsRepository->findOrFail($id);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user, 'delete', $post);
        $delete = $post->delete();
        return response([
            'deleted' => $delete
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\PostRequest;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    protected $postsRepository;

    public function __construct(PostRepositoryInterface $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    /**
     * get all data
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request){
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
        $posts = $this->postsRepository->search($columns, $search);

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
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.posts.create');
    }


    public function store(PostRequest $request)
    {
        $data = $request->all(['title', 'description', 'thumb_img', 'published']);
        $data['status'] = 1;
        $data['admin_id'] = \Auth::guard('admin')->user()->id;
        $categories = $request->input('category_id');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $delete = $this->postsRepository->delete($id);
        return response([
            'deleted' => $delete
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    protected $postRepository;

    const TIME_CACHE = 1440; //1 ngay

    public function __construct(PostRepositoryInterface $postRepository)
    {
//        $this->middleware('auth');
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storeComment(StoreCommentRequest $request, $slug){
        $data = $request->all('content');
        $data['user_id'] = \Auth::user()->id;
        $post = $this->postRepository->where('slug', $slug)->first();
        if (!empty($post)){
            $comment = new Comment($data);
            try{
                $post->comments()->save($comment);
            }catch (\Exception $exception){
                return redirect()->back()->with('content', 'Lỗi sự cố');
            }
            return redirect()->back()->with('content', '');
        }else{
            return redirect()->back()->with('content', 'Lỗi sự cố');
        }

    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($slug)
    {
        $post = $this->postRepository->where('slug', $slug)->with(['comments', 'category'])->first();
        if (empty($post)){
            return redirect()->route('client.index');
        }
        return view('client.posts.index', compact('post'));
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

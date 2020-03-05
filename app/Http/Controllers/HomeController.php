<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $postRepository;

    const TIME_CACHE = 1440; // 1 ngay

    public function __construct(PostRepositoryInterface $postRepository)
    {
//        $this->middleware('auth');
        $this->postRepository = $postRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $posts = Post::with('comment')->paginate(10);
        $posts = Cache::remember('home_page_'.\request()->input('page'), self::TIME_CACHE,function(){
            return $this->postRepository->with('comments')->paginate(10);
        });
        return view('client.index', compact('posts'));
    }
}

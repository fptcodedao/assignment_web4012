<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Comment\CommentRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{

    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Comment::class);
        return view('admin.comments.index');
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

    public function data(Request $request){
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Comment::class);

        $columns = $this->commentRepository->getTableColumns(['deleted_at', 'updated_at', 'created_at']);

        $limit = $request->input('length');
        $limit = ($limit) ? $limit : 10;
        $start = $request->input('start');
        $start = ($start) ? $start : 0;
        $order = $columns[$request->input('order.0.column')];
        $order = ($order) ? $order : ['id'];
        $dir = $request->input('order.0.dir');
        $dir = ($dir) ? $dir : 'desc';


        $search = $request->input('search.value');
        $posts = $this->commentRepository->search($columns, $search);

        $totalData = $totalFiltered = $search ? $posts->count() : $this->commentRepository->count();

        $posts = $posts->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)->with(['users', 'posts'])->get();

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $posts
        );
        return response()->json($json_data);
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
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $comment = $this->commentRepository->findOrFail($id);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user, 'update', $comment);
        $delete = $comment->delete();
        return response([
            'deleted' => $delete
        ]);
    }
}

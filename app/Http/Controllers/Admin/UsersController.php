<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Contracts\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user, 'viewAny', User::class);
        return view('admin.users.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function data(Request $request){

        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user, 'viewAny', User::class);

        $columns = $this->usersRepository->getTableColumns();

        $limit = $request->input('length');
        $limit = ($limit) ? $limit : 10;
        $start = $request->input('start');
        $start = ($start) ? $start : 0;
        $order = $columns[$request->input('order.0.column')];
        $order = ($order) ? $order : ['id'];
        $dir = $request->input('order.0.dir');
        $dir = ($dir) ? $dir : 'desc';


        $search = $request->input('search.value');
        $posts = $this->usersRepository->search($columns, $search);

        $totalData = $totalFiltered = $search ? $posts->count() : $this->usersRepository->count();

        $posts = $posts->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)->get();

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

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin, $id)
    {
        $admin = \Auth::guard('admin')->user();
        $user = $this->usersRepository->find($id);
        $this->authorizeForUser( $admin, 'viewAny', $user);
        return response([
            'deleted' => $user->delete()
        ]);
    }
}

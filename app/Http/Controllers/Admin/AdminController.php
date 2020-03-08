<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Mail\InfoAdmin;
use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $adminRepository, $roleRepository;

    public function __construct(AdminRepositoryInterface $adminRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Admin::class);
        $admins = $this->adminRepository->where('id', '!=', 1)->paginate(10);

        $roles = $this->roleRepository->where('id', '!=', 1)->get();
        return view('admin.admin.index', compact('admins', 'roles'));
    }

    public function create()
    {

    }


    public function store(AdminRequest $request)
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'update', Admin::class);

        $role_editor = $this->roleRepository->where('slug', '!=', 'full_admin')->whereIn('id', $request->input('role'))->get();

        $data = $request->all(['full_name', 'email']);
        $password = bin2hex(random_bytes(5));
        $data['password'] = bcrypt($password);
        $data['token_hash'] = sha1(time());
        $data['username'] = $data['email'];
        $data['token_expired'] = date('Y-m-d H:i:s', time());
        $admin = $this->adminRepository->create($data);
        $admin->roles()->attach($role_editor);

        \Mail::to($admin->email)->send(new InfoAdmin($admin, $password));

        return redirect()->back()->with('success', 'Thêm thành công');
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
     */
    public function edit($id)
    {
        $admin = $this->adminRepository->with('roles')->findOrFail($id);
        $roles = $this->roleRepository->where('id', '!=', 1)->get();

        return view('admin.admin.update', compact('admin', 'roles'));
    }


    public function update(AdminRequest $request, $id)
    {
        $admin = $this->adminRepository->with('roles')->findOrFail($id);
        $roles = $this->roleRepository->where('slug', '!=', 'full_admin')->whereIn('id', $request->input('role'))->get();
        //remove all foreign key
        $admin->roles()->detach();
        $admin->roles()->attach($roles);
        return redirect()->back()->with('success', 'Cập nhật thành công');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        if ($id == 1){
            return response([
                'deleted' => false
            ]);
        }
        $admin = $this->adminRepository->findOrFail($id);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user, 'delete', $admin);
        $delete = $admin->delete();
        return response([
            'deleted' => $delete
        ]);
    }
}

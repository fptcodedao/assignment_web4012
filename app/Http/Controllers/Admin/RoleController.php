<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleRepository;

    /**
     * RoleController constructor.
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'viewAny', Role::class);
        $roles = $this->roleRepository->paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'create', Role::class);
        return view('admin.role.create');
    }


    public function store(RoleRequest $request)
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'create', Role::class);

        $data = $request->all(['name', 'permissions']);

        //convert value to key
        $data['permissions'] = array_flip($data['permissions']);
        //change all value to true
        $data['permissions'] = array_map( function($value){
            return true;
        }, array_except($data['permissions'], 'isAdmin'));
        try{
            $create = $this->roleRepository->create($data);
        }catch (\Exception $exception){
            return redirect()->back();
        }
        return redirect()->back()->with('success', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }


    public function edit(Role $role, $id)
    {
        $user = \Auth::guard('admin')->user();

        $role = $this->roleRepository->findOrFail($id);
        $this->authorizeForUser( $user,'update', $role);
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'update', $role);
        return view('admin.role.edit', compact('role'));
    }


    public function update(RoleRequest $request, Role $role, $id)
    {
        $user = \Auth::guard('admin')->user();
        $this->authorizeForUser( $user,'update', Role::class);

        $role = $this->roleRepository->findOrFail($id);
        $data = $request->all(['name', 'permissions']);
        $permissions = array_except($role->permissions, config('roles.lists'));
        //convert value to key
        $data['permissions'] = array_flip($data['permissions']);
        //change all value to true
        $data['permissions'] = array_map( function($value){
            return true;
        }, array_except($data['permissions'], 'isAdmin'));
        $data['permissions'] = array_merge($permissions, $data['permissions']);
        $role->update($data);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}

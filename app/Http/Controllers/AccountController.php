<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\PasswordStoreRequest;
use App\Models\User;
use App\Repositories\Contracts\Users\UsersRepositoryInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $usersRepository;


    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = User::find(\Auth::user()->id);
        return view('client.accounts.index', compact('user'));
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
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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


    public function update(AccountRequest $request, $id)
    {
        if ($id != \Auth::user()->id){
            return redirect()->back()->with('account_error', 'bạn không có quyền sửa user này');
        }
        $data = $request->all(['name', 'dob']);
        if($request->file('avatar')){
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        }
        $user = $this->usersRepository->findOrFail($id);
        $user->update($data);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function storePassword(PasswordStoreRequest $request, $id){
        if ($id != \Auth::user()->id){
            return redirect()->back()->with('account_error', 'bạn không có quyền sửa user này');
        }
        $user = $this->usersRepository->findOrFail($id);
        if (\Hash::check($request->input('old_password'), $user->password)) {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            return redirect()->back()->with('passnoti', 'Cập nhật thành công');
        }
        return redirect()->back()->with('passnoti', 'Mật khẩu cũ không đúng');
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

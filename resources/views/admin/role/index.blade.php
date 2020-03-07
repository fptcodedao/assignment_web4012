@extends('admin.layouts.master')

@section('title', 'Danh sách phân quyền')

@section('content')
    <!-- Striped Rows -->
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="header">
                    <h2><strong>Thêm quyền</strong></h2>
                </div>
                <div class="body">
                    <form action="{{ route('dashboard.roles.store') }}" method="post">
                        @csrf
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="name">Tên Role</label>
                            @error('name')
                            <p style="color:red; font-weight: bold">{{ $message }}</p>
                            @enderror
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="permissions">Permission</label>
                            @error('permissions')
                            <p style="color:red; font-weight: bold">{{ $message }}</p>
                            @enderror
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            id="permissions_posts" value="posts.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_posts">Bài đăng</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            id="permissions_category" value="category.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_category">Danh mục</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            id="permissions_users" value="users.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_users">Người dùng</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            id="permissions_comments" value="comments.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_comments">Phản hồi</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            id="permissions_roles" value="roles.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_roles">Phân quyền</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card">
                <div class="header">
                    <h2> <strong>Striped</strong> Rows</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a href="{{ route('dashboard.roles.edit', $role->id) }}" class="btn btn-primary btn-sm btn-edit"><i class="zmdi zmdi-edit"></i></a>
                                    <button data-delete="{{ $role->id }}" class="btn btn-danger btn-sm btn-delete"><i class="zmdi zmdi-delete"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

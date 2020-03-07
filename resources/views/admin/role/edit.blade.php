@extends('admin.layouts.master')

@section('title', 'Phần quyền')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Phân quyền cho {{ $role->name }}</strong></h2>
                </div>
                <div class="body">
                    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên Role</label>
                            @error('name')
                            <p style="color:red; font-weight: bold">{{ $message }}</p>
                            @enderror
                            <input type="text" name="id" id="id" value="{{ $role->id }}" hidden="hidden" class="form-control">
                            <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            @error('permissions')
                            <p style="color:red; font-weight: bold">{{ $message }}</p>
                            @enderror
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            {{ array_key_exists('posts.*', $role->permissions) ? 'checked': '' }}
                                            id="permissions_posts" value="posts.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_posts">Bài đăng</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            {{ array_key_exists('category.*', $role->permissions) ? 'checked': '' }}
                                            id="permissions_category" value="category.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_category">Danh mục</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            {{ array_key_exists('users.*', $role->permissions) ? 'checked': '' }}
                                            id="permissions_users" value="users.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_users">Người dùng</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            {{ array_key_exists('comments.*', $role->permissions) ? 'checked': '' }}
                                            id="permissions_comments" value="comments.*" type="checkbox" name="permissions[]">
                                        <label for="permissions_comments">Phản hồi</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input
                                            {{ array_key_exists('roles.*', $role->permissions) ? 'checked': '' }}
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
    </div>
@endsection

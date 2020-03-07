@extends('layouts.master')
@section('title', 'Thông tin tài khoản')
@section('content')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Thông tin</h4>
            </div>
            <div class="panel-body">
                <ol class="comment-list" style="padding-bottom: 30px;">
                    <li class="comment byuser comment-author-admin bypostauthor even thread-odd thread-alt depth-1">
                        <div class="comment-body">
                            <footer class="comment-meta">
                                <div class="comment-author vcard">
                                    <img alt="img" src="{{ asset($user->avatar ? 'storage/'.$user->avatar : 'https://image.ibb.co/jw55Ex/def_face.jpg') }}" class="avatar avatar-72 photo">
                                    <b class="fn">{{ $user->name }}</b>
                                </div>
                                <div class="">
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </div>
                            </footer>
                            <div class="reply">
                                <a href="#">{{ $user->dob }}</a>
                            </div>
                        </div>
                    </li>
                </ol>
                <form class="box-pr" action="{{ route('client.account.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    <div class="validation-summary-errors" data-valmsg-summary="true">
                        <ul>
                            <li style="display:none"></li>

                            @if (session()->has('success'))
                                <li style="font-weight: bold; color:#78ff00">{{session()->get('success')}}</li>
                            @endif
                            @if (session()->has('account_error'))
                                <li style="font-weight: bold; color:red">{{session()->get('account_error')}}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="box-pr-tit">Thông tin tài khoản cá nhân</div>
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-2"><label for="email">Email</label></div>
                        <div class="col-md-10">{{$user->email}}</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"><label for="name">Họ tên</label></div>
                        <div class="col-md-10">
                            <input class="form-control" data-val="true" data-val-required="Hãy điền họ và tên!" id="name" name="name" placeholder="Nhập họ và tên" type="text"
                                   value="{{$user->name}}">
                            @if ($errors->has('name'))
                                <span>{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"><label for="dob">Avatar</label></div>
                        <div class="col-md-10">
                            <input class="form-control" data-val="true" id="avatar" name="avatar" type="file">
                            @if ($errors->has('avatar'))
                                <span>{{$errors->first('avatar')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"><label for="dob">Ngày Sinh</label></div>
                        <div class="col-md-10">
                            <input class="form-control" data-val="true" data-val-required="Hãy điền số điện thoại!" id="dob" name="dob" value="{{$user->dob}}">
                            @if ($errors->has('dob'))
                                <span>{{$errors->first('dob')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn btn-primary">Cập nhật</button></div>
                </form>
                <form class="box-pr" action="{{ route('client.account.password', $user->id) }}" method="post">
                    <div class="validation-summary-errors" data-valmsg-summary="true">
                        <ul>
                            <li style="display:none"></li>
                            @if (session()->has('passnoti'))
                                <li>{{session()->get('passnoti')}}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="box-pr-tit">Đổi mật khẩu</div>
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="old_password">Mật khẩu cũ</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" type="password">
                            @if ($errors->has('old_password'))
                                <span>{{$errors->first('old_password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="new_password">Mật khẩu mới</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" type="password">
                            @if ($errors->has('new_password'))
                                <span>{{$errors->first('new_password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="new_password_confirmation">Nhập lại mật khẩu mới</label>
                        </div>
                        <div class="col-md-10">
                            <input class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $( "#dob").datepicker({ dateFormat: 'yy-mm-dd' });
        });
    </script>
@endpush

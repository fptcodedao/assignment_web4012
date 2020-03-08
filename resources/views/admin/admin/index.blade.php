@extends('admin.layouts.master')

@section('title', 'Quản trị viên')

@section('content')
    <!-- Striped Rows -->
    <div class="row clearfix">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card">
                <div class="header">
                    <h2>Thêm tài khoản</h2>
                </div>
                <div class="body">
                    <form action="{{ route('dashboard.admin.store') }}" method="post">
                        @csrf
                        @if(session()->has('success'))
                            <p style="color:red; font-weight: bold">{{ session()->get('success') }}</p>
                        @endif
                        <div class="form-group">
                            <label for="full_name">Họ tên</label>
                            @error('full_name')
                                <p>{{ $message }}</p>
                            @enderror
                            <input type="text" name="full_name" id="full_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            @error('email')
                            <p>{{ $message }}</p>
                            @enderror
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            @error('role')
                            <p>{{ $message }}</p>
                            @enderror
                            <select name="role[]" id="role" class="form-control" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8">
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td>{{ $admin->full_name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->allRole() }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.admin.edit', $admin->id) }}" class="btn btn-primary btn-edit btn-sm"><i class="zmdi zmdi-edit"></i></a>
                                        <button data-delete="{{ $admin->id }}" class="btn btn-danger btn-sm btn-delete"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/admin/plugin/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#role').select2();
            $('table').on('click', '.btn-delete', function(e){
                e.preventDefault();
                let id = $(this).data('delete');
                swal({
                    title: "Are you sure?",
                    text: "Sau khi xóa, bạn sẽ không thể khôi phục tệp tưởng tượng này!\n",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: `{{route('dashboard.admin.destroy')}}/${id}`,
                                method: 'delete',
                            }).done(function (result) {
                                let msg = (result.deleted) ? 'Bạn đã xóa thành công' : 'Item này không tồn tại';
                                swal('Thông báo!!', msg, (result.deleted) ? 'success': 'warning')
                                    .then(function(){
                                        window.location.reload();
                                    });
                            }).fail(function (errors) {
                                if(errors.status == 403){
                                    swal('Thông báo!!!', 'Bạn không có quyền thực thi', 'warning');
                                }
                            });
                        } else {
                            swal("Bạn đã hủy yêu cầu xóa item này");
                        }
                    });
            });
        });
    </script>
@endpush

@extends('admin.layouts.master')

@section('parentPageTitle', 'Bài Đăng')
@section('title', 'Danh sách bài đăng')

@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/datatables/css/jquery.dataTables.min.css')}}" />
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">@yield('title') </h2>
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="post_data">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@push('script')
    <script src="{{ asset('assets/admin/plugin/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            @error('permission')
                swal('Thông báo!!!', '{{ $message }}', 'warning');
            @enderror

            var table = $('#post_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('dashboard.posts.data') }}',
                    method: 'post'
                },
                deferRender: true,
                columnDefs: [
                    {
                        'targets': [0],
                        'searchable': false,
                        'orderable': true,
                    },
                    {
                        'targets': [1],
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        'targets': [2],
                        'searchable': false,
                        'orderable': true
                    },
                    {
                        'targets': [3],
                        'searchable': false,
                        'orderable': false
                    },
                    {
                        'targets': [4],
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        'targets': [5],
                        'searchable': false,
                        'orderable': false
                    }
                ],
                columns:[
                    {data: 'id', title: 'ID'},
                    {data: 'title', title: 'Tiêu đề'},
                    {data: 'created_at', title: 'Thời gian'},
                    {data: 'view', title: 'Số lượt xem'},
                    {data: 'admin', title: 'Người viết', render:function(data){
                            return !data? 'Admin' : data.full_name
                        }
                    },
                    {data: 'id', title: 'Action', render: function(id){
                            let url_edit = '{{ route('dashboard.posts.edit', ':id') }}';
                                url_edit = url_edit.replace(':id', id);
                            return `
                            <a data-edit="${id}" class="btn btn-success btn-eye btn-sm"><i class="zmdi zmdi-eye"></i></a>
                            <a href="${url_edit}" class="btn btn-primary btn-edit btn-sm"><i class="zmdi zmdi-edit"></i></a>
										<a data-delete="${id}" class="btn btn-danger btn-sm btn-delete"><i class="zmdi zmdi-delete"></i></a>`;
                        }
                    }
                ],
                autoWidth: true,
                rowID: 'id',
                'language': {
                    'search': 'Tìm kiếm:',
                    'paginate': {
                        'first': 'Đầu',
                        'last': 'Cuối',
                        'next': 'Sau',
                        'previous': 'Trước'
                    },
                    'info': 'Hiển thị _START_ đến _END_ trong _TOTAL_ kết quả',
                    'infoEmpty': 'Hiển thị 0 đến 0 trong 0 kết quả',
                    'zeroRecords': 'không có dữ liệu trong bảng'
                },
                initComplete: function () {
                    $('#post_data').on('click', '.btn-delete', function (e) {
                        e.preventDefault();
                        let id = $(this).data('delete');
                        swal({
                            title: 'Thông báo!!!',
                            text: 'Bạn chắc chắn muốn xóa item này!!',
                            icon: 'warning'
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: `{{ route('dashboard.posts.destroy') }}/${id}`,
                                    method: 'delete'
                                }).done(result => {
                                    if(result.deleted){
                                        swal('Thông báo', 'Bạn đã xóa thành công item', 'success').then(e =>{
                                            table.ajax.reload();
                                        });
                                    }
                                }).fail(error => {
                                    let status = error.status;
                                    if(status === 403){
                                        swal('Thông báo!!!', 'Bạn không có quyền xóa item này', 'warning');
                                    }
                                    console.log(error)
                                });
                            } else {
                                swal("Your imaginary file is safe!");
                            }
                        });
                    });
                }
            });
        });
    </script>
@endpush

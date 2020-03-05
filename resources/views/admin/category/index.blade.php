@extends('admin.layouts.master')
@section('title', 'Danh Mục')

@push('style')
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/dropify/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/datatables/css/jquery.dataTables.min.css')}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">Thêm @yield('title')</h2>
                    <div class="row clearfix">
                        <form class="col-12" action="#" id="category_upload" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <textarea name="description" id="description" cols="10" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="form-control select2_category">
                                    <option value="0">Danh Mục Cha</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="file" name="thumb_img" class="form-control dropify" placeholder="Tên danh mục">
                            </div>
                            <div class="from-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">Danh Sách @yield('title') </h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="category_data">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editCate" tabindex="-1" role="dialog" aria-labelledby="editCateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" action="#" method="post" id="update_category">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCateLabel">Cập nhật danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Tên danh mục</label>
                        <input type="text" name="id" id="update_id" hidden="hidden" class="form-control" />
                        <input type="text" name="name" id="update_name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="name">Tên danh mục</label>
                        <textarea name="description" id="update_description" class="form-control" cols="5" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" name="thumb_img" class="form-control dropify" placeholder="Tên danh mục">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/admin/plugin/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugin/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugin/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">
        var CategoriesModel = {
            findId: id =>{
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `{{ route('dashboard.category.show') }}/${id}`,
                        method: 'get'
                    }).done(result => resolve(result)).fail(error => reject(error));
                });
            }
        };
        $(document).ready(function () {
            $('.dropify').dropify();

            $('.select2_category').select2({
                minimumInputLength: 2,
                ajax:{
                    url: '{{ route('dashboard.category.search') }}',
                    method: 'post',
                    dataType: 'json',
                    data:function(params){
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data){
                        return {
                            results: $.map(data, function(item){
                                return {
                                    text: item.text,
                                    id: item.id,
                                    data: item
                                }
                            })
                        }
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
            });
            var table = $('#category_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('dashboard.category.data') }}',
                    method: 'post'
                },
                deferRender: true,
                columnDefs: [
                    {
                        'targets': [0],
                        'searchable': true,
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
                        'orderable': false
                    },
                    {
                        'targets': [3],
                        'searchable': false,
                        'orderable': false
                    },
                    {
                        'targets': [4],
                        'searchable': false,
                        'orderable': false
                    }
                ],
                columns:[
                    {data: 'id', title: 'ID'},
                    {data: 'name', title: 'Tên danh mục'},
                    {data: 'thumb_img', title: 'Ảnh danh mục', render: function(data){
                            let img = `/storage/${data}`;
                            return `<img src="${img}" width="50px" />`
                        }
                    },
                    {data: 'parent', title: 'Danh mục cha', render: function(data){
                        return !(data) ? 'Cha' : data.name;
                        }
                    },
                    {data: 'id', title: 'Action', render: function(data){
                            let temp = `<a data-edit="${data}" data-remote="false" data-toggle="modal" data-target="#editCate" class="btn btn-primary btn-edit btn-sm"><i class="zmdi zmdi-edit"></i></a>
										<button data-delete="${data}" class="btn btn-danger btn-sm btn-delete"><i class="zmdi zmdi-delete"></i></button>`;
                            return `${temp}`;
                        }
                    }
                ],
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
                    $('#category_data').on('click', '.btn-delete', function(e){
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
                                        url: `{{route('dashboard.category.destroy')}}/${id}`,
                                        method: 'delete',
                                    }).done(function (result) {
                                        let msg = (result.deleted) ? 'Bạn đã xóa thành công' : 'Item này không tồn tại';
                                        swal('Thông báo!!', msg, (result.deleted) ? 'success': 'warning')
                                            .then(function(){
                                                table.ajax.reload();
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
                }
            });

            $('#category_upload').on('submit', function(e){
                e.preventDefault();
                let form_data = new FormData($(this)[0]);
                $.ajax({
                    url:'{{route('dashboard.category.store')}}',
                    method:'post',
                    cache : false,
                    contentType : false,
                    processData : false,
                    data: form_data
                }).done(function(result){
                    swal('Thông báo!', 'Thêm danh mục '+result.msg.name+' thành công', 'success').then(function(){
                        table.ajax.reload();
                        $('#category_upload input, textarea').val('');
                    });
                }).fail(function(error){
                    if(error.status == 422){
                        let res = error.responseJSON;
                        console.log(res)
                    }else if(error.status == 403){
                        swal('Thông báo!!!', 'Bạn không có quyền thêm danh mục', 'warning');
                    }
                });
            });

            $('#editCate').on('shown.bs.modal', async function(e){
                try{
                    let id = $(e.relatedTarget).data('edit');
                    let categoryData = await CategoriesModel.findId(id);

                    $('#update_id').val(categoryData.id);
                    $('#update_name').val(categoryData.name);
                    $('#update_description').val(categoryData.description);
                }catch(e){
                    $('#editCate').modal('hide');
                    swal('Thông báo!!!', 'Bạn không có quyền thực thi', 'warning');
                }
            });

            $('#update_category').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData($(this)[0]),
                    id = formData.get('id');
                formData.set('_method', 'put');
                $.ajax({
                    url: `{{ route('dashboard.category.update') }}/${id}`,
                    method: 'post',
                    contentType : false,
                    processData : false,
                    data: formData
                }).done(function(result){
                    if(result.updated){
                        $('#editCate').modal('hide');
                        swal('Thông báo!!!', 'Cập nhật thành công', 'success').then(_ => table.ajax.reload());
                    }
                }).fail(error => {
                    if(error.status == 403){
                        swal('Thông báo!!!', 'Bạn không có quyền thực thi', 'warning');
                    }
                });
            })
        });
    </script>
@endpush

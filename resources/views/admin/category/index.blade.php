@extends('admin.layouts.master')
@section('title', 'Danh Mục')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/dropify/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/plugin/select2/css/select2.min.css')}}">
@endsection
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
                                    <option value="1">Danh Mục Cha</option>
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
                    <h2 class="card-inside-title">Danh Sách @yield('title')</h2>
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable ">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/admin/plugin/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugin/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();

            $('.select2_category').select2();

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

                }).fail(function(error){

                });
            })
        });
    </script>
@endsection

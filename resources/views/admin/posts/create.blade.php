@extends('admin.layouts.master')

@section('parentPageTitle', 'Bài Đăng')
@section('title', 'Thêm bài đăng')
@section('content')
    <form class="row" action="{{ route('dashboard.posts.store') }}" method="post" id="create_post">
        <div class="col-md-9">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">@yield('title')</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tiêu đề bài đăng</label>
                                <input type="text" name="title" id="title" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="">Nội dung</label>
                                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">@yield('title')</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="published" id="published" class="form-control show-tick">
                                    <option value="1">Công khai</option>
                                    <option value="0">Lưu tạm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="category_id[]" id="category_id" multiple="multiple" class="form-control select2_category show-tick">
                                </select>
                            </div>
                            <div class="form-group">
                                    <a id="lfm" data-input="thumb_img" data-preview="holder" class="nav-link text-blue" style="color:blue!important;">
                                        <i class="fa fa-picture-o"></i> Thêm Thumb Images
                                    </a>
                                <input id="thumb_img" class="form-control" type="text" name="thumb_img">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">

                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script src="{{asset('assets/admin/plugin/select2/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/admin/plugin/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('input').on('focus', function () {
                if($(this).hasClass('border border-warning')){
                    $(this).removeClass('border border-warning').next().remove();
                }
            });

            var lfm_route = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
            var options = {
                filebrowserImageBrowseUrl: `${lfm_route}?type=Images`,
                filebrowserImageUploadUrl: `${lfm_route}/upload?type=Images&_token={{csrf_token()}}`,
                filebrowserBrowseUrl: `${lfm_route}?type=Files`,
                filebrowserUploadUrl: `${lfm_route}/upload?type=Files&_token={{csrf_token()}}`
            };
            CKEDITOR.replace('description', options);
            $('#lfm').filemanager('image', {prefix: lfm_route});
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

            $('#create_post').on('submit', function(e){
                e.preventDefault();
                let form_data = new FormData($(this)[0]);
                $.ajax({
                    url: '{{ route('dashboard.posts.store') }}',
                    method: 'post',
                    processData: false,
                    contentType:false,
                    data: form_data
                }).done(function(result){

                }).fail(errors => {
                    let status = errors.status,
                        msg = errors.responseJSON;
                    if (status === 422){
                        let error_msg = msg.errors;
                        Object.keys(msg.errors).forEach( k =>{
                            let label = `<label id="${k}-error" class="error" for="${k}">${error_msg[k][0]}</label>`;
                            $(`#${k}`).addClass('border border-warning').after(label);
                        });
                    }
                })
            })
        });
    </script>
@endpush

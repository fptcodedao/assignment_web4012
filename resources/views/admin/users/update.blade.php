@extends('admin.layouts.master')

@section('parentPageTitle', 'Bài Đăng')
@section('title', 'Cập nhật bài đăng')
@section('content')
    <form class="row" action="{{ route('dashboard.posts.update', $post->id) }}" method="post" id="update_post">
        <div class="col-md-9">
            <div class="card">
                <div class="body">
                    <h2 class="card-inside-title">{{ $post->title }}</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Tiêu đề bài đăng</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" />
                            </div>
                            <div class="form-group">
                                <label for="">Nội dung</label>
                                <textarea name="description" id="description" cols="30" rows="10">{!! $post->description !!}</textarea>
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
                                    <option {{$post->published ? 'selected' : ''}} value="1">Công khai</option>
                                    <option {{!$post->published ? 'selected' : ''}} value="0">Lưu tạm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="category_id[]" id="category_id" multiple="multiple" class="form-control select2_category show-tick">
                                    @foreach($post->category as $category)
                                        <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <a id="lfm" data-input="thumb_img" data-preview="holder" class="nav-link text-blue" style="color:blue!important;">
                                    <i class="fa fa-picture-o"></i> Thêm Thumb Images
                                </a>
                                <input id="thumb_img" class="form-control" type="text" value="{{ $post->thumb_img }}" name="thumb_img">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ $post->thumb_img }}">

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
    <script src="{{ asset('assets/admin/plugin/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugin/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/admin/plugin/sweetalert/sweetalert.min.js') }}"></script>
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
            var editor = CKEDITOR.replace('description', options);
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

            $('#update_post').on('submit', function(e){
                e.preventDefault();

                $(this).find('button').attr('disabled', true);

                let form_data = new FormData($(this)[0]),
                    url_current_update = $(this).attr('action');
                form_data.set('description', editor.getData());
                form_data.set('_method', 'put');
                $.ajax({
                    url: url_current_update,
                    method: 'post',
                    processData: false,
                    contentType:false,
                    cache: false,
                    data: form_data
                }).done(function(result){
                    if(!result.errors){
                        swal('Thông báo!!!', 'Cập nhật thành công', 'success');
                    }
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
                }).always(_ =>{
                    $(this).find('button').attr('disabled', false);
                });
            })
        });
    </script>
@endpush

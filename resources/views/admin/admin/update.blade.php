@extends('admin.layouts.master')

@section('title', 'Cập nhật quản trị viên')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="card">
                <div class="header">
                    <h2>@yield('title')</h2>
                </div>
                <div class="body">
                    <form action="{{ route('dashboard.admin.update', $admin->id) }}" method="post">
                        @csrf
                        @method('put')
                        @if(session()->has('success'))
                            <p style="color:red; font-weight: bold">{{ session()->get('success') }}</p>
                        @endif
                        <div class="form-group">
                            <label for="role">Role</label>
                            @error('role')
                            <p>{{ $message }}</p>
                            @enderror
                            <select name="role[]" id="role" class="form-control" multiple>
                                @foreach($roles as $role)
                                    <option
                                        {{ key_exists($role->id, $admin->roles()->get(['roles.id'])->keyBy('id')->toArray()) ? 'selected' : '' }}
                                        value="{{ $role->id }}">{{ $role->name }}</option>
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
    </div>
@stop

@push('script')
    <script src="{{asset('assets/admin/plugin/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#role').select2();
        });
    </script>
@endpush

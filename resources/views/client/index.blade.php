@extends('layouts.master')
@section('title', 'Trang chủ')

@section('content')
    <div class="post-list">
        @include('client.components.posts.list', ['posts' => $posts ])
    </div>
    <div class="clearfix"></div>
    <nav class="ow-pagination">
        {{ $posts->links() }}
    </nav>
@stop

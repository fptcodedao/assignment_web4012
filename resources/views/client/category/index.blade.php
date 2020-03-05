@extends('layouts.master')
@section('title', 'Danh mục '.$category->name)

@section('content')
    <div class="post-list">
    @include('client.components.posts.list', ['posts' => $category->posts()->paginate(10)])
    </div>
    <div class="clearfix"></div>
    <nav class="ow-pagination">
        {{ $category->posts()->paginate(10)->links() }}
    </nav>
@stop

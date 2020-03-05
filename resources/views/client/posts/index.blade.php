@extends('layouts.master')

@section('title', $post->title)
@push('style')
@endpush
@section('content')
    <!-- Type Post -->
    <article class="type-post">
        <div class="entry-cover">
            <img src="{{ asset($post->thumb_img) }}" width="770px" height="300px" alt="Blog" />
            <div class="tags">
                <a href="#" title="Nature">{{empty($post->category) ? 'Nothing' : $post->category[0]->name}}</a>
            </div>
        </div>
        <div class="entry-content">
            <h3 class="entry-title">{{ $post->title }}</h3>
            {!! $post->description !!}

            <div class="row mt-5">
                <strong>Danh Mục:</strong>
                @foreach($post->category as $category)
                    <a href="{{ route('client.category.show', $category->slug) }}" class="btn btn-outline-secondary btn-xs">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="entry-footer">
                <div class="entry-meta">
                    <span class="byline">By <a href="#" title="{{ $post->admin->full_name }}">{{ $post->admin->full_name }}</a></span>
                    <span class="post-date"><a href="#">{{ $post->created_at }}</a></span>
                </div>
                <div class="post-social">
                    <ul>
                        <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" title="Youtube"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </article><!-- Type Post /- -->
    <!-- About Author -->
    <div class="about-author">
        <i><img src="{{ asset($post->admin->avatar ? $post->admin->avatar : 'https://graph.facebook.com/v6.0/1753463521/picture?width=88') }}" alt="Author"></i>
        <h3>{{ $post->admin->full_name }}</h3>
        <p>
            {{ $post->admin->story }}
        </p>
        <ul>
            <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#" title="Youtube"><i class="fa fa-youtube"></i></a></li>
            <li><a href="#" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#" title="Twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
        </ul>
    </div><!-- About Author -->

    <!-- Comment Area -->
    <div id="comments" class="comments-area">
        <h2 class="comments-title">{{ $post->comments()->count() }} Comments</h2>
        <div class="comment-block">
            <ol class="comment-list">
                @foreach($post->comments()->with('users')->get() as $comment)
                <li class="comment byuser comment-author-admin bypostauthor even thread-odd thread-alt depth-1">
                    <div class="comment-body">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <img alt="img" src="{{ asset($comment->users->avatar ? $comment->users->avatar : 'https://image.ibb.co/jw55Ex/def_face.jpg') }}" class="avatar avatar-72 photo"/>
                                <b class="fn">{{ $comment->users->name }}</b>
                            </div>
                            <div class="comment-metadata">
                                <a href="#">{{ date('Y-m-d', strtotime($comment->created_at)) }}</a>
                            </div>
                        </footer>
                        <div class="comment-content">
                            <p> {{ $comment->content }}</p>
                        </div>
                        <div class="reply">
                            <a rel="nofollow" class="comment-reply-link" href="#"><i class="fa fa-reply"></i>Reply</a>
                        </div>
                    </div>
                </li>
                    @endforeach
            </ol><!-- .comment-list -->
        </div>
        <!-- Comment Form -->
        <div id="respond" class="comment-respond">
            <h2 class="comment-reply-title">Leave a Comment</h2>
            @guest()
                <a href="{{ route('login') }}">Đăng nhập để bình luận </a>
            @endguest
            @auth()
            <form method="post" id="commentform" action="{{ route('client.posts.comment', $post->slug) }}" class="comment-form">
                @csrf
                @error('content')
                <p style="color:red"><{{ $message }}/p>
                @enderror
                <p class="comment-form-comment">
                    <textarea id="content" name="content" placeholder="Enter your comment here..." rows="8"></textarea>
                </p>
                <p class="form-submit">
                    <input name="submit" class="submit" value="Post Comment" type="submit"/>
                </p>
            </form>
            @endauth
        </div><!-- Comment Form /- -->
    </div><!-- Comment Area -->
@endsection

@push('script')
@endpush

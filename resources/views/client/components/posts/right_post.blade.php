@foreach($posts as $post)
    <div class="post-box">
        <a href="#"><img src="{{ asset($post->thumb_img) }}" width="60px" height="56px" alt="Popular Post" /></a>
        <div class="post-content">
            <h3><a href="{{ route('client.posts.show', $post->slug) }}">{{ $post->title }}</a></h3>
            <span><a href="#">{{ $post->created_at }}</a></span>
        </div>
    </div>
@endforeach

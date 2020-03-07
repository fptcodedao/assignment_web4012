@foreach($posts as $post)
    <!-- Type Post -->
    <div class="type-post post-box survival">
        <div class="entry-cover">
            <a href="{{ route('client.posts.show', $post->slug) }}"><img src="{{ asset($post->thumb_img) }}" alt="Blog" /></a>
            <div class="tags">
                <a href="#" title="{{empty($post->category) ? 'Nothing' : $post->category[0]->name}}">{{empty($post->category) ? 'Nothing' : $post->category[0]->name}}</a>
            </div>
            <span><a href="#" title="View Post">View Post <i class="fa fa-long-arrow-right"></i></a></span>
        </div>
        <div class="entry-content">
            <h3 class="entry-title"><a href="{{ route('client.posts.show', $post->slug) }}">{{ $post->title }}</a></h3>
            <p>{{ strip_tags(str_limit($post->description, 100, '...')) }}...</p>
            <div class="entry-footer">
                <div class="entry-meta">
                    <span class="byline">By <a href="#" title="{{ $post->admin->full_name }}">{{ $post->admin->full_name }}</a></span>
                    <span class="post-comment"><a href="#">{{ $post->comments()->count() }}  COMMENTS</a></span>
                </div>
            </div>
        </div>
    </div><!-- Type Post /- -->
@endforeach

<div class="blog__comment--list two d-flex mb-30">
    <div class="blog__comment--thumbnail">
        {{-- <img src="./assets/img/blog/blog-comment2.png" alt="img"> --}}
    </div>
    <div class="blog__comment--content">
        <div class="blog__comment--content__top">
            <div class="blog__comment--content__top--left">
                <h4 class="blog__comment--content__name">{{ $reply->author_name }}</h4>
                <span class="blog__comment--date">{{    \Carbon\Carbon::parse($reply->created_at)->setTimezone('Africa/Lagos')->format('F d, Y \a\t h:i a') }}</span>
            </div>
        </div>
        <p class="blog__comment--content__desc">{{ $reply->content }}</p>
    </div>
</div>
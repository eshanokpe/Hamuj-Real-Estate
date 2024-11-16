<div class="blog__review--comment__inner">
        <div class="blog__comment--list d-flex mb-30">
            <div class="blog__comment--thumbnail">
                {{-- <img src="./assets/img/blog/blog-comment1.png" alt="img"> --}}
            </div>
            <div class="blog__comment--content">
                <div class="blog__comment--content__top d-flex justify-content-between">
                    <div class="blog__comment--content__top--left">
                        <h4 class="blog__comment--content__name">{{ $comment->author_name }}</h4>
                        <span class="blog__comment--date">{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Africa/Lagos')->format('F d, Y \a\t h:i a') }}</span>
                    </div>
                    <a class="blog__comment--content__reply reply-toggle nir-btn mr-2" href="#">
                        Reply
                    </a>
                </div>
                <p class="blog__comment--content__desc">{{ $comment->content }}</p>
            </div>
        </div>
    
        <div class="reply-form" style="display: none;">
            <div class="blog__comment--list two d-flex mb-30">
                <div class="blog__comment--thumbnail">
                    {{-- <img src="./assets/img/blog/blog-comment2.png" alt="img"> --}}
                </div>
                <div class="blog__comment--content">
                    <div class="write__your--comment">
                        <h3 class="blog__comment--title">Write your comment</h3>
                        <div class="blog__comment--form">
                            <form id="replyForm_{{ $comment->id }}">
                                <div class="row mb--n30">
                                    <!-- Form inputs for reply -->
                                    <div class="col-lg-6 col-md-6 mb-30">
                                        <div class="blog__comment--input">
                                            <input
                                                for="reply-name-{{ $comment->id }}"
                                                class="blog__comment--input__field"
                                                placeholder="Enter your name*"
                                                name="author_name"
                                                required
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mb-30">
                                        <div class="blog__comment--input">
                                            <input
                                                id="reply-name-{{ $comment->id }}"
                                                class="blog__comment--input__field"
                                                placeholder="Enter your mail*"
                                                name="author_email"
                                                type="email"
                                                data-temp-mail-org="0"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-12 mb-30">
                                        <div class="blog__comment--textarea">
                                            <textarea
                                                id="reply-content-{{ $comment->id }}"
                                                name="content"
                                                class="blog__comment--textarea__field"
                                                placeholder="Enter your message*"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="post_id" value="{{ $comment->post_id }}">
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <button type="submit" class="blog__comment--btn solid__btn">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
    

    @foreach ($comment->replies as $reply)
        @include('home.pages.blog.reply', ['reply' => $reply])
    @endforeach

    

</div>

<script>
    jQuery(document).ready(function ($) {
        $('.reply-toggle').click(function (event) {
            event.preventDefault();

            const replyForm = $(this).closest('.blog__comment--list').siblings('.reply-form');
            if (replyForm.length) {
                replyForm.toggle(); 
            }
        });

        // Handle the form submission for replying to comments
        $('[id^="replyForm_"]').submit(function (event) {
            event.preventDefault();

            var formId = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });

            const formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{ route("comments.store") }}',
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Required for FormData
                dataType: 'json',
                success: function (response) {
                    toastr.success('Reply submitted successfully');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                    $('#' + formId)[0].reset();
                },
                error: function (error) {
                    toastr.error('Error submitting reply');
                    console.error('Error:', error);
                },
            });
        });
    });
</script>



{{-- <svg width="26" height="19" viewBox="0 0 26 19" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M6.54688 10.2031L12.7969 16.4531C13.9688 17.625 16 16.8047 16 15.125V12.3516C20.6094 12.5469 20.7266 13.5625 20.0625 15.8672C19.5547 17.5469 21.4688 18.9141 22.9141 17.9375C24.9062 16.5703 26 14.8516 26 12.3516C26 6.76562 21 5.67188 16 5.47656V2.66406C16 0.984375 13.9688 0.164062 12.7969 1.33594L6.54688 7.58594C5.80469 8.28906 5.80469 9.5 6.54688 10.2031ZM7.875 8.875L14.125 2.625V7.3125C18.8125 7.3125 24.125 7.58594 24.125 12.3516C24.125 14.5391 22.9922 15.6328 21.8594 16.375C23.4609 11.0625 19.4766 10.4375 14.125 10.4375V15.125L7.875 8.875ZM1.54688 7.58594C0.804688 8.28906 0.804688 9.5 1.54688 10.2031L7.79688 16.4531C8.57812 17.2734 9.75 17.1562 10.4531 16.4531L2.875 8.875L10.4531 1.33594C9.75 0.632812 8.57812 0.515625 7.79688 1.33594L1.54688 7.58594Z" fill="currentColor"></path>
    </svg> --}}
@extends('layouts.app')

@section('content')


    <!-- Breadcrumb section -->
    <section class="breadcrumb__section section--padding">
        <div class="container">
            <div class="breadcrumb__content text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                <h1 class="breadcrumb__title h2">
                    <span>Blog </span>
                    Details
                </h1>
                <ul class="breadcrumb__menu d-flex justify-content-center">
                    <li class="breadcrumb__menu--items">
                        <a class="breadcrumb__menu--link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <span>
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"/>
                            </svg>
                        </span>
                    </li>
                    <li>
                        <span class="breadcrumb__menu--text">Blog Details </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Breadcrumb section .\ -->
           

    <section class="blog__details--section section--padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog__details--wrapper">
                        <div class="blog__details--thumbnail mb-30">
                            <img class="blog__details--thumbnail--media" src="{{ asset($post->image) }}" alt="img">
                        </div>
                        <div class="blog__details--content">
                            <div class="blog__details--content__top mb-40">
                                <ul class="blog__meta d-flex">
                                    <li class="blog__meta--list d-flex align-items-center">
                                      <span class="blog__meta--icon"><svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.5 9.5H5.5C2.4375 9.5 0 11.9688 0 15C0 15.5625 0.4375 16 1 16H13C13.5312 16 14 15.5625 14 15C14 11.9688 11.5312 9.5 8.5 9.5ZM1.5 14.5C1.75 12.5312 3.4375 11 5.5 11H8.5C10.5312 11 12.2188 12.5312 12.4688 14.5H1.5ZM7 8C9.1875 8 11 6.21875 11 4C11 1.8125 9.1875 0 7 0C4.78125 0 3 1.8125 3 4C3 6.21875 4.78125 8 7 8ZM7 1.5C8.375 1.5 9.5 2.625 9.5 4C9.5 5.40625 8.375 6.5 7 6.5C5.59375 6.5 4.5 5.40625 4.5 4C4.5 2.625 5.59375 1.5 7 1.5Z" fill="currentColor"></path>
                                        </svg>                                            
                                      </span>
                                      <span class="blog__meta--text">Admin</span>
                                    </li>
                                    <li class="blog__meta--list d-flex align-items-center">
                                      <span class="blog__meta--icon"><svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.37483 2.17857C8.58316 1.86905 7.73197 1.71428 6.82126 1.71428C5.91054 1.71428 5.05935 1.86905 4.26768 2.17857C3.47602 2.48809 2.84507 2.90774 2.37483 3.4375C1.91054 3.96726 1.6784 4.53571 1.6784 5.14286C1.6784 5.63095 1.83614 6.10119 2.15161 6.55357C2.46709 7.00595 2.91054 7.39881 3.48197 7.73214L4.34804 8.23214L4.03554 8.98214C4.23792 8.8631 4.42245 8.74702 4.58911 8.63393L4.98197 8.35714L5.45518 8.44643C5.91947 8.52976 6.37483 8.57143 6.82126 8.57143C7.73197 8.57143 8.58316 8.41667 9.37483 8.10714C10.1665 7.79762 10.7945 7.37798 11.2588 6.84821C11.729 6.31845 11.9641 5.75 11.9641 5.14286C11.9641 4.53571 11.729 3.96726 11.2588 3.4375C10.7945 2.90774 10.1665 2.48809 9.37483 2.17857ZM3.66054 1.1875C4.63078 0.776785 5.68435 0.571428 6.82126 0.571428C7.95816 0.571428 9.00876 0.776785 9.97304 1.1875C10.9433 1.59226 11.7082 2.14583 12.2677 2.84821C12.8272 3.55059 13.107 4.31548 13.107 5.14286C13.107 5.97024 12.8272 6.73512 12.2677 7.4375C11.7082 8.13988 10.9433 8.69643 9.97304 9.10714C9.00876 9.5119 7.95816 9.71429 6.82126 9.71429C6.30935 9.71429 5.78554 9.66667 5.24983 9.57143C4.51173 10.0952 3.68435 10.4762 2.76768 10.7143C2.5534 10.7679 2.29745 10.8155 1.99983 10.8571H1.97304C1.90757 10.8571 1.84507 10.8333 1.78554 10.7857C1.73197 10.7381 1.69923 10.6756 1.68733 10.5982C1.68137 10.5804 1.6784 10.5625 1.6784 10.5446C1.6784 10.5208 1.6784 10.5 1.6784 10.4821C1.68435 10.4643 1.6903 10.4464 1.69626 10.4286C1.70816 10.4107 1.71709 10.3958 1.72304 10.3839C1.72899 10.372 1.73792 10.3571 1.74983 10.3393C1.76768 10.3155 1.77959 10.3006 1.78554 10.2946C1.79745 10.2827 1.81233 10.2679 1.83018 10.25C1.84804 10.2262 1.85995 10.2113 1.8659 10.2054C1.89566 10.1696 1.96411 10.0952 2.07126 9.98214C2.1784 9.86905 2.25578 9.78274 2.3034 9.72321C2.35102 9.65774 2.41649 9.57143 2.49983 9.46429C2.58911 9.35119 2.66352 9.23512 2.72304 9.11607C2.78852 8.99702 2.85102 8.86607 2.91054 8.72321C2.17245 8.29464 1.59209 7.76786 1.16947 7.14286C0.746851 6.51786 0.535542 5.85119 0.535542 5.14286C0.535542 4.31548 0.815303 3.55059 1.37483 2.84821C1.93435 2.14583 2.69626 1.59226 3.66054 1.1875ZM14.1605 11.0089C14.2201 11.1518 14.2796 11.2827 14.3391 11.4018C14.4046 11.5208 14.479 11.6369 14.5623 11.75C14.6516 11.8571 14.7201 11.9405 14.7677 12C14.8153 12.0655 14.8927 12.1548 14.9998 12.2679C15.107 12.381 15.1754 12.4554 15.2052 12.4911C15.2111 12.497 15.223 12.5089 15.2409 12.5268C15.2588 12.5506 15.2707 12.5655 15.2766 12.5714C15.2885 12.5833 15.3004 12.5982 15.3123 12.6161C15.3302 12.6399 15.3421 12.6577 15.348 12.6696C15.354 12.6815 15.3599 12.6964 15.3659 12.7143C15.3778 12.7321 15.3838 12.75 15.3838 12.7679C15.3897 12.7857 15.3927 12.8036 15.3927 12.8214C15.3927 12.8452 15.3897 12.8661 15.3838 12.8839C15.3659 12.9673 15.3272 13.0327 15.2677 13.0804C15.2082 13.128 15.1427 13.1488 15.0713 13.1429C14.7736 13.1012 14.5177 13.0536 14.3034 13C13.3867 12.7619 12.5594 12.381 11.8213 11.8571C11.2855 11.9524 10.7617 12 10.2498 12C8.63673 12 7.23197 11.6071 6.03554 10.8214C6.38078 10.8452 6.64268 10.8571 6.82126 10.8571C7.77959 10.8571 8.69923 10.7232 9.58018 10.4554C10.4611 10.1875 11.2469 9.80357 11.9373 9.30357C12.6814 8.75595 13.2528 8.125 13.6516 7.41071C14.0504 6.69643 14.2498 5.94048 14.2498 5.14286C14.2498 4.68452 14.1814 4.23214 14.0445 3.78571C14.8123 4.20833 15.4195 4.73809 15.8659 5.375C16.3123 6.0119 16.5355 6.69643 16.5355 7.42857C16.5355 8.14286 16.3242 8.8125 15.9016 9.4375C15.479 10.0565 14.8986 10.5804 14.1605 11.0089Z" fill="currentColor"></path>
                                        </svg> 
                                      </span>
                                      <span class="blog__meta--text">Comments ({{ $post->comments->count()}})</span>
                                    </li>
                                    <li class="blog__meta--list d-flex align-items-center">
                                      <span class="blog__meta--icon"><svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.17773 0.96875C10.9238 0.96875 13.959 4.00391 13.959 7.75C13.959 11.4961 10.9238 14.5312 7.17773 14.5312C3.43164 14.5312 0.396484 11.4961 0.396484 7.75C0.396484 4.00391 3.43164 0.96875 7.17773 0.96875ZM7.17773 13.2188C10.1855 13.2188 12.6465 10.7852 12.6465 7.75C12.6465 4.74219 10.1855 2.28125 7.17773 2.28125C4.14258 2.28125 1.70898 4.74219 1.70898 7.75C1.70898 10.7852 4.14258 13.2188 7.17773 13.2188ZM8.8457 10.375L6.52148 8.67969C6.43945 8.625 6.41211 8.51562 6.41211 8.43359V3.92188C6.41211 3.75781 6.54883 3.59375 6.74023 3.59375H7.61523C7.7793 3.59375 7.94336 3.75781 7.94336 3.92188V7.80469L9.74805 9.14453C9.91211 9.25391 9.93945 9.44531 9.83008 9.60938L9.31055 10.293C9.20117 10.457 9.00977 10.4844 8.8457 10.375Z" fill="currentColor"></path>
                                        </svg>                                            
                                      </span>
                                      <span class="blog__meta--text">{{$readingTime}} min Read</span>
                                    </li>
                                </ul>
                                <h3 class="blog__content--title "> {{ $post->title}}</h3>
                                <p class="blog__details--content__desc">
                                    {!! $post->content !!}
                                </p>
                                
                            </div>
                            
                            <div class="blog__comment--area"> 
                                <div class="blog__review--comment mb-50">
                                    <h3 class="blog__comment--title">({{ $post->comments->count() }}) Comment</h3>
                                    @foreach ($post->comments as $comment)
                                        <div class="comment-box">
                                            @include('home.pages.blog.comment', ['comment' => $comment])
                                        </div>
                                    @endforeach
                                   
                                </div>
                                <div class="write__your--comment">
                                    <h3 class="blog__comment--title">Write your comment</h3>
                                    <div class="blog__comment--form">
                                        <form id="commentForm_{{ $post->id }}" >
                                            <div class="row mb--n30">
                                                <div class="col-lg-6 col-md-6 mb-30">
                                                    <div class="blog__comment--input">
                                                        <input name="author_name" class="blog__comment--input__field" placeholder="Enter your name*" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 mb-30">
                                                    <div class="blog__comment--input">
                                                        <input name="author_email" class="blog__comment--input__field" placeholder="Enter your mail*" type="email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpiYmZkZTQxOS00ZGRkLWU5NDYtOWQ2MC05OGExNGJiMTA3N2YiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDAyNDkwMkRDOTIyMTFFNkI0MzFGRTk2RjM1OTdENTciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDAyNDkwMkNDOTIyMTFFNkI0MzFGRTk2RjM1OTdENTciIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTU2NTE1NDItMmIzOC1kZjRkLTk0N2UtN2NjOTlmMjQ5ZGFjIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOmJiZmRlNDE5LTRkZGQtZTk0Ni05ZDYwLTk4YTE0YmIxMDc3ZiIv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&quot;) !important; background-repeat: no-repeat; background-size: 20px; background-position: 97% center; cursor: auto;" data-temp-mail-org="0">
                                                    </div>
                                                </div>
                                               
                                                <div class="col-12 mb-30">
                                                    <div class="blog__comment--textarea">
                                                        <textarea name="content" class="blog__comment--textarea__field" placeholder="Enter your Massage*"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input type="hidden" name="parent_id" value="">
                                            <button type="submit" class="blog__comment--btn solid__btn">Send Messege</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="listing__widget">
                        <div class="widget__admin--profile blog__admin text-center mb-30">
                            <div class="admin__profile--thumbnail">
                                <img src="./assets/img/other/admin-profile.png" alt="img">
                            </div>
                            <div class="admin__profile--content">
                                <h3 class="admin__profile--name">Rosalina D. Willaim</h3>
                                <h5 class="admin__profile--subtitle">Real estate broker</h5>
                                <ul class="admin__profile--rating d-flex justify-content-center">
                                    <li><span><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4375 5.45312L10.4453 4.87891L8.64062 1.24219C8.33984 0.613281 7.41016 0.585938 7.08203 1.24219L5.30469 4.87891L1.28516 5.45312C0.574219 5.5625 0.300781 6.4375 0.820312 6.95703L3.69141 9.77344L3.00781 13.7383C2.89844 14.4492 3.66406 14.9961 4.29297 14.668L7.875 12.7812L11.4297 14.668C12.0586 14.9961 12.8242 14.4492 12.7148 13.7383L12.0312 9.77344L14.9023 6.95703C15.4219 6.4375 15.1484 5.5625 14.4375 5.45312ZM10.6094 9.30859L11.2656 13.082L7.875 11.3047L4.45703 13.082L5.11328 9.30859L2.35156 6.62891L6.15234 6.08203L7.875 2.63672L9.57031 6.08203L13.3711 6.62891L10.6094 9.30859Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </li>
                                    <li><span><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4375 5.45312L10.4453 4.87891L8.64062 1.24219C8.33984 0.613281 7.41016 0.585938 7.08203 1.24219L5.30469 4.87891L1.28516 5.45312C0.574219 5.5625 0.300781 6.4375 0.820312 6.95703L3.69141 9.77344L3.00781 13.7383C2.89844 14.4492 3.66406 14.9961 4.29297 14.668L7.875 12.7812L11.4297 14.668C12.0586 14.9961 12.8242 14.4492 12.7148 13.7383L12.0312 9.77344L14.9023 6.95703C15.4219 6.4375 15.1484 5.5625 14.4375 5.45312ZM10.6094 9.30859L11.2656 13.082L7.875 11.3047L4.45703 13.082L5.11328 9.30859L2.35156 6.62891L6.15234 6.08203L7.875 2.63672L9.57031 6.08203L13.3711 6.62891L10.6094 9.30859Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </li>
                                    <li><span><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4375 5.45312L10.4453 4.87891L8.64062 1.24219C8.33984 0.613281 7.41016 0.585938 7.08203 1.24219L5.30469 4.87891L1.28516 5.45312C0.574219 5.5625 0.300781 6.4375 0.820312 6.95703L3.69141 9.77344L3.00781 13.7383C2.89844 14.4492 3.66406 14.9961 4.29297 14.668L7.875 12.7812L11.4297 14.668C12.0586 14.9961 12.8242 14.4492 12.7148 13.7383L12.0312 9.77344L14.9023 6.95703C15.4219 6.4375 15.1484 5.5625 14.4375 5.45312ZM10.6094 9.30859L11.2656 13.082L7.875 11.3047L4.45703 13.082L5.11328 9.30859L2.35156 6.62891L6.15234 6.08203L7.875 2.63672L9.57031 6.08203L13.3711 6.62891L10.6094 9.30859Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </li>
                                    <li><span><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4375 5.45312L10.4453 4.87891L8.64062 1.24219C8.33984 0.613281 7.41016 0.585938 7.08203 1.24219L5.30469 4.87891L1.28516 5.45312C0.574219 5.5625 0.300781 6.4375 0.820312 6.95703L3.69141 9.77344L3.00781 13.7383C2.89844 14.4492 3.66406 14.9961 4.29297 14.668L7.875 12.7812L11.4297 14.668C12.0586 14.9961 12.8242 14.4492 12.7148 13.7383L12.0312 9.77344L14.9023 6.95703C15.4219 6.4375 15.1484 5.5625 14.4375 5.45312ZM10.6094 9.30859L11.2656 13.082L7.875 11.3047L4.45703 13.082L5.11328 9.30859L2.35156 6.62891L6.15234 6.08203L7.875 2.63672L9.57031 6.08203L13.3711 6.62891L10.6094 9.30859Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </li>
                                    <li><span><svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4375 5.45312L10.4453 4.87891L8.64062 1.24219C8.33984 0.613281 7.41016 0.585938 7.08203 1.24219L5.30469 4.87891L1.28516 5.45312C0.574219 5.5625 0.300781 6.4375 0.820312 6.95703L3.69141 9.77344L3.00781 13.7383C2.89844 14.4492 3.66406 14.9961 4.29297 14.668L7.875 12.7812L11.4297 14.668C12.0586 14.9961 12.8242 14.4492 12.7148 13.7383L12.0312 9.77344L14.9023 6.95703C15.4219 6.4375 15.1484 5.5625 14.4375 5.45312ZM10.6094 9.30859L11.2656 13.082L7.875 11.3047L4.45703 13.082L5.11328 9.30859L2.35156 6.62891L6.15234 6.08203L7.875 2.63672L9.57031 6.08203L13.3711 6.62891L10.6094 9.30859Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </li>
                                </ul>
                                <p class="admin__profile--desc">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit.Veritatis distinctio</p>
                                <a class="admin__profile--email" href="mailto:b.gordon@homeid.com">b.gordon@homeid.com</a>
                                <ul class=" profile__social d-flex align-items-center justify-content-center">
                                    <li class="profile__social--list">
                                        <a class="profile__social--icon" target="_blank" href="https://www.facebook.com">
                                            <svg width="10" height="17" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.62891 8.625L8.01172 6.10938H5.57812V4.46875C5.57812 3.75781 5.90625 3.10156 7 3.10156H8.12109V0.941406C8.12109 0.941406 7.10938 0.75 6.15234 0.75C4.15625 0.75 2.84375 1.98047 2.84375 4.16797V6.10938H0.601562V8.625H2.84375V14.75H5.57812V8.625H7.62891Z" fill="currentColor"></path>
                                            </svg>
                                            <span class="visually-hidden">Facebook</span>
                                        </a>
                                    </li>
                                    <li class="profile__social--list">
                                        <a class="profile__social--icon" target="_blank" href="https://twitter.com">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"></path>
                                              </svg>
                                            <span class="visually-hidden">Twitter</span>
                                        </a>
                                    </li>
                                    <li class="profile__social--list">
                                        <a class="profile__social--icon" target="_blank" href="https://www.instagram.com">
                                            <svg width="16" height="16" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.125 3.60547C5.375 3.60547 3.98047 5.02734 3.98047 6.75C3.98047 8.5 5.375 9.89453 7.125 9.89453C8.84766 9.89453 10.2695 8.5 10.2695 6.75C10.2695 5.02734 8.84766 3.60547 7.125 3.60547ZM7.125 8.80078C6.00391 8.80078 5.07422 7.89844 5.07422 6.75C5.07422 5.62891 5.97656 4.72656 7.125 4.72656C8.24609 4.72656 9.14844 5.62891 9.14844 6.75C9.14844 7.89844 8.24609 8.80078 7.125 8.80078ZM11.1172 3.49609C11.1172 3.08594 10.7891 2.75781 10.3789 2.75781C9.96875 2.75781 9.64062 3.08594 9.64062 3.49609C9.64062 3.90625 9.96875 4.23438 10.3789 4.23438C10.7891 4.23438 11.1172 3.90625 11.1172 3.49609ZM13.1953 4.23438C13.1406 3.25 12.9219 2.375 12.2109 1.66406C11.5 0.953125 10.625 0.734375 9.64062 0.679688C8.62891 0.625 5.59375 0.625 4.58203 0.679688C3.59766 0.734375 2.75 0.953125 2.01172 1.66406C1.30078 2.375 1.08203 3.25 1.02734 4.23438C0.972656 5.24609 0.972656 8.28125 1.02734 9.29297C1.08203 10.2773 1.30078 11.125 2.01172 11.8633C2.75 12.5742 3.59766 12.793 4.58203 12.8477C5.59375 12.9023 8.62891 12.9023 9.64062 12.8477C10.625 12.793 11.5 12.5742 12.2109 11.8633C12.9219 11.125 13.1406 10.2773 13.1953 9.29297C13.25 8.28125 13.25 5.24609 13.1953 4.23438ZM11.8828 10.3594C11.6914 10.9062 11.2539 11.3164 10.7344 11.5352C9.91406 11.8633 8 11.7812 7.125 11.7812C6.22266 11.7812 4.30859 11.8633 3.51562 11.5352C2.96875 11.3164 2.55859 10.9062 2.33984 10.3594C2.01172 9.56641 2.09375 7.65234 2.09375 6.75C2.09375 5.875 2.01172 3.96094 2.33984 3.14062C2.55859 2.62109 2.96875 2.21094 3.51562 1.99219C4.30859 1.66406 6.22266 1.74609 7.125 1.74609C8 1.74609 9.91406 1.66406 10.7344 1.99219C11.2539 2.18359 11.6641 2.62109 11.8828 3.14062C12.2109 3.96094 12.1289 5.875 12.1289 6.75C12.1289 7.65234 12.2109 9.56641 11.8828 10.3594Z" fill="currentColor"></path>
                                            </svg>  
                                            <span class="visually-hidden">Instagram</span>
                                        </a>
                                    </li>
                                    <li class="profile__social--list">
                                        <a class="profile__social--icon" target="_blank" href="https://www.pinterest.com">
                                            <svg width="14" height="16" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.6713 6.71093C14.6764 7.71873 14.5406 8.65694 14.2638 9.52555C14.0104 10.394 13.6393 11.146 13.1503 11.7813C12.6612 12.3932 12.0778 12.8883 11.4001 13.2668C10.7222 13.6218 9.97304 13.7897 9.15262 13.7705C8.87149 13.7954 8.59012 13.7734 8.30852 13.7045C8.05023 13.6121 7.80366 13.5196 7.56881 13.427C7.35727 13.3109 7.16906 13.1713 7.00416 13.008C6.83926 12.8448 6.70957 12.6931 6.61511 12.553C6.47736 13.1162 6.36257 13.5856 6.27074 13.961C6.17891 14.3365 6.09838 14.6299 6.02915 14.8412C5.98323 15.0289 5.94879 15.1697 5.92584 15.2636C5.9262 15.3339 5.92632 15.3573 5.9262 15.3339C5.85696 15.5452 5.78767 15.7448 5.71832 15.9326C5.64897 16.1205 5.56796 16.3201 5.47529 16.5315C5.3825 16.7195 5.27793 16.8958 5.16158 17.0605C5.06867 17.225 4.97576 17.3896 4.88285 17.5541C4.60256 17.743 4.38033 17.8262 4.21615 17.8036C4.07553 17.8043 3.95804 17.7463 3.86369 17.6296C3.79278 17.5128 3.74531 17.3959 3.72127 17.2788C3.69736 17.1852 3.68534 17.1266 3.68522 17.1032C3.66094 16.9393 3.64832 16.7635 3.64736 16.576C3.64629 16.3651 3.64527 16.1659 3.64431 15.9784C3.66667 15.7673 3.68902 15.5563 3.71138 15.3452C3.75718 15.1341 3.80309 14.9463 3.84913 14.782C3.84901 14.7586 3.86037 14.6882 3.8832 14.5709C3.92936 14.43 3.99829 14.1602 4.09 13.7612C4.18159 13.3389 4.30756 12.764 4.46791 12.0366C4.62825 11.3092 4.84599 10.3472 5.12112 9.15044C5.05009 9.01017 4.9906 8.8347 4.94264 8.624C4.89469 8.41331 4.85863 8.23771 4.83448 8.0972C4.8102 7.93326 4.79776 7.7927 4.79716 7.67551C4.79657 7.55833 4.79633 7.51145 4.79645 7.53489C4.79441 7.13646 4.83948 6.78466 4.93167 6.4795C5.04718 6.15078 5.18637 5.86881 5.34923 5.6336C5.53541 5.37483 5.74538 5.18626 5.97915 5.06787C6.23624 4.92593 6.49363 4.84258 6.75132 4.81782C6.98581 4.84006 7.18527 4.88592 7.34969 4.95539C7.53755 5.02474 7.69049 5.14115 7.80851 5.30461C7.92654 5.46807 8.00947 5.64343 8.0573 5.83069C8.12845 5.99439 8.16463 6.19342 8.16583 6.4278C8.16691 6.63873 8.13307 6.89672 8.06432 7.20176C7.99544 7.48337 7.91491 7.77675 7.82272 8.08192C7.73053 8.38708 7.62674 8.71574 7.51135 9.0679C7.41928 9.3965 7.33887 9.71332 7.27012 10.0184C7.20137 10.3234 7.19103 10.593 7.2391 10.8271C7.31049 11.0377 7.41704 11.2481 7.55874 11.4583C7.72376 11.645 7.92369 11.7846 8.15854 11.8771C8.3934 11.9697 8.63979 12.027 8.89771 12.0491C9.38978 12.0232 9.8343 11.8686 10.2313 11.5853C10.6283 11.302 10.9661 10.9018 11.2447 10.3848C11.5467 9.86758 11.7665 9.29223 11.9038 8.65871C12.0646 8.00163 12.1429 7.28637 12.139 6.51294C12.1362 5.97389 12.0398 5.45875 11.8498 4.96753C11.6598 4.47631 11.3765 4.06759 10.9998 3.74139C10.6464 3.39163 10.1997 3.11266 9.65954 2.90449C9.14285 2.69619 8.533 2.60556 7.83 2.63259C7.05646 2.61311 6.354 2.74561 5.72263 3.03009C5.11471 3.31446 4.58923 3.68043 4.1462 4.12802C3.70317 4.5756 3.36603 5.10467 3.13477 5.71524C2.9034 6.30237 2.78933 6.91234 2.79257 7.54514C2.79388 7.80295 2.80674 8.02554 2.83114 8.21292C2.87885 8.37674 2.92662 8.55228 2.97446 8.73954C3.04561 8.90324 3.1167 9.05522 3.18773 9.19548C3.28208 9.31219 3.38827 9.45227 3.50629 9.61574C3.55329 9.63893 3.58868 9.68563 3.61248 9.75582C3.63615 9.80257 3.64805 9.83767 3.64817 9.86111C3.67173 9.88442 3.68369 9.93124 3.68405 10.0015C3.68429 10.0484 3.67281 10.0954 3.64961 10.1424C3.62653 10.2128 3.60346 10.2832 3.58038 10.3536C3.58062 10.4005 3.56926 10.4709 3.5463 10.5648C3.52334 10.6586 3.50033 10.7408 3.47725 10.8112C3.45405 10.8582 3.44263 10.9169 3.44299 10.9872C3.4198 11.0342 3.38494 11.0929 3.33842 11.1635C3.31523 11.2105 3.28025 11.2458 3.2335 11.2695C3.18662 11.2697 3.13981 11.2817 3.09305 11.3054C3.04618 11.3056 2.98747 11.2825 2.91691 11.236C2.56464 11.0971 2.24722 10.8995 1.96465 10.6432C1.7054 10.3632 1.49291 10.0596 1.32717 9.73235C1.16143 9.40507 1.03061 9.03073 0.934703 8.60934C0.838796 8.18795 0.789764 7.76633 0.787606 7.34446C0.78377 6.59447 0.932275 5.8437 1.23312 5.09215C1.55741 4.34048 2.02261 3.64668 2.62874 3.01076C3.23487 2.37484 3.99401 1.86705 4.90614 1.48737C5.81815 1.08427 6.88346 0.867877 8.10208 0.838206C9.08656 0.856608 9.97807 1.02783 10.7766 1.35188C11.5985 1.65236 12.2921 2.08241 12.8575 2.64203C13.4228 3.20165 13.8597 3.83223 14.1679 4.53379C14.4995 5.21179 14.6673 5.9375 14.6713 6.71093Z" fill="currentColor"></path>
                                                </svg>
                                            <span class="visually-hidden">Pinterest</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog__widget--step widget__search mb-30">
                            <h2 class="widget__step--title">Send Messege</h2>
                            <div class="widget__search--input position-relative">
                                <input class="widget__search--input__field" placeholder="Search product" type="text">
                                <button class="widget__search--btn"><svg width="16" height="17" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.10714 9.54464C9.89286 8.75893 10.2857 7.81548 10.2857 6.71429C10.2857 5.61309 9.89286 4.67262 9.10714 3.89286C8.32738 3.10714 7.38691 2.71428 6.28571 2.71428C5.18452 2.71428 4.24107 3.10714 3.45536 3.89286C2.6756 4.67262 2.28571 5.61309 2.28571 6.71429C2.28571 7.81548 2.6756 8.75893 3.45536 9.54464C4.24107 10.3244 5.18452 10.7143 6.28571 10.7143C7.38691 10.7143 8.32738 10.3244 9.10714 9.54464ZM14.8571 14.1429C14.8571 14.4524 14.744 14.7202 14.5179 14.9464C14.2917 15.1726 14.0238 15.2857 13.7143 15.2857C13.3929 15.2857 13.125 15.1726 12.9107 14.9464L9.84822 11.8929C8.78274 12.631 7.59524 13 6.28571 13C5.43452 13 4.61905 12.8363 3.83929 12.5089C3.06548 12.1756 2.39583 11.7292 1.83036 11.1696C1.27083 10.6042 0.824405 9.93452 0.491071 9.16071C0.16369 8.38095 0 7.56548 0 6.71429C0 5.86309 0.16369 5.05059 0.491071 4.27678C0.824405 3.49702 1.27083 2.82738 1.83036 2.26786C2.39583 1.70238 3.06548 1.25595 3.83929 0.928571C4.61905 0.595237 5.43452 0.428571 6.28571 0.428571C7.13691 0.428571 7.94941 0.595237 8.72322 0.928571C9.50298 1.25595 10.1726 1.70238 10.7321 2.26786C11.2976 2.82738 11.744 3.49702 12.0714 4.27678C12.4048 5.05059 12.5714 5.86309 12.5714 6.71429C12.5714 8.02381 12.2024 9.21131 11.4643 10.2768L14.5268 13.3393C14.747 13.5595 14.8571 13.8274 14.8571 14.1429Z" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="blog__widget--step mb-30">
                            <h2 class="widget__step--title">Featured Items</h2>
                            <div class="widget__featured">
                                <div class="widget__featured--items d-flex">
                                    <div class="widget__featured--thumb">
                                        <a class="widget__featured--thumb__link" href="./blog-details.html"><img class="widget__featured--media" src="./assets/img/property/featured1.jpg" alt="img"></a>
                                    </div>
                                    <div class="widget__featured--content">
                                        <span class="widget__featured--date"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5332 13H3.7832V10.75H1.5332V13ZM4.2832 13H6.7832V10.75H4.2832V13ZM1.5332 10.25H3.7832V7.75H1.5332V10.25ZM4.2832 10.25H6.7832V7.75H4.2832V10.25ZM1.5332 7.25H3.7832V5H1.5332V7.25ZM7.2832 13H9.7832V10.75H7.2832V13ZM4.2832 7.25H6.7832V5H4.2832V7.25ZM10.2832 13H12.5332V10.75H10.2832V13ZM7.2832 10.25H9.7832V7.75H7.2832V10.25ZM4.5332 3.5V1.25C4.5332 1.18229 4.50716 1.125 4.45508 1.07812C4.4082 1.02604 4.35091 0.999999 4.2832 0.999999H3.7832C3.71549 0.999999 3.6556 1.02604 3.60352 1.07812C3.55664 1.125 3.5332 1.18229 3.5332 1.25V3.5C3.5332 3.56771 3.55664 3.6276 3.60352 3.67969C3.6556 3.72656 3.71549 3.75 3.7832 3.75H4.2832C4.35091 3.75 4.4082 3.72656 4.45508 3.67969C4.50716 3.6276 4.5332 3.56771 4.5332 3.5ZM10.2832 10.25H12.5332V7.75H10.2832V10.25ZM7.2832 7.25H9.7832V5H7.2832V7.25ZM10.2832 7.25H12.5332V5H10.2832V7.25ZM10.5332 3.5V1.25C10.5332 1.18229 10.5072 1.125 10.4551 1.07812C10.4082 1.02604 10.3509 0.999999 10.2832 0.999999H9.7832C9.7155 0.999999 9.6556 1.02604 9.60352 1.07812C9.55664 1.125 9.5332 1.18229 9.5332 1.25V3.5C9.5332 3.56771 9.55664 3.6276 9.60352 3.67969C9.6556 3.72656 9.7155 3.75 9.7832 3.75H10.2832C10.3509 3.75 10.4082 3.72656 10.4551 3.67969C10.5072 3.6276 10.5332 3.56771 10.5332 3.5ZM13.5332 3V13C13.5332 13.2708 13.4342 13.5052 13.2363 13.7031C13.0384 13.901 12.804 14 12.5332 14H1.5332C1.26237 14 1.02799 13.901 0.830078 13.7031C0.632161 13.5052 0.533203 13.2708 0.533203 13V3C0.533203 2.72917 0.632161 2.49479 0.830078 2.29687C1.02799 2.09896 1.26237 2 1.5332 2H2.5332V1.25C2.5332 0.906249 2.6556 0.611978 2.90039 0.367187C3.14518 0.122395 3.43945 -9.53674e-07 3.7832 -9.53674e-07H4.2832C4.62695 -9.53674e-07 4.92122 0.122395 5.16602 0.367187C5.41081 0.611978 5.5332 0.906249 5.5332 1.25V2H8.5332V1.25C8.5332 0.906249 8.6556 0.611978 8.90039 0.367187C9.14518 0.122395 9.43945 -9.53674e-07 9.7832 -9.53674e-07H10.2832C10.627 -9.53674e-07 10.9212 0.122395 11.166 0.367187C11.4108 0.611978 11.5332 0.906249 11.5332 1.25V2H12.5332C12.804 2 13.0384 2.09896 13.2363 2.29687C13.4342 2.49479 13.5332 2.72917 13.5332 3Z" fill="#FA4A4A"></path>
                                            </svg>
                                             Jan 01,2024</span>
                                        <h3 class="widget__featured--title m-0"><a href="./blog-details.html">Budget Issues Force The Our To Become</a></h3>
                                        
                                    </div>
                                </div>
                                <div class="widget__featured--items d-flex">
                                    <div class="widget__featured--thumb">
                                        <a class="widget__featured--thumb__link" href="./listing-details.html"><img class="widget__featured--media" src="./assets/img/property/featured2.jpg" alt="img"></a>
                                    </div>
                                    <div class="widget__featured--content">
                                        <span class="widget__featured--date"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5332 13H3.7832V10.75H1.5332V13ZM4.2832 13H6.7832V10.75H4.2832V13ZM1.5332 10.25H3.7832V7.75H1.5332V10.25ZM4.2832 10.25H6.7832V7.75H4.2832V10.25ZM1.5332 7.25H3.7832V5H1.5332V7.25ZM7.2832 13H9.7832V10.75H7.2832V13ZM4.2832 7.25H6.7832V5H4.2832V7.25ZM10.2832 13H12.5332V10.75H10.2832V13ZM7.2832 10.25H9.7832V7.75H7.2832V10.25ZM4.5332 3.5V1.25C4.5332 1.18229 4.50716 1.125 4.45508 1.07812C4.4082 1.02604 4.35091 0.999999 4.2832 0.999999H3.7832C3.71549 0.999999 3.6556 1.02604 3.60352 1.07812C3.55664 1.125 3.5332 1.18229 3.5332 1.25V3.5C3.5332 3.56771 3.55664 3.6276 3.60352 3.67969C3.6556 3.72656 3.71549 3.75 3.7832 3.75H4.2832C4.35091 3.75 4.4082 3.72656 4.45508 3.67969C4.50716 3.6276 4.5332 3.56771 4.5332 3.5ZM10.2832 10.25H12.5332V7.75H10.2832V10.25ZM7.2832 7.25H9.7832V5H7.2832V7.25ZM10.2832 7.25H12.5332V5H10.2832V7.25ZM10.5332 3.5V1.25C10.5332 1.18229 10.5072 1.125 10.4551 1.07812C10.4082 1.02604 10.3509 0.999999 10.2832 0.999999H9.7832C9.7155 0.999999 9.6556 1.02604 9.60352 1.07812C9.55664 1.125 9.5332 1.18229 9.5332 1.25V3.5C9.5332 3.56771 9.55664 3.6276 9.60352 3.67969C9.6556 3.72656 9.7155 3.75 9.7832 3.75H10.2832C10.3509 3.75 10.4082 3.72656 10.4551 3.67969C10.5072 3.6276 10.5332 3.56771 10.5332 3.5ZM13.5332 3V13C13.5332 13.2708 13.4342 13.5052 13.2363 13.7031C13.0384 13.901 12.804 14 12.5332 14H1.5332C1.26237 14 1.02799 13.901 0.830078 13.7031C0.632161 13.5052 0.533203 13.2708 0.533203 13V3C0.533203 2.72917 0.632161 2.49479 0.830078 2.29687C1.02799 2.09896 1.26237 2 1.5332 2H2.5332V1.25C2.5332 0.906249 2.6556 0.611978 2.90039 0.367187C3.14518 0.122395 3.43945 -9.53674e-07 3.7832 -9.53674e-07H4.2832C4.62695 -9.53674e-07 4.92122 0.122395 5.16602 0.367187C5.41081 0.611978 5.5332 0.906249 5.5332 1.25V2H8.5332V1.25C8.5332 0.906249 8.6556 0.611978 8.90039 0.367187C9.14518 0.122395 9.43945 -9.53674e-07 9.7832 -9.53674e-07H10.2832C10.627 -9.53674e-07 10.9212 0.122395 11.166 0.367187C11.4108 0.611978 11.5332 0.906249 11.5332 1.25V2H12.5332C12.804 2 13.0384 2.09896 13.2363 2.29687C13.4342 2.49479 13.5332 2.72917 13.5332 3Z" fill="#FA4A4A"></path>
                                            </svg>
                                             Jan 01,2024</span>
                                        <h3 class="widget__featured--title m-0"><a href="./listing-details.html">tos lobortis des mollis ut risus</a></h3>
                                    </div>
                                </div>
                                <div class="widget__featured--items d-flex">
                                    <div class="widget__featured--thumb">
                                        <a class="widget__featured--thumb__link" href="./listing-details.html"><img class="widget__featured--media" src="./assets/img/property/featured3.jpg" alt="img"></a>
                                    </div>
                                    <div class="widget__featured--content">
                                        <span class="widget__featured--date"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5332 13H3.7832V10.75H1.5332V13ZM4.2832 13H6.7832V10.75H4.2832V13ZM1.5332 10.25H3.7832V7.75H1.5332V10.25ZM4.2832 10.25H6.7832V7.75H4.2832V10.25ZM1.5332 7.25H3.7832V5H1.5332V7.25ZM7.2832 13H9.7832V10.75H7.2832V13ZM4.2832 7.25H6.7832V5H4.2832V7.25ZM10.2832 13H12.5332V10.75H10.2832V13ZM7.2832 10.25H9.7832V7.75H7.2832V10.25ZM4.5332 3.5V1.25C4.5332 1.18229 4.50716 1.125 4.45508 1.07812C4.4082 1.02604 4.35091 0.999999 4.2832 0.999999H3.7832C3.71549 0.999999 3.6556 1.02604 3.60352 1.07812C3.55664 1.125 3.5332 1.18229 3.5332 1.25V3.5C3.5332 3.56771 3.55664 3.6276 3.60352 3.67969C3.6556 3.72656 3.71549 3.75 3.7832 3.75H4.2832C4.35091 3.75 4.4082 3.72656 4.45508 3.67969C4.50716 3.6276 4.5332 3.56771 4.5332 3.5ZM10.2832 10.25H12.5332V7.75H10.2832V10.25ZM7.2832 7.25H9.7832V5H7.2832V7.25ZM10.2832 7.25H12.5332V5H10.2832V7.25ZM10.5332 3.5V1.25C10.5332 1.18229 10.5072 1.125 10.4551 1.07812C10.4082 1.02604 10.3509 0.999999 10.2832 0.999999H9.7832C9.7155 0.999999 9.6556 1.02604 9.60352 1.07812C9.55664 1.125 9.5332 1.18229 9.5332 1.25V3.5C9.5332 3.56771 9.55664 3.6276 9.60352 3.67969C9.6556 3.72656 9.7155 3.75 9.7832 3.75H10.2832C10.3509 3.75 10.4082 3.72656 10.4551 3.67969C10.5072 3.6276 10.5332 3.56771 10.5332 3.5ZM13.5332 3V13C13.5332 13.2708 13.4342 13.5052 13.2363 13.7031C13.0384 13.901 12.804 14 12.5332 14H1.5332C1.26237 14 1.02799 13.901 0.830078 13.7031C0.632161 13.5052 0.533203 13.2708 0.533203 13V3C0.533203 2.72917 0.632161 2.49479 0.830078 2.29687C1.02799 2.09896 1.26237 2 1.5332 2H2.5332V1.25C2.5332 0.906249 2.6556 0.611978 2.90039 0.367187C3.14518 0.122395 3.43945 -9.53674e-07 3.7832 -9.53674e-07H4.2832C4.62695 -9.53674e-07 4.92122 0.122395 5.16602 0.367187C5.41081 0.611978 5.5332 0.906249 5.5332 1.25V2H8.5332V1.25C8.5332 0.906249 8.6556 0.611978 8.90039 0.367187C9.14518 0.122395 9.43945 -9.53674e-07 9.7832 -9.53674e-07H10.2832C10.627 -9.53674e-07 10.9212 0.122395 11.166 0.367187C11.4108 0.611978 11.5332 0.906249 11.5332 1.25V2H12.5332C12.804 2 13.0384 2.09896 13.2363 2.29687C13.4342 2.49479 13.5332 2.72917 13.5332 3Z" fill="#FA4A4A"></path>
                                            </svg>
                                             Jan 01,2024</span>
                                        <h3 class="widget__featured--title m-0"><a href="./listing-details.html">ut labore et dolore magna aliqua.</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog__widget--step mb-30">
                            <h2 class="widget__step--title">Catagories</h2>
                            <ul class="widget__catagories--menu">
                                <li class="widget__catagories--items">
                                    <a class="widget__catagories--link d-flex align-items-center justify-content-between" href="#">
                                        <span class="widget__catagories--menu__text">Modern Villa</span>
                                        <span class="widget__catagories--menu__text">03</span>
                                    </a>
                                </li>
                                <li class="widget__catagories--items">
                                    <a class="widget__catagories--link d-flex align-items-center justify-content-between" href="#">
                                        <span class="widget__catagories--menu__text">Houses</span>
                                        <span class="widget__catagories--menu__text">05</span>
                                    </a>
                                </li>
                                <li class="widget__catagories--items">
                                    <a class="widget__catagories--link d-flex align-items-center justify-content-between" href="#">
                                        <span class="widget__catagories--menu__text">Apartments</span>
                                        <span class="widget__catagories--menu__text">04</span>
                                    </a>
                                </li>
                                <li class="widget__catagories--items">
                                    <a class="widget__catagories--link d-flex align-items-center justify-content-between" href="#">
                                        <span class="widget__catagories--menu__text">Office</span>
                                        <span class="widget__catagories--menu__text">06</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="blog__widget--step">
                            <h2 class="widget__step--title">Populer Tags</h2>
                            <ul class="widget__tag d-flex">
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Apartment</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Houses</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Duplex</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Container Home</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Villa Type</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Cosmetics</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Condo</a>
                                </li>
                                <li class="widget__tag--list">
                                    <a class="widget__tag--link" href="./blog-details.html">Town House</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
 
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    jQuery(document).ready(function ($) {
        $('[id^="commentForm_"]').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            var formId = $(this).attr('id'); // Get the ID of the form being submitted
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            const formData = new FormData(this);
            $.ajax({ 
                type: 'POST',
                url: '{{ route("comments.store") }}',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success("Comment submitted successfully");
                    setTimeout(function() {
                        window.location.reload(); 
                    }, 2000); 
        
                    $('#' + formId)[0].reset(); 
                },
                error: function(error) {
                    toastr.error('Enter the input details');
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


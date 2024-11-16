@extends('layouts.app')

@section('content')


    <!-- Breadcrumb section -->
    <section class="breadcrumb__section section--padding">
        <div class="container">
            <div class="breadcrumb__content text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                <h1 class="breadcrumb__title h2">
                    <span>Blog </span>
                    Page
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
                        <span class="breadcrumb__menu--text">Blog  </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Breadcrumb section .\ -->
           

    <!-- Blog section -->
    <section class="blog__section section--padding pt-20">
        <div class="container">
            <div class="section__heading text-center mb-50" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                <h3 class="section__heading--subtitle h5"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_15_6)">
                    <path d="M9.00021 4.72925L2.5806 10.0215C2.5806 10.029 2.57872 10.04 2.57497 10.055C2.57129 10.0698 2.56934 10.0806 2.56934 10.0883V15.4473C2.56934 15.6408 2.64008 15.8085 2.78152 15.9497C2.92292 16.091 3.09037 16.1621 3.2839 16.1621H7.571V11.8747H10.4295V16.1622H14.7165C14.91 16.1622 15.0777 16.0913 15.2189 15.9497C15.3603 15.8086 15.4313 15.6408 15.4313 15.4473V10.0883C15.4313 10.0586 15.4272 10.0361 15.4201 10.0215L9.00021 4.72925Z" fill="#47008E"/>
                    <path d="M17.8758 8.81572L15.4309 6.78374V2.2285C15.4309 2.12437 15.3974 2.03872 15.3302 1.9717C15.2636 1.90475 15.178 1.87128 15.0736 1.87128H12.93C12.8258 1.87128 12.7401 1.90475 12.6731 1.9717C12.6062 2.03872 12.5727 2.1244 12.5727 2.2285V4.4056L9.8486 2.12792C9.61069 1.93439 9.3278 1.83765 9.00026 1.83765C8.67275 1.83765 8.3899 1.93439 8.15175 2.12792L0.124063 8.81572C0.0496462 8.87516 0.00885955 8.95517 0.00127316 9.05567C-0.00627412 9.15609 0.0197308 9.2438 0.079366 9.31818L0.771565 10.1444C0.831201 10.2113 0.909254 10.2523 1.00604 10.2673C1.09539 10.2748 1.18475 10.2486 1.27411 10.1891L9.00002 3.74687L16.726 10.1891C16.7857 10.241 16.8637 10.2669 16.9605 10.2669H16.994C17.0907 10.2522 17.1686 10.211 17.2285 10.1442L17.9208 9.31814C17.9803 9.2436 18.0064 9.15605 17.9987 9.05551C17.991 8.95528 17.9501 8.87527 17.8758 8.81572Z" fill="#47008E"/>
                    </g>
                    <defs>
                    <clipPath >
                    <rect width="18" height="18" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    Latest news & articles
                </h3>
                <h2 class="section__heading--title">Latest blog</h2>
            </div>
            <div class="blog__inner blog__column3 swiper" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                <div class="swiper-wrapper">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-4 mb-4">
                                <div>
                                    <article class="blog__items">
                                        <div class="blog__thumbnail position-relative">
                                            <a href="{{ route('blog.details', encrypt($post->id)) }}">
                                                <img class="blog__thumbnail--media" src="{{ asset($post->image) }}" alt="{{ $post->title }}" style=" width: 500px; height: 400px; object-fit: cover; ">
                                            </a>
                                            <span class="blog__badge">
                                                <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M13.7001..." fill="currentColor"></path>
                                                </svg>
                                                {{ $post->category }} 
                                            </span>
                                        </div>
                                        <div class="blog__content">
                                            <ul class="blog__meta d-flex">
                                                <li class="blog__meta--list d-flex align-items-center">
                                                    <span class="blog__meta--icon">
                                                        <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 13.0469H3.25V..." fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                    <span class="blog__meta--date">{{ $post->created_at->format('d M Y') }}</span>
                                                </li>
                                                <li class="blog__meta--list d-flex align-items-center">
                                                    <span class="blog__meta--icon">
                                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M9.37483 2.17857C..." fill="currentColor"></path>
                                                        </svg> 
                                                    </span>
                                                    <span class="blog__meta--date">Comments ({{ $post->comments->count()}})</span>
                                                </li>
                                            </ul>
                                            <h3 class="blog__title">
                                                <a href="{{ route('blog.details',  encrypt($post->id)) }}">{{ $post->title }}</a>
                                            </h3> 
                                            <p class="blog__desc">{!! Str::limit($post->content, 80) !!}</p>
                                            <a class="blog__link--btn" href="{{ route('blog.details', encrypt($post->id)) }}">
                                                Read More 
                                                <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1_2454)">
                                                        <path d="M9.94799..." fill="currentColor"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
              
            </div>
        </div>
    </section>
    <!-- Blog section .\ -->
       
 
@endsection

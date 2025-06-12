@extends('layouts.app')

@section('content')


            <!-- Breadcrumb section -->
            <section class="breadcrumb__section section--padding">
                <div class="container">
                    <div class="breadcrumb__content text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                        <h1 class="breadcrumb__title h2">
                            <span>About </span>
                        </h1>
                        <ul class="breadcrumb__menu d-flex justify-content-center">
                            <li class="breadcrumb__menu--items">
                                <a class="breadcrumb__menu--link" href="#">Home</a>
                            </li>
                            <li>
                                <span>
                                    <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"/>
                                    </svg>
                                </span>
                            </li>
                            <li>
                                <span class="breadcrumb__menu--text">About  </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- Breadcrumb section .\ -->
            <!-- About section -->
            <section class="about__section about__page--section section--padding">
                <div class="container">
                    <div class="about__inner d-flex">
                        <div class="about__thumbnail position-relative" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                            <div class="about__thumbnail--list one position-relative">
                                <img src="{{ asset($about->image)}}" alt="about-thumb">
                                
                            </div>
                            
                        </div>
                        <div class="about__content" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                            <div class="section__heading" style="text-align: justify">
                                <h3 class="section__heading--subtitle h5">
                                   {{$about->title}}
                                </h3>
                                {{-- <h2 class="section__heading--title">Dream living Spaces Setting New Build</h2> --}}
                                <p class="section__heading--desc">
                                    {!! $about->content !!} 
                                </p>
                            </div>
                           
                            {{-- <div class="about__content--details d-flex align-items-center">
                               
                                <div class="living__details--content__wrapper">
                                    <p class="living__details--content__list">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.5 0.25C3.95 0.25 0.25 3.95 0.25 8.5C0.25 13.05 3.95 16.75 8.5 16.75C13.05 16.75 16.75 13.05 16.75 8.5C16.75 3.95 13.05 0.25 8.5 0.25ZM8.5 15.25C4.775 15.25 1.75 12.225 1.75 8.5C1.75 4.775 4.775 1.75 8.5 1.75C12.225 1.75 15.25 4.775 15.25 8.5C15.25 12.225 12.225 15.25 8.5 15.25Z" fill="#F23B3B"/>
                                            <path d="M11.625 5.97505L7.525 9.87505L5.4 7.75005C5.1 7.45005 4.625 7.45005 4.35 7.75005C4.05 8.05005 4.05 8.52505 4.35 8.80005L7 11.45C7.15 11.6 7.35 11.675 7.525 11.675C7.7 11.675 7.9 11.6 8.05 11.475L12.675 7.07505C12.975 6.80005 12.975 6.32505 12.7 6.02505C12.4 5.70005 11.925 5.70005 11.625 5.97505Z" fill="#F23B3B"/>
                                        </svg>
                                        Living rooms are pre-wired for Surround
                                
                                    </p>
                                    <p class="living__details--content__list">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.5 0.25C3.95 0.25 0.25 3.95 0.25 8.5C0.25 13.05 3.95 16.75 8.5 16.75C13.05 16.75 16.75 13.05 16.75 8.5C16.75 3.95 13.05 0.25 8.5 0.25ZM8.5 15.25C4.775 15.25 1.75 12.225 1.75 8.5C1.75 4.775 4.775 1.75 8.5 1.75C12.225 1.75 15.25 4.775 15.25 8.5C15.25 12.225 12.225 15.25 8.5 15.25Z" fill="#F23B3B"/>
                                            <path d="M11.625 5.97505L7.525 9.87505L5.4 7.75005C5.1 7.45005 4.625 7.45005 4.35 7.75005C4.05 8.05005 4.05 8.52505 4.35 8.80005L7 11.45C7.15 11.6 7.35 11.675 7.525 11.675C7.7 11.675 7.9 11.6 8.05 11.475L12.675 7.07505C12.975 6.80005 12.975 6.32505 12.7 6.02505C12.4 5.70005 11.925 5.70005 11.625 5.97505Z" fill="#F23B3B"/>
                                        </svg>
                                        Luxurious interior design and amenities
                                
                                    </p>
                                    <p class="living__details--content__list">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.5 0.25C3.95 0.25 0.25 3.95 0.25 8.5C0.25 13.05 3.95 16.75 8.5 16.75C13.05 16.75 16.75 13.05 16.75 8.5C16.75 3.95 13.05 0.25 8.5 0.25ZM8.5 15.25C4.775 15.25 1.75 12.225 1.75 8.5C1.75 4.775 4.775 1.75 8.5 1.75C12.225 1.75 15.25 4.775 15.25 8.5C15.25 12.225 12.225 15.25 8.5 15.25Z" fill="#F23B3B"/>
                                            <path d="M11.625 5.97505L7.525 9.87505L5.4 7.75005C5.1 7.45005 4.625 7.45005 4.35 7.75005C4.05 8.05005 4.05 8.52505 4.35 8.80005L7 11.45C7.15 11.6 7.35 11.675 7.525 11.675C7.7 11.675 7.9 11.6 8.05 11.475L12.675 7.07505C12.975 6.80005 12.975 6.32505 12.7 6.02505C12.4 5.70005 11.925 5.70005 11.625 5.97505Z" fill="#F23B3B"/>
                                        </svg>
                                        Nestled in the Buckhead
                                
                                    </p>
                                </div>
                            </div> --}}
                            {{-- <div class="about__content--footer d-flex align-items-center">
                                <a class="solid__btn" href="about.html">More about us</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </section>
            <!-- About section .\ -->

            <section class="categories__section categories__bg section--padding">
                <div class="container">
                  
                    <div class="categories__inner row mb--n30">
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-30 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                            <div class="categories__box">
                                
                                <div class="categories__content text-center">
                                    <h3 class="categories__title">Vision</h3>
                                    <p class="categories__desc">
                                        {{$visionMission->vision}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-30 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                            <div class="categories__box">
                                <div class="categories__content text-center">
                                    <h3 class="categories__title">Mission</h3>
                                    <p class="categories__desc">
                                        {{$visionMission->mission}}
                                    </p>
                                 
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

            <section class="contact__section ">
            <div class="container">
                <div class="contact__inner">
                    <div class="contact__wrapper mt-50 mb-50 d-flex justify-content-center ">
                        <div class="contact__us--map aos-init aos-animate " data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                            <div class="accordion accordion-flush " id="accordionFlushExample">
                            <div class="row align-items-center ">
                                    <div class="col-6">
                                        <h2>The One Property Investment You Truly Need!</h2>
                                        <p>Start Monetizing Your Castle Today!</p>
                                        <div class="row">
                                            <div class="col-4">
                                                <img class="https://apps.apple.com/us/app/dohmayn-technologies-limited/id6745321723" src="{{ asset('assets/img/button/AppStore2.png') }}" alt="APPSTORE" >
                                            </div>
                                            <div class="col-4">
                                                <img class="https://play.google.com/store/apps/details?id=com.dohmayntechnologieslimited.dohmayn" src="{{ asset('assets/img/button/GooglePlay2.png') }}" alt="PlaySTORE" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img class="" src="{{ asset('assets/img/button/AppMockUp.png') }}" alt="DOHMAYN APP" >

                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                </div>
            </div>
        </section>
            
        
            <!-- Testimonial section -->
            <section class="testimonial__section section--padding">
                <div class="container">
                    <div class="section__heading text-center mb-20" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                      
                        <h2 class="section__heading--title">Client’s Feedback</h2>
                    </div>
                    <div class="testimonial__container position-relative" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="150">
                        <div class="testimonial__inner testimonial__swiper--column2 swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="testimonial__card">
                                        <div class="testimonial__card--top d-flex justify-content-between">
                                            <div class="testimonial__author d-flex align-items-center">
                                                <div class="testimonial__author--thumbnail">
                                                    <img src="./assets/img/other/testimonial-author-thumb3.png" alt="img">
                                                </div>
                                                <div class="testimonial__author--content">
                                                    <h3 class="testimonial__author--name">Cameron Williamson</h3>
                                                    <span class="testimonial__author--subtitle">Ceo & Founder</span>
                                                </div>
                                            </div>
                                            <span class="testimonial__icon">
                                                <svg width="56" height="41" viewBox="0 0 56 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8311 21.1016C17.9536 21.1016 18.0759 21.1354 18.1817 21.2039C18.3821 21.3311 18.4933 21.5575 18.4689 21.7902C18.1183 25.181 17.2177 28.3412 15.7918 31.1837C14.5318 33.6944 12.8821 35.8983 10.864 37.7716C20.7152 32.6251 24.7246 21.6445 23.3721 12.7732C22.5228 7.20455 19.1356 1.25311 12.1763 1.25311C6.17002 1.25308 1.28225 6.02976 1.28225 11.9008C1.28236 17.7707 6.16997 22.5474 12.1763 22.5474C14.0486 22.5473 15.8941 22.0753 17.5159 21.1821C17.6139 21.1277 17.723 21.1017 17.8311 21.1016L17.8311 21.1016ZM6.69995 40.7565C6.45388 40.7565 6.22235 40.6173 6.11549 40.39C5.98301 40.1038 6.08656 39.7655 6.35926 39.598C13.747 35.0813 16.2827 28.1824 17.053 22.8063C15.5225 23.4589 13.8584 23.8006 12.1765 23.8006C5.46212 23.8005 0 18.4615 0 11.9008C0.00010793 5.33901 5.4621 2.89626e-09 12.1765 2.89626e-09C15.527 -7.02862e-05 18.4723 1.27924 20.694 3.6986C22.7266 5.91116 24.0913 8.98545 24.64 12.5894C26.2563 23.1859 20.5827 36.6501 6.88693 40.7294C6.82457 40.7478 6.7611 40.7566 6.69997 40.7565L6.69995 40.7565Z" fill="#FF4638"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.9217 21.1017C49.0442 21.1017 49.1666 21.1354 49.2735 21.2039C49.4739 21.3311 49.584 21.5575 49.5607 21.7902C49.21 25.181 48.3084 28.3412 46.8825 31.1837C45.6226 33.6944 43.9739 35.8984 41.9558 37.7716C51.8048 32.6251 55.8152 21.6445 54.4628 12.7732C53.6136 7.20455 50.2274 1.25311 43.2682 1.25311C37.2607 1.25308 32.3741 6.02976 32.3741 11.9008C32.3742 17.7707 37.2607 22.5474 43.2682 22.5474C45.1394 22.5473 46.986 22.0753 48.6079 21.1821C48.7059 21.1277 48.8137 21.1017 48.9217 21.1017L48.9217 21.1017ZM37.7906 40.7565C37.5446 40.7565 37.313 40.6173 37.2073 40.39C37.0738 40.1039 37.1783 39.7656 37.4499 39.5981C44.8389 35.0814 47.3734 28.1824 48.1436 22.8063C46.6132 23.4589 44.9501 23.8006 43.2682 23.8006C36.5539 23.8005 31.0918 18.4615 31.0918 11.9008C31.0919 5.33901 36.5539 2.89626e-09 43.2682 2.89626e-09C46.6176 -7.02862e-05 49.5629 1.27924 51.7847 3.6986C53.8173 5.91116 55.1819 8.98545 55.7318 12.5883C57.347 23.1859 51.6734 36.6501 37.9776 40.7294C37.9153 40.7478 37.8529 40.7566 37.7906 40.7565V40.7565Z" fill="#FF4638"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="testimonial__desc">The most advanced revenue than this. Iwill refer everyone 
                                        I like Level more and more each day because it makes my
                                        easier. It really saves me time and effort. Level is exactly
                                        business has been lacking.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial__card">
                                        <div class="testimonial__card--top d-flex justify-content-between">
                                            <div class="testimonial__author d-flex align-items-center">
                                                <div class="testimonial__author--thumbnail">
                                                    <img src="./assets/img/other/testimonial-author-thumb2.png" alt="img">
                                                </div>
                                                <div class="testimonial__author--content">
                                                    <h3 class="testimonial__author--name">Cameron Williamson</h3>
                                                    <span class="testimonial__author--subtitle">Ceo & Founder</span>
                                                </div>
                                            </div>
                                            <span class="testimonial__icon">
                                                <svg width="56" height="41" viewBox="0 0 56 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8311 21.1016C17.9536 21.1016 18.0759 21.1354 18.1817 21.2039C18.3821 21.3311 18.4933 21.5575 18.4689 21.7902C18.1183 25.181 17.2177 28.3412 15.7918 31.1837C14.5318 33.6944 12.8821 35.8983 10.864 37.7716C20.7152 32.6251 24.7246 21.6445 23.3721 12.7732C22.5228 7.20455 19.1356 1.25311 12.1763 1.25311C6.17002 1.25308 1.28225 6.02976 1.28225 11.9008C1.28236 17.7707 6.16997 22.5474 12.1763 22.5474C14.0486 22.5473 15.8941 22.0753 17.5159 21.1821C17.6139 21.1277 17.723 21.1017 17.8311 21.1016L17.8311 21.1016ZM6.69995 40.7565C6.45388 40.7565 6.22235 40.6173 6.11549 40.39C5.98301 40.1038 6.08656 39.7655 6.35926 39.598C13.747 35.0813 16.2827 28.1824 17.053 22.8063C15.5225 23.4589 13.8584 23.8006 12.1765 23.8006C5.46212 23.8005 0 18.4615 0 11.9008C0.00010793 5.33901 5.4621 2.89626e-09 12.1765 2.89626e-09C15.527 -7.02862e-05 18.4723 1.27924 20.694 3.6986C22.7266 5.91116 24.0913 8.98545 24.64 12.5894C26.2563 23.1859 20.5827 36.6501 6.88693 40.7294C6.82457 40.7478 6.7611 40.7566 6.69997 40.7565L6.69995 40.7565Z" fill="#FF4638"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.9217 21.1017C49.0442 21.1017 49.1666 21.1354 49.2735 21.2039C49.4739 21.3311 49.584 21.5575 49.5607 21.7902C49.21 25.181 48.3084 28.3412 46.8825 31.1837C45.6226 33.6944 43.9739 35.8984 41.9558 37.7716C51.8048 32.6251 55.8152 21.6445 54.4628 12.7732C53.6136 7.20455 50.2274 1.25311 43.2682 1.25311C37.2607 1.25308 32.3741 6.02976 32.3741 11.9008C32.3742 17.7707 37.2607 22.5474 43.2682 22.5474C45.1394 22.5473 46.986 22.0753 48.6079 21.1821C48.7059 21.1277 48.8137 21.1017 48.9217 21.1017L48.9217 21.1017ZM37.7906 40.7565C37.5446 40.7565 37.313 40.6173 37.2073 40.39C37.0738 40.1039 37.1783 39.7656 37.4499 39.5981C44.8389 35.0814 47.3734 28.1824 48.1436 22.8063C46.6132 23.4589 44.9501 23.8006 43.2682 23.8006C36.5539 23.8005 31.0918 18.4615 31.0918 11.9008C31.0919 5.33901 36.5539 2.89626e-09 43.2682 2.89626e-09C46.6176 -7.02862e-05 49.5629 1.27924 51.7847 3.6986C53.8173 5.91116 55.1819 8.98545 55.7318 12.5883C57.347 23.1859 51.6734 36.6501 37.9776 40.7294C37.9153 40.7478 37.8529 40.7566 37.7906 40.7565V40.7565Z" fill="#FF4638"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="testimonial__desc">The most advanced revenue than this. Iwill refer everyone 
                                        I like Level more and more each day because it makes my
                                        easier. It really saves me time and effort. Level is exactly
                                        business has been lacking.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial__card">
                                        <div class="testimonial__card--top d-flex justify-content-between">
                                            <div class="testimonial__author d-flex align-items-center">
                                                <div class="testimonial__author--thumbnail">
                                                    <img src="./assets/img/other/testimonial-author-thumb.png" alt="img">
                                                </div>
                                                <div class="testimonial__author--content">
                                                    <h3 class="testimonial__author--name">Cameron Williamson</h3>
                                                    <span class="testimonial__author--subtitle">Ceo & Founder</span>
                                                </div>
                                            </div>
                                            <span class="testimonial__icon">
                                                <svg width="56" height="41" viewBox="0 0 56 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8311 21.1016C17.9536 21.1016 18.0759 21.1354 18.1817 21.2039C18.3821 21.3311 18.4933 21.5575 18.4689 21.7902C18.1183 25.181 17.2177 28.3412 15.7918 31.1837C14.5318 33.6944 12.8821 35.8983 10.864 37.7716C20.7152 32.6251 24.7246 21.6445 23.3721 12.7732C22.5228 7.20455 19.1356 1.25311 12.1763 1.25311C6.17002 1.25308 1.28225 6.02976 1.28225 11.9008C1.28236 17.7707 6.16997 22.5474 12.1763 22.5474C14.0486 22.5473 15.8941 22.0753 17.5159 21.1821C17.6139 21.1277 17.723 21.1017 17.8311 21.1016L17.8311 21.1016ZM6.69995 40.7565C6.45388 40.7565 6.22235 40.6173 6.11549 40.39C5.98301 40.1038 6.08656 39.7655 6.35926 39.598C13.747 35.0813 16.2827 28.1824 17.053 22.8063C15.5225 23.4589 13.8584 23.8006 12.1765 23.8006C5.46212 23.8005 0 18.4615 0 11.9008C0.00010793 5.33901 5.4621 2.89626e-09 12.1765 2.89626e-09C15.527 -7.02862e-05 18.4723 1.27924 20.694 3.6986C22.7266 5.91116 24.0913 8.98545 24.64 12.5894C26.2563 23.1859 20.5827 36.6501 6.88693 40.7294C6.82457 40.7478 6.7611 40.7566 6.69997 40.7565L6.69995 40.7565Z" fill="#FF4638"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.9217 21.1017C49.0442 21.1017 49.1666 21.1354 49.2735 21.2039C49.4739 21.3311 49.584 21.5575 49.5607 21.7902C49.21 25.181 48.3084 28.3412 46.8825 31.1837C45.6226 33.6944 43.9739 35.8984 41.9558 37.7716C51.8048 32.6251 55.8152 21.6445 54.4628 12.7732C53.6136 7.20455 50.2274 1.25311 43.2682 1.25311C37.2607 1.25308 32.3741 6.02976 32.3741 11.9008C32.3742 17.7707 37.2607 22.5474 43.2682 22.5474C45.1394 22.5473 46.986 22.0753 48.6079 21.1821C48.7059 21.1277 48.8137 21.1017 48.9217 21.1017L48.9217 21.1017ZM37.7906 40.7565C37.5446 40.7565 37.313 40.6173 37.2073 40.39C37.0738 40.1039 37.1783 39.7656 37.4499 39.5981C44.8389 35.0814 47.3734 28.1824 48.1436 22.8063C46.6132 23.4589 44.9501 23.8006 43.2682 23.8006C36.5539 23.8005 31.0918 18.4615 31.0918 11.9008C31.0919 5.33901 36.5539 2.89626e-09 43.2682 2.89626e-09C46.6176 -7.02862e-05 49.5629 1.27924 51.7847 3.6986C53.8173 5.91116 55.1819 8.98545 55.7318 12.5883C57.347 23.1859 51.6734 36.6501 37.9776 40.7294C37.9153 40.7478 37.8529 40.7566 37.7906 40.7565V40.7565Z" fill="#FF4638"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="testimonial__desc">The most advanced revenue than this. Iwill refer everyone 
                                        I like Level more and more each day because it makes my
                                        easier. It really saves me time and effort. Level is exactly
                                        business has been lacking.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial__card">
                                        <div class="testimonial__card--top d-flex justify-content-between">
                                            <div class="testimonial__author d-flex align-items-center">
                                                <div class="testimonial__author--thumbnail">
                                                    <img src="./assets/img/other/testimonial-author-thumb3.png" alt="img">
                                                </div>
                                                <div class="testimonial__author--content">
                                                    <h3 class="testimonial__author--name">Cameron Williamson</h3>
                                                    <span class="testimonial__author--subtitle">Ceo & Founder</span>
                                                </div>
                                            </div>
                                            <span class="testimonial__icon">
                                                <svg width="56" height="41" viewBox="0 0 56 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8311 21.1016C17.9536 21.1016 18.0759 21.1354 18.1817 21.2039C18.3821 21.3311 18.4933 21.5575 18.4689 21.7902C18.1183 25.181 17.2177 28.3412 15.7918 31.1837C14.5318 33.6944 12.8821 35.8983 10.864 37.7716C20.7152 32.6251 24.7246 21.6445 23.3721 12.7732C22.5228 7.20455 19.1356 1.25311 12.1763 1.25311C6.17002 1.25308 1.28225 6.02976 1.28225 11.9008C1.28236 17.7707 6.16997 22.5474 12.1763 22.5474C14.0486 22.5473 15.8941 22.0753 17.5159 21.1821C17.6139 21.1277 17.723 21.1017 17.8311 21.1016L17.8311 21.1016ZM6.69995 40.7565C6.45388 40.7565 6.22235 40.6173 6.11549 40.39C5.98301 40.1038 6.08656 39.7655 6.35926 39.598C13.747 35.0813 16.2827 28.1824 17.053 22.8063C15.5225 23.4589 13.8584 23.8006 12.1765 23.8006C5.46212 23.8005 0 18.4615 0 11.9008C0.00010793 5.33901 5.4621 2.89626e-09 12.1765 2.89626e-09C15.527 -7.02862e-05 18.4723 1.27924 20.694 3.6986C22.7266 5.91116 24.0913 8.98545 24.64 12.5894C26.2563 23.1859 20.5827 36.6501 6.88693 40.7294C6.82457 40.7478 6.7611 40.7566 6.69997 40.7565L6.69995 40.7565Z" fill="#FF4638"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.9217 21.1017C49.0442 21.1017 49.1666 21.1354 49.2735 21.2039C49.4739 21.3311 49.584 21.5575 49.5607 21.7902C49.21 25.181 48.3084 28.3412 46.8825 31.1837C45.6226 33.6944 43.9739 35.8984 41.9558 37.7716C51.8048 32.6251 55.8152 21.6445 54.4628 12.7732C53.6136 7.20455 50.2274 1.25311 43.2682 1.25311C37.2607 1.25308 32.3741 6.02976 32.3741 11.9008C32.3742 17.7707 37.2607 22.5474 43.2682 22.5474C45.1394 22.5473 46.986 22.0753 48.6079 21.1821C48.7059 21.1277 48.8137 21.1017 48.9217 21.1017L48.9217 21.1017ZM37.7906 40.7565C37.5446 40.7565 37.313 40.6173 37.2073 40.39C37.0738 40.1039 37.1783 39.7656 37.4499 39.5981C44.8389 35.0814 47.3734 28.1824 48.1436 22.8063C46.6132 23.4589 44.9501 23.8006 43.2682 23.8006C36.5539 23.8005 31.0918 18.4615 31.0918 11.9008C31.0919 5.33901 36.5539 2.89626e-09 43.2682 2.89626e-09C46.6176 -7.02862e-05 49.5629 1.27924 51.7847 3.6986C53.8173 5.91116 55.1819 8.98545 55.7318 12.5883C57.347 23.1859 51.6734 36.6501 37.9776 40.7294C37.9153 40.7478 37.8529 40.7566 37.7906 40.7565V40.7565Z" fill="#FF4638"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="testimonial__desc">The most advanced revenue than this. Iwill refer everyone 
                                        I like Level more and more each day because it makes my
                                        easier. It really saves me time and effort. Level is exactly
                                        business has been lacking.</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="testimonial__card">
                                        <div class="testimonial__card--top d-flex justify-content-between">
                                            <div class="testimonial__author d-flex align-items-center">
                                                <div class="testimonial__author--thumbnail">
                                                    <img src="./assets/img/other/testimonial-author-thumb2.png" alt="img">
                                                </div>
                                                <div class="testimonial__author--content">
                                                    <h3 class="testimonial__author--name">Cameron Williamson</h3>
                                                    <span class="testimonial__author--subtitle">Ceo & Founder</span>
                                                </div>
                                            </div>
                                            <span class="testimonial__icon">
                                                <svg width="56" height="41" viewBox="0 0 56 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8311 21.1016C17.9536 21.1016 18.0759 21.1354 18.1817 21.2039C18.3821 21.3311 18.4933 21.5575 18.4689 21.7902C18.1183 25.181 17.2177 28.3412 15.7918 31.1837C14.5318 33.6944 12.8821 35.8983 10.864 37.7716C20.7152 32.6251 24.7246 21.6445 23.3721 12.7732C22.5228 7.20455 19.1356 1.25311 12.1763 1.25311C6.17002 1.25308 1.28225 6.02976 1.28225 11.9008C1.28236 17.7707 6.16997 22.5474 12.1763 22.5474C14.0486 22.5473 15.8941 22.0753 17.5159 21.1821C17.6139 21.1277 17.723 21.1017 17.8311 21.1016L17.8311 21.1016ZM6.69995 40.7565C6.45388 40.7565 6.22235 40.6173 6.11549 40.39C5.98301 40.1038 6.08656 39.7655 6.35926 39.598C13.747 35.0813 16.2827 28.1824 17.053 22.8063C15.5225 23.4589 13.8584 23.8006 12.1765 23.8006C5.46212 23.8005 0 18.4615 0 11.9008C0.00010793 5.33901 5.4621 2.89626e-09 12.1765 2.89626e-09C15.527 -7.02862e-05 18.4723 1.27924 20.694 3.6986C22.7266 5.91116 24.0913 8.98545 24.64 12.5894C26.2563 23.1859 20.5827 36.6501 6.88693 40.7294C6.82457 40.7478 6.7611 40.7566 6.69997 40.7565L6.69995 40.7565Z" fill="#FF4638"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M48.9217 21.1017C49.0442 21.1017 49.1666 21.1354 49.2735 21.2039C49.4739 21.3311 49.584 21.5575 49.5607 21.7902C49.21 25.181 48.3084 28.3412 46.8825 31.1837C45.6226 33.6944 43.9739 35.8984 41.9558 37.7716C51.8048 32.6251 55.8152 21.6445 54.4628 12.7732C53.6136 7.20455 50.2274 1.25311 43.2682 1.25311C37.2607 1.25308 32.3741 6.02976 32.3741 11.9008C32.3742 17.7707 37.2607 22.5474 43.2682 22.5474C45.1394 22.5473 46.986 22.0753 48.6079 21.1821C48.7059 21.1277 48.8137 21.1017 48.9217 21.1017L48.9217 21.1017ZM37.7906 40.7565C37.5446 40.7565 37.313 40.6173 37.2073 40.39C37.0738 40.1039 37.1783 39.7656 37.4499 39.5981C44.8389 35.0814 47.3734 28.1824 48.1436 22.8063C46.6132 23.4589 44.9501 23.8006 43.2682 23.8006C36.5539 23.8005 31.0918 18.4615 31.0918 11.9008C31.0919 5.33901 36.5539 2.89626e-09 43.2682 2.89626e-09C46.6176 -7.02862e-05 49.5629 1.27924 51.7847 3.6986C53.8173 5.91116 55.1819 8.98545 55.7318 12.5883C57.347 23.1859 51.6734 36.6501 37.9776 40.7294C37.9153 40.7478 37.8529 40.7566 37.7906 40.7565V40.7565Z" fill="#FF4638"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <p class="testimonial__desc">The most advanced revenue than this. Iwill refer everyone 
                                        I like Level more and more each day because it makes my
                                        easier. It really saves me time and effort. Level is exactly
                                        business has been lacking.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <div class="swiper__nav--btn swiper-button-disabled swiper-button-prev">
                            <svg width="16" height="13" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.223772 5.27955L5.27967 0.223543C5.42399 0.0792188 5.61635 0 5.82145 0C6.02678 0 6.21902 0.0793326 6.36335 0.223543L6.82238 0.682693C6.96659 0.82679 7.04604 1.01926 7.04604 1.22448C7.04604 1.42958 6.96659 1.62854 6.82238 1.77264L3.87285 4.72866H13.2437C13.6662 4.72866 14 5.05942 14 5.48203V6.13115C14 6.55376 13.6662 6.91788 13.2437 6.91788H3.83939L6.82227 9.8904C6.96648 10.0347 7.04593 10.222 7.04593 10.4272C7.04593 10.6322 6.96648 10.8221 6.82227 10.9663L6.36323 11.424C6.21891 11.5683 6.02667 11.647 5.82134 11.647C5.61623 11.647 5.42388 11.5673 5.27955 11.423L0.223659 6.3671C0.0789928 6.22232 -0.000566483 6.02905 1.90735e-06 5.82361C-0.000452995 5.61748 0.0789928 5.4241 0.223772 5.27955Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <div class="swiper__nav--btn swiper-button-next">
                            <svg width="16" height="13" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.7762 5.27955L8.72033 0.223543C8.57601 0.0792188 8.38365 0 8.17855 0C7.97322 0 7.78098 0.0793326 7.63665 0.223543L7.17762 0.682693C7.03341 0.82679 6.95396 1.01926 6.95396 1.22448C6.95396 1.42958 7.03341 1.62854 7.17762 1.77264L10.1272 4.72866H0.756335C0.333835 4.72866 0 5.05942 0 5.48203V6.13115C0 6.55376 0.333835 6.91788 0.756335 6.91788H10.1606L7.17773 9.8904C7.03352 10.0347 6.95407 10.222 6.95407 10.4272C6.95407 10.6322 7.03352 10.8221 7.17773 10.9663L7.63677 11.424C7.78109 11.5683 7.97333 11.647 8.17866 11.647C8.38377 11.647 8.57612 11.5673 8.72045 11.423L13.7763 6.3671C13.921 6.22232 14.0006 6.02905 14 5.82361C14.0005 5.61748 13.921 5.4241 13.7762 5.27955Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonial section .\ -->
            
@endsection

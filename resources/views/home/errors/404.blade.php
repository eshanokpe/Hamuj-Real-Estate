@extends('layouts.app')

@section('content')

    <!-- Breadcrumb section -->
    <section class="breadcrumb__section section--padding">
        <div class="container">
            <div class="breadcrumb__content text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                <h1 class="breadcrumb__title h2">
                    <span>Error </span>
                    Page
                </h1>
                <ul class="breadcrumb__menu d-flex justify-content-center">
                    <li class="breadcrumb__menu--items">
                        <a class="breadcrumb__menu--link" href="./index.html">Home</a>
                    </li>
                    <li>
                        <span>
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.22321 4.65179C5.28274 4.71131 5.3125 4.77976 5.3125 4.85714C5.3125 4.93452 5.28274 5.00298 5.22321 5.0625L1.0625 9.22321C1.00298 9.28274 0.934524 9.3125 0.857143 9.3125C0.779762 9.3125 0.71131 9.28274 0.651786 9.22321L0.205357 8.77679C0.145833 8.71726 0.116071 8.64881 0.116071 8.57143C0.116071 8.49405 0.145833 8.4256 0.205357 8.36607L3.71429 4.85714L0.205357 1.34821C0.145833 1.28869 0.116071 1.22024 0.116071 1.14286C0.116071 1.06548 0.145833 0.997023 0.205357 0.9375L0.651786 0.491071C0.71131 0.431547 0.779762 0.401785 0.857143 0.401785C0.934524 0.401785 1.00298 0.431547 1.0625 0.491071L5.22321 4.65179Z" fill="#706C6C"/>
                            </svg>
                        </span>
                    </li>
                    <li>
                        <span class="breadcrumb__menu--text">Error Page </span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Breadcrumb section .\ -->
    <!-- Error Page section -->
    <section class="error__section section--padding">
        <div class="container">
            <div class="error__inner text-center" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                <img class="error__img" src="./assets/img/other/404.png" alt="img">
                <h2 class="error__subtitle">
                    Oops... It looks like you ‘re <span>lost !</span>
                </h2>
                <p class="error__desc">Oops! The page you are looking for does not exist. It might have been moved or deleted.</p>
                <a class="error__btn solid__btn" href="./index.html">Back To Home</a>
            </div>
        </div>
    </section>
    <!-- Error Page section .\ -->

@endsection

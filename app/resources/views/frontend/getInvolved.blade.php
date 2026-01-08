@extends('layouts.app')

@section('content')

<!--======  Start Page Hero Section  ======-->
<section 
    class="page-hero bg_cover p-r z-1" 
    {{-- style="padding-top: 0px" --}}
    style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}'); background-size:cover"
>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content text-center">
                    <h3 style="color: black;">Get Involved with IGRCFP</h3>
                    <p>
                        Join IGRCFP in shaping the future of governance, risk, and financial crime prevention. Whether you’re a regulator, corporate leader, academic, or professional, there are multiple ways to contribute, collaborate, and grow with us.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->


 <!--======  Start Partner Section  ======-->
<section class="bizzen-service_one pt-115 pb-115 bg_cover" style="background-image: url(assets/images/home-one/bg/service-bg.png);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <!--=== Section Title ===-->
                <div class="section-title text-center mb-60">
                    <h2 class="text-anm" data-aos="fade-down" data-aos-duration="1000">Partner with Us</h2>
                    <p class="text-center">We collaborate with regulators, corporates, and universities to advance global compliance standards through training, advocacy, and research.</p>
                    <div class="bizzen-button mt-30" data-aos="fade-up" data-aos-duration="1800">
                        <a  href="{{ route('event') }}" class="theme-btn style-one">Become a Partner</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <!--=== Bizzen Service Item ===-->
                <div class="bizzen-service-item style-one mb-30 shadow" data-aos="fade-up" data-aos-duration="1000">
                    <div class="service-inner-content">
                        <div class="icon">
                            <img src="{{ asset('assets/images/home-three/icon/icon9.svg')}}" alt="icon">
                        </div>
                        <div class="content" style=" margin-top: 40px;">
                            <h4 class="title"><a href="#">Corporate Partnerships</a></h4>
                            <p>
                                Collaborate with industry leaders to develop cutting edge compliance frameworks and risk management solutions that drive business excellence.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <!--=== Bizzen Service Item ===-->
                <div class="bizzen-service-item style-one mb-30 shadow" data-aos="fade-up" data-aos-duration="1400">
                    <div class="service-inner-content">
                        <div class="icon">
                            <img src="{{ asset('assets/images/home-three/icon/icon10.svg')}}" alt="icon">
                        </div>
                        <div class="content" style=" margin-top: 40px;">
                            <h4 class="title"><a href="#">Academic Collaboration</a></h4>
                            <p>Partner with leading universities to conduct groundbreaking research and develop the next generation of governance professionals</p><br/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <!--=== Bizzen Service Item ===-->
                <div class="bizzen-service-item style-one mb-30 shadow" data-aos="fade-up" data-aos-duration="1600">
                    <div class="service-inner-content">
                        <div class="icon">
                            <img src="{{ asset('assets/images/home-three/icon/icon11.svg')}}" alt="icon">
                        </div>
                        <div class="content" style=" margin-top: 40px;">
                            <h4 class="title"><a href="#">Regulatory Sponsorships</a></h4>
                            <p>Work alongside with regulatory bodies to shape policy, enhance enforcement strategies, and promote international compliance standards</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!--=== Text Box ===-->
                <div class="text-box text-center mt-30" data-aos="fade-up" data-aos-duration="1800">
                    <p>We Strive To Lead The way In The <a href="services.html">business Know All Services <i class="far fa-arrow-right"></i></a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Partner Section  ======-->

@endsection
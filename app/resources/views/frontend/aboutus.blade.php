@extends('layouts.app')

@section('content')

<!--======  Start Page Hero Section  ======-->
<section 
    class="page-hero bg_cover p-r z-1" 
    style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');"
>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content text-center">
                    <h1 style="color: black;">Welcome to IGRCFP</h1>
                        <ul >
                            <li ><a class="text-black" href="{{ route('index') }}">Home</a></li>
                            <li class="text-black">About Us</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->

 <!--======  Start Company Section  ======-->
<section class="bizzen-company-sec pt-120 pb-120">
    <div class="container-fluid">
        <!--=== Clients Slider ===-->
        <div class="clients-slider" data-aos="fade-up" data-aos-duration="1000">
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset ('assets/images/innerpage/company/client-img1.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset ('assets/images/innerpage/company/client-img2.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset('assets/images/innerpage/company/client-img3.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset ('assets/images/innerpage/company/client-img4.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset('assets/images/innerpage/company/client-img5.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset('assets/images/innerpage/company/client-img1.png')}}" alt="Client Logo">
                </div>
            </div>
            <!--=== Bizzen Client Item ===-->
            <div class="bizzen-client-item">
                <div class="client-img">
                    <img src="{{ asset('assets/images/innerpage/company/client-img2.png')}}" alt="Client Logo">
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Company Section  ======-->

 <!--======  Start Who We Section  ======-->
<section class="bizzen-we_two pt-120 pb-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-10">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box">
                    <!--=== Section Title ===-->
                    <div class="section-title mb-30">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Who we are</span>
                        <h2 class="text-anm">Know More About Us</h2>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-xl-7 col-lg-10">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0 " >
                    <p class="mb-3 " data-aos="fade-up" data-aos-duration="1200">
                        The Institute of Governance, Risk & Compliance & Financial Crime Prevention (IGRCFP) is a global professional body dedicated to raising standards in governance, risk management, compliance, and financial crime prevention.
                    </p>
                    
                    <p class="mb-3" data-aos="fade-up" data-aos-duration="1600">
                        We equip professionals and organizations with world-class training, certifications, and resources to stay ahead in a fast-changing regulatory environment.
                    </p>
                    <p data-aos="fade-up" data-aos-duration="1800">
                        With a presence across Africa, Europe, Asia, the Middle East, and the Americas, IGRCFP connects experts, regulators, and industry leaders to share knowledge, drive innovation, and build stronger institutions worldwide.
                    </p>
                    <div class="bizzen-button mt-30"  data-aos="fade-up" data-aos-duration="1800">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->

<section
    class="bizzen-intro_one pt-250 pb-250 bg_cover"
    style="background-image: url('{{ asset('assets/images/home-three/bg/intro-bg.png') }}');"
    data-aos="fade-up"
    data-aos-duration="1000"
>
    <div class="container"></div>
</section>

 <!--======  Start Who We Section  ======-->
<section class="bizzen-we_two pt-120 pb-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-1 col-lg-10"></div>
            <div class="col-xl-10 col-lg-10">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box">
                    <!--=== Section Title ===-->
                    <div class="section-title mb-30 text-center">
                        <div class="title-with-lines" data-aos="fade-down" data-aos-duration="1000">
                            <span class=" text-black">OUR VISION</span>
                        </div>
                        <p class=" text-black">To be the foremost international institute advancing governance, compliance, and  
                            financial crime prevention through knowledge, innovation, and collaboration.</p>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-xl-1 col-lg-10"></div>
            
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->

<!--======  Start Growth Section  ======-->
<section class="bizzen-growth-sec pt-115 pb-120 bg_cover" >
    <div class="row justify-content-center pb-20">
        <div class="col-xl-8">
            <!--=== Section Title ===-->
            <div class="section-title text-center mb-60 text-black">
                <h3 class="text-anm" data-aos="fade-down" data-aos-duration="1000">Our Values</h3>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-10">
                <!--=== Bizzen Features List ===-->
                <div class="bizzen-features-list">
                    <div class="row">
                        <div class="col-md-6">
                            <!--=== Bizzen Features Item ===-->
                            <div class="bizzen-features-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/home-three/icon/cube.svg')}}" alt="check">
                                </div>
                                <div class="content">
                                    <h4 class="text-black">Integrity </h4>
                                    <p>We uphold the highest ethical standards in governance, compliance, and financial crime prevention. Integrity guides every action we take and every partnership we build.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!--=== Bizzen Features Item ===-->
                            <div class="bizzen-features-item style-two mb-35" data-aos="fade-up" data-aos-duration="1200">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/home-three/icon/cube.svg')}}" alt="check">
                                </div>
                                <div class="content">
                                    <h4 class="text-black">Innovation</h4>
                                    <p>We embrace new ideas, technologies, and approaches — from RegTech to ESG frameworks — to prepare professionals for the challenges of tomorrow.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!--=== Bizzen Features Item ===-->
                            <div class="bizzen-features-item style-two mb-35" data-aos="fade-up" data-aos-duration="1400">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/home-three/icon/cube.svg')}}" alt="check">
                                </div>
                                <div class="content">
                                    <h4 class="text-black">Collaboration</h4>
                                    <p>We believe progress comes from working together. IGRCFP connects regulators, institutions, and practitioners across continents to drive global impact.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!--=== Bizzen Features Item ===-->
                            <div class="bizzen-features-item style-two mb-35" data-aos="fade-up" data-aos-duration="1800">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/home-three/icon/cube.svg')}}" alt="check">
                                </div>
                                <div class="content">
                                    <h4 class="text-black">Excellence</h4>
                                    <p>We are committed to delivering world-class training, certifications, research, and events that set the benchmark for professional standards worldwide.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-xl-6 col-lg-10">
                <div 
                    class="play-bg bg_cover mr-2" 
                    style="background-image: url('{{ asset('assets/images/innerpage/bg/about-bg.png') }}');"
                    >
                    <!--=== Local Video ===-->
                    <video 
                        width="100%" 
                        height="auto" 
                        controls 
                        data-aos="fade-up" 
                        data-aos-duration="1000"
                        poster="{{ asset('assets/images/innerpage/bg/about-bg.png') }}" 
                    >
                        <source src="{{ asset('assets/videos/about-video.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

            </div>
        </div>
    </div>
</section>
<!--======  End Growth Section  ======-->

 <!--======  Start Blog Grid Section  ======-->
<section class="bizzen-blog-grid-sec pt-20 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-8">
                <!--=== Section Title ===-->
                <div class="section-title text-center mb-20">
                    <h3 class="text-anm mb-20" data-aos="fade-down" data-aos-duration="1000">Our Core Services</h3>
                    <p>At IGRCFP, we empower professionals and institutions through education, membership, research, and global events. 
                        Our core services are designed to strengthen governance, compliance, and financial crime 
                        prevention worldwide<p>
                        
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-1.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content text-center">
                        <h4 class="title"><a href="{{  route('services') }}">Education & Cerification</a></h4>
                        <p>
                            We deliver CPD-accredited certifications, diplomas, and specialised training programmes that equip professionals and institutions with the skills to meet global compliance and financial crime prevention standards.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1200">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-2.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content text-center">
                        <h4 class="title"><a href="{{  route('services') }}"> Membership Community</a></h4>
                        <p>
                            We provide a professional network that connects students, practitioners, and organisations worldwide, offering 
                            exclusive benefits, recognition, and career development opportunities.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1400">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-3.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content text-center" >
                        <h4 class="title"><a href="{{  route('services') }}">Advocacy & Research</a></h4>
                        <p>Through policy engagement, research collaborations, and publications, we shape industry standards and provide thought leadership on governance, compliance, and financial crime prevention. </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1600">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-4.png')}}" alt="Blog Grid">
                     </div>
                    <div class="post-content  text-center">
                        <h4 class="title"><a href="{{ route('services') }}">Global Events & Summits</a></h4>
                        <p>
                            We organise international conferences, workshops, webinars, and forums that bring together regulators, professionals, and innovators to exchange knowledge, network, and set future directions.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1800">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-5.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content text-center">
                        <h4 class="title"><a href="{{ route('services') }}">Regulation & Enforcement Support</a></h4>
                        <p>
                            Working closely with regulatory bodies, law enforcement agencies, and financial institutions to support the development and enforcement of anti-fraud measures.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="2000">
                    <div class="post-thumbnail">
                        <img class="img-fluid w-50 mx-auto d-block" src="{{ asset('assets/images/innerpage/service/service-6.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content text-center">
                        <h4 class="title">
                            <a href="{{ route('services') }}">Consultancy Services</a></h4>
                        <p>
                            Offering expert consultancy in financial crime prevention strategies, compliance frameworks, and risk assessment to organizations seeking to enhance their security and regulatory measures.
                        </p>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</section>


@endsection
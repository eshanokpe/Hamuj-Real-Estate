@extends('layouts.app')

@section('content')
 
<!--======  Start Hero Section  ======-->
<section class="bizzen-hero">
    <!--=== Bizzen Hero ===-->
    <div class="bizzen-hero_three">
        <div class="shape d-block d-lg-none" >
            <img class=""   src="{{ asset('assets/images/home-three/hero/hero-img1.png')}}" alt="shape">
        </div>
                           
        <div class="container sider">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-6 col-lg-10">
                    <!--=== Hero Content ===-->
                    <div class="hero-content">
                        <h3 class="text-anm">Empower Professionals, Strengthning Goverance, Preventing Financial Crime </h3>
                        <p data-aos="fade-up" data-aos-duration="1200">
                            The Institute of GRC & Financial Crime Prevention (IGRCFP) is a global professional  body dedicated to advancing excellence in governance, risk management,  compliance, and financial crime prevention.
                        </p>  
                        <div class="hero-button " data-aos="fade-down" data-aos-duration="1400">
                        <a href="{{ route('register') }}" class="theme-btn style-one me-3 mb-10 rounded-3" >
                            Join the Institute<i class="far fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('certifications.index') }}" class="theme-btn style-two rounded-3" style="background-color: #fff;">
                            Explore Certifications<i class="far fa-arrow-right"></i>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 co-lg-8">
                    <!--=== Hero Image Box ===-->                                            
                    <div class="hero-image-box">
                        <!-- Bootstrap Slider -->  
                        <div id="heroSlider" class="carousel slide" data-bs-ride="carousel">
                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            
                            <!-- Slides -->
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="5000">
                                    <div class="bizzen-image text-center" data-aos="fade-down" data-aos-duration="1200">
                                        <img src="{{ asset('assets/images/home-three/hero/hero-img1.png')}}" alt="hero image" class="d-block w-100">
                                    </div>
                                </div>
                                <div class="carousel-item" data-bs-interval="5000"> 
                                    <div class="bizzen-image text-center" data-aos="fade-down" data-aos-duration="1200">
                                        <img src="{{ asset('assets/images/home-three/hero/hero-img1.png')}}" alt="hero image 2" class="d-block w-100">
                                    </div>
                                </div>
                                
                                <div class="carousel-item" data-bs-interval="5000">
                                    <div class="bizzen-image text-center" data-aos="fade-down" data-aos-duration="1200">
                                        <img src="{{ asset('assets/images/home-three/hero/hero-img1.png')}}" alt="hero image 3" class="d-block w-100">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



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
                        <a href="{{ route('about-us') }}" class="theme-btn style-one" style="border-radius: 8px;">Learn More About Us →<i class="far fa-arrow-right"></i></a>
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


 <!--======  Start Our Programmes  ======-->
<section class="bizzen-blog-sec pt-115 pb-0">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-xl-12">
                <!--=== Section Title ===-->
                <div class="section-title text-left mb-60">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="1000">Certifications & Trainings</span>
                    <h2 class="text-anm">Our Programmes</h2>
                    <div class="content-wrap">
                        <p data-aos="fade-up" data-aos-duration="1200">
                            Our professional certifications are designed to equip individuals and institutions with  globally relevant skills to tackle financial crime and compliance risks.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1000">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img1.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content ">
                        <h4 class="title"><a href="{{ route('certifications.cgfcs')}}">
                            Certified GRC & Financial Crime Specialist (CGFCS)</a>
                        </h4>
                        <p>
                        Our flagship certification equipping professionals with practical skills in governance, risk, compliance, and financial crime prevention. Globally benchmarked and CPD-accredited.  
                        </p>
                        <a href="{{ route('certifications.cgfcs')}}" class="read-more style-one">READ MORE <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1200">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img2.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content">
                        
                        <h4 class="title">
                            <a href="{{ route('certifications.diploma.grc-financial-crime-prevention')}}">
                            Advanced Diploma in GRC & Financial Crime Prevention
                            </a>
                        </h4>
                        <p>
                            A deep-dive, multi-disciplinary programme covering advanced governance, risk, compliance, and financial crime prevention. Prepares professionals for senior leadership roles with real-world case projects.
                        </p>
                        <a href="{{ route('certifications.diploma.grc-financial-crime-prevention')}}" class="read-more style-one">READ MORE <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1400">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img3.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content">
                        <h4 class="title"><a href="{{ route('certifications.cybersecurity-finance')}}">
                            Cybersecurity & Data Security for Financial Institutions
                        </a></h4>
                        <p>
                            Focused training on cyber resilience, data protection, and information governance in the digital-first financial sector. Includes practical modules on GDPR, incident response, and threat case studies.
                        </p>
                        <a href="{{ route('certifications.cybersecurity-finance')}}" class="read-more style-one">READ MORE <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Our Programmes  ======-->

<!--======  Start Event & Summit  ======-->
<section class="bizzen-we_two pt-80 pb-50">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-xl-7">
                <!--=== Section Title ===-->
                <div class="section-title text-left mb-60">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="1000">Events & Summits</span>
                    <h2 class="text-anm">Our Global Events & Summits</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-10">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0">
                    <div class="bizzen-image image-one" data-aos="fade-up" data-aos-duration="1000">
                        <img src="{{ asset('assets/images/home-three/gallery/events-image.png')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10" >
                <div class="bizzen-process-item style-three mb-40" data-aos="fade-up" data-aos-duration="1800">
                <p>
                    At IGRCFP, our events connect professionals, regulators, and industry leaders worldwide. From global summits to focused workshops, we provide platforms for learning, networking, and shaping the future of governance, compliance, and financial crime prevention.
                </p>  
                <h6 class="mb-15">Our Key Events:</h6>
                <ul class="check-list style-two mb-40" >
                    <li>Global Summits – Annual gatherings in Africa and Europe with keynotes, panels, and networking.</li>
                    <li>Annual Awards – Recognising excellence in compliance and governance.</li>
                    <li>Women in GRC & FCC Forums – Empowering women leaders in the industry.</li>
                    <li>Workshops & Webinars – Practical, hands-on learning across regions.</li>
                    <li>Speaker Series – Fireside chats with regulators and global experts.</li>
                </ul>
                <div class="bizzen-button mt-30" data-aos="fade-up" data-aos-duration="1800">
                    <a style="border-radius: 8px;" href="{{ route('events.index') }}" class="theme-btn style-one">View Upcoming Events →<i class="far fa-arrow-right"></i></a>
                </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!--======  End Event & summit  ======-->

<!--======  Start Membership ======-->
<section class="bizzen-we_two pt-120 pb-120">
    <div class="container pb-120">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-10">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box">
                    <!--=== Section Title ===-->
                    <div class="section-title mb-30">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Membership</span>
                        <h2 class="text-anm">Become a Member</h2>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-xl-7 col-lg-10">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0 " >
                    <p class="mb-3" data-aos="fade-up" data-aos-duration="1200">
                        Take your professional journey to the next level by joining IGRCFP. Membership gives you exclusive access to a global network of governance, risk, compliance, and financial crime professionals, cutting-edge research, specialized training, and career-boosting opportunities. Enjoy discounts on courses and events, CPD credits, and the use of prestigious post-nominals that highlight your expertise. Whether you’re in banking, fintech, insurance, or regulatory roles, IGRCFP membership equips you with the knowledge, recognition, and connections to excel and make an impact in your field.
                    </p>
                    <div class="bizzen-button mt-30"  data-aos="fade-up" data-aos-duration="1800">
                        <a href="{{ route('register') }}" class="theme-btn style-one" style="border-radius: 8px;">Register as a Member →<i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="row">
            <div class="col-xl-6">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0">
                    <div class="bizzen-image image-one" data-aos="fade-up" data-aos-duration="800">
                        <img src="{{ asset('assets/images/home-three/gallery/membership-img1.png')}}" alt="">
                    </div>
                    
                </div>
            </div>
            <div class="col-xl-5">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box pt-100">
                    <div class="section-title mb-30">
                        <!-- <span class="sub-title" data-aos="fade-down" data-aos-duration="800">WHO WE ARE</span> -->
                        <!-- <h2 class="text-anm">We compare the reality of your strategy</h2> -->
                    </div>
                    <div class="content-wrap">
                            <div class="bizzen-image image-one" data-aos="fade-up" data-aos-duration="800">
                        <img src="{{ asset('assets/images/home-three/gallery/membership-img2.png')}}" alt="">
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-1">  </div>
        </div>
    </div>
</section>
<!--======  End Membership  ======-->

    {{-- become_our_membership.blade --}}
    @include('frontend.components.become_our_membership')
    {{-- become_our_membership.blade --}}
    
<!--======  Start Why Join  ======-->
    <section class="bizzen-we_two pt-120 pb-120">
        <div class="container pb-50">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-10">
                    <!--=== Bizzen Content Box ===-->
                    <div class="bizzen-content-box">
                        <!--=== Section Title ===-->
                        <div class="section-title mb-30">
                            <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Why Join?</span>
                            <h2 class="text-anm">Why Join IGRCFP? </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-10">
                    <!--=== Bizzen Image Box ===-->
                    <div class="bizzen-image-box mb-5 mb-xl-0 " >
                        <p class="mb-3" data-aos="fade-up" data-aos-duration="1200">
                            At IGRCFP, we go beyond certification—we build careers and shape leaders. By joining us, you become part of a global network of governance, risk, compliance, and financial crime professionals who are driving change across industries. Membership gives you access to exclusive insights, research, and training, alongside opportunities for professional recognition, CPD credits, and the use of respected post-nominals. Whether you are in banking, fintech, insurance, or regulation, IGRCFP equips you with the knowledge, tools, and connections to stay ahead, stay compliant, and stand out as a trusted expert.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- become_our_membership.blade --}}
        @include('frontend.components.Join_IGRCFP')
        {{-- become_our_membership.blade --}}


    </section>
<!--======  End Why Join  ======-->

<!--======  Start Faq Section  ======-->
<section class="bizzen-faq-sec pt-115 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="bizzen-content-box mb-5 mb-xl-0">
                    <div class="section-title">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">FAQ</span>
                        <h2 class="text-anm">Got Questions? We’ve Got Answers.</h2>
                    </div>
                    <p data-aos="fade-up" data-aos-duration="1200">
                    Have questions about IGRCFP? We’ve put together answers to some of the most common questions about our membership, certifications, events, and resources. If you need more help, feel free to reach out through our Contact page
                    </p>
                </div>
            </div>
            <div class="col-xl-6">
                <!--====== Accordion  ======-->
                <div class="accordion" id="accordionOne" data-aos="fade-up" data-aos-duration="1200">
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true">
                                Who can become a member of IGRCFP?
                            </h6>
                        </div>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false">
                                Are the certifications recognised internationally?
                            </h6>
                        </div>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false">
                                How do I register for an event?
                            </h6>
                        </div>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false">
                                Do I need prior experience to take a course?
                            </h6>
                        </div>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                                Who can become a member of IGRCFP?
                            </h6>
                        </div>
                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                    <!--====== Accordion Item  ======-->
                    <div class="accordion-card style-two mb-25">
                        <div class="accordion-header">
                            <h6 class="accordion-title" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false">
                                Who can become a member of IGRCFP?
                            </h6>
                        </div>
                        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                            <div class="accordion-content">
                                <p>There are many variations of passages of Lom Ipsum available, but the majority have suffered alteration in form, by injected humor, or randomized</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Faq Section  ======-->


 <!--======  Start Testimonial Section  ======-->
      <section class="bizzen-testimonial_three pt-115 pb-120">
          <div class="container">
              <div class="row align-items-center">
                  <div class="col-lg-6">
                      <!--=== Section Title ===-->
                      <div class="section-title mb-60">
                          <span class="sub-title" data-aos="fade-up" data-aos-duration="800">Testimonial</span>
                          <h2 class="text-anm">What Our Client Say?</h2>
                      </div>
                  </div>
                  <div class="col-lg-6">
                      <!--=== Testimonial Arrows ===-->
                      <div class="testimonial-arrows mb-60" data-aos="fade-up" data-aos-duration="800"></div>
                  </div>
              </div>
              <!--=== Testimonial Slider ===-->
              <div class="testimonial-slider-three" data-aos="fade-up" data-aos-duration="1000">
                  <!-- Bizzen Testimonial Item -->
                  <div class="bizzen-testimonial-item style-three">
                      <div class="testimonial-content">
                          <div class="quote-ratings-wrap">
                            <div class="author-thumb-item">
                                <div class="author-thumb">
                                    <img src="{{ asset('assets/images/innerpage/testimonial/author-img1.png')}}" style="width:60px; border-radius:50%" alt="author image">
                                </div>
                                <div class="author-info">
                                    <h5>Jackson Hobber</h5>
                                    <span class="position">CEO,AB Tech</span>
                                </div>
                            </div>
                              <div class="ratings">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star-half"></i>
                              </div>
                          </div>
                          <p>“Iterative approaches corporate strategy fo collaborative thinking further the overall val proposition organically grows the holistic world views of disruptive innovation via work place diversity strategies”</p>
                         
                      </div>
                  </div>
                  <!-- Bizzen Testimonial Item -->
                  <div class="bizzen-testimonial-item style-three">
                      <div class="testimonial-content">
                          <div class="quote-ratings-wrap">
                               <div class="author-thumb">
                                    <img src="{{ asset('assets/images/innerpage/testimonial/author-img1.png')}}" style="width:60px; border-radius:50%" alt="author image">
                                </div>
                              <div class="ratings">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star-half"></i>
                              </div>
                          </div>
                          <p>“Iterative approaches corporate strategy fo collaborative thinking further the overall val proposition organically grows the holistic world views of disruptive innovation via work place diversity strategies”</p>
                          
                      </div>
                  </div>
                  <!-- Bizzen Testimonial Item -->
                  <div class="bizzen-testimonial-item style-three">
                      <div class="testimonial-content">
                          <div class="quote-ratings-wrap">
                               <div class="author-thumb">
                                    <img src="{{ asset('assets/images/innerpage/testimonial/author-img1.png')}}" style="width:60px; border-radius:50%" alt="author image">
                                </div>
                              <div class="ratings">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star-half"></i>
                              </div>
                          </div>
                          <p>“Iterative approaches corporate strategy fo collaborative thinking further the overall val proposition organically grows the holistic world views of disruptive innovation via work place diversity strategies”</p>
                         
                      </div>
                  </div>
                  <!-- Bizzen Testimonial Item -->
                  <div class="bizzen-testimonial-item style-three">
                      <div class="testimonial-content">
                          <div class="quote-ratings-wrap">
                               <div class="author-thumb">
                                    <img src="{{ asset('assets/images/innerpage/testimonial/author-img1.png')}}" style="width:60px; border-radius:50%" alt="author image">
                                </div>
                              <div class="ratings">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star-half"></i>
                              </div>
                          </div>
                          <p>“Iterative approaches corporate strategy fo collaborative thinking further the overall val proposition organically grows the holistic world views of disruptive innovation via work place diversity strategies”</p>
                         
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <!--======  End Testimonial Section  ======-->

@endsection

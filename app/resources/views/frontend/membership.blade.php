@extends('layouts.app')

@section('content')

<!--======  Start Who We Section  ======-->
<section class="bizzen-we_one pb-100 pt-110">
    <div class="container">
        <div class="row">
           
            <div class="col-xl-6">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box text-justify-content">
                    <div class="section-title">
                        <br/> <br/>
                        <h2 class="text-anm">Knowledgeable And Trustworthy Experts</h2>
                    </div>
                    <p class="mb-30" data-aos="fade-up" data-aos-duration="1200">
                        Join a trusted professional community advancing excellence in governance, compliance, and financial crime prevention. Membership at IGRCFP connects you with peers across the world, gives you access to exclusive resources, and provides professional recognition that sets you apart.
                    </p>
                    <div class="bizzen-button">
                        <a style="border-radius: 8px" href="{{  route('login') }}" class="theme-btn style-one">Become a Member Today </a>
                    </div>
                </div>
            </div>
             <div class="col-xl-6">
                <!--=== Bizzen Image ===-->
                <div class="bizzen-image mb-5 mb-xl-0" data-aos="fade-up" data-aos-duration="1200">
                    <img src="assets/images/home-three/gallery/membership.png" alt="who we">
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->

 <!--======  Start Who We Section  ======-->
<section class="bizzen-we_two pt-120 pb-20">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-10">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box">
                    <!--=== Section Title ===-->
                    <div class="section-title mb-30">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Why Join?</span>
                        <h2 class="text-anm">Why Join IGRCFP?</h2>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-xl-7 col-lg-10">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0 " >
                    <p class="mb-3 " data-aos="fade-up" data-aos-duration="1200">
                        At IGRCFP, we go beyond certification—we build careers and shape leaders. By joining us, you become part of a global network of governance, risk, compliance, and financial crime professionals who are driving change across industries. Membership gives you access to exclusive insights, research, and training, alongside opportunities for professional recognition, CPD credits, and the use of respected post-nominals. Whether you are in banking, fintech, insurance, or regulation, IGRCFP equips you with the knowledge, tools, and connections to stay ahead, stay compliant, and stand out as a trusted expert.
                    </p>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->


<!--======  Start Why Join  ======-->
<section class="bizzen-we_two pt-120 pb-120">
     {{-- Join_IGRCFP --}}
    @include('frontend.components.Join_IGRCFP')
    {{-- Join_IGRCFP--}}

  
</section>
<!--======  End Why Join  ======-->

<!--======  Start Project Section  ======-->
<section class="bizzen-service_one pt-80  bg_cover pb-50">
   

    {{-- become_our_membership.blade --}}
    @include('frontend.components.become_our_membership')
    {{-- become_our_membership.blade --}}

    <div class="container">
        
        <div class="features-wrapper" >
            <div class="row "> 
                <div class="col-xl-4 col-md-6 col-sm-12 item-column ">
                    <!--=== Bizzen Features Item ===-->
                    <div style="text-align: left"  class=" bizzen-features-item style-one" data-aos="fade-up" data-aos-duration="1200">
                        <div class="content" >
                            <h6>Category</h6>
                            <div class="mt-50">
                            </div>
                            <p>Student Affiliate</p>
                            <div class="mt-50">
                            </div>
                            <p>Associate Member (A.IGRCFP)</p>
                            <div class="mt-50">
                            </div>
                            <p>Professional Member</p>
                            <div class="mt-50">
                            </div>
                            <p>Fellow (F.IGRCFP)</p>
                            <div class="mt-50">
                            </div>
                            <p>Corporate Membership</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-12 item-column">
                    <!--=== Bizzen Features Item ===-->
                    <div style="text-align: left"  class="bizzen-features-item style-one" data-aos="fade-up" data-aos-duration="1400">
                        <div class="content">
                            <h4>Annual Fee</h4>
                            <div class="mt-50">
                            </div>
                            <p>€50</p>
                            <div class="mt-50">
                            </div>
                            <p>€150</p>
                            <div class="mt-50">
                            </div>
                            <p>€250</p>
                            <div class="mt-50">
                            </div>
                            <p>€350</p>
                            <div class="mt-50">
                            </div>
                            <p>€1500</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-md-6 col-sm-12 item-column">
                    <!--=== Bizzen Features Item ===-->
                    <div style="text-align: left" class="bizzen-features-item style-one" data-aos="fade-up" data-aos-duration="1600">
                        <div class="content">
                            <h4>Benefits</h4>
                            <div class="mt-50">
                            </div>
                            <p>Access to online community, selected resources, and discounts on training.</p>
                            <div class="mt-20">
                            </div>
                            <p>Full access to resources, participation in events, and certification discounts.</p>
                            <div class="mt-20">
                            </div>
                            <p>Full access to resources, participation in events, and certification discounts.</p>
                            <div class="mt-20">
                            </div>
                            <p>Leadership recognition, eligibility for governance roles, and priority speaker slots.</p>
                            <div class="mt-20">
                            </div>
                            <p>Multi-user access for teams, brand recognition, advisory engagement, and event sponsorship discounts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Project Section  ======-->


<!--======  Start Service Details Section  ======-->
<section class="service-details-sec pt-80 pb-95">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-xl-12">
                <!--=== Section Title ===-->
                <div class="section-title text-left mb-60">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="1000">Mentorship programmme</span>
                    <h2 class="text-anm">Know More About Us</h2>
                    <div class="content-wrap">
                        <p data-aos="fade-up" data-aos-duration="1200">
                            At IGRCFP, we believe learning goes beyond the classroom. Our mentorship programme pairs senior professionals with aspiring practitioners to provide guidance, career support, and industry insights. Whether you are a mentor sharing your expertise or a mentee growing your skills, this programme helps you build meaningful professional relationships.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--=== Service Details Wrapper ===-->
        <div class="service-details-wrapper">
           
            <!--=== Process Wrapper ===-->
            {{-- <div class="process-wrapper">
               
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <!--=== Bizzen Process Item ===-->
                        <div class="bizzen-process-item style-three mb-40" data-aos="fade-up" data-aos-duration="800">
                            <div class="line"></div>
                               <div class="icon text-center" >
                    <img src="{{ asset('assets/images/home-three/icon/icon3.png')}}" alt="icon" style="width:50px">
                </div>
                            <div class="content">
                              
                                <h6>Join IGRCFP</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <!--=== Bizzen Process Item ===-->
                        <div class="bizzen-process-item style-three mb-40" data-aos="fade-up" data-aos-duration="1200">
                            <div class="line"></div>
                            <div class="content">
                                <h6>Apply as Mentor/Mentee</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <!--=== Bizzen Process Item ===-->
                        <div class="bizzen-process-item style-three mb-40" data-aos="fade-up" data-aos-duration="1400">
                            <div class="line"></div>
                            <div class="content">
                                <h6>Get Matched</h6>
                            </div>
                        </div>
                    </div>
                     <div class="col-xl-3 col-md-6 col-sm-12">
                        <!--=== Bizzen Process Item ===-->
                        <div class="bizzen-process-item style-three mb-40" data-aos="fade-up" data-aos-duration="1400">
                            <div class="line"></div>
                            <div class="content">
                                <h6>Start Mentorship</h6>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div> --}}
            <!--=== Intro Wrapper ===-->
            <div class="row justify-content-center">
                <div class="col-xl-5 col-md-6 col-sm-12">
                    <!--=== Blog Post Item ===-->
                    <div style="background-color: #FBFBFB; border:1px solid #0000001b; border-radius:8px" class="bizzen-blog-post-item style-two mb-40" data-aos="fade-up" data-aos-duration="1000">
                        <div class="post-thumbnail">
                            <img class="img-fluid mx-auto d-block w-25 " 
                            src="{{ asset('assets/images/innerpage/gallery/mentee.png')}}" alt="Post Thumbnail">
                        </div>
                        <div class="post-content">
                            <h4 class="title text-center">
                                <a href="#">For Mentees</a>
                            </h4>
                            <h6 class="mb-15">Benefits:</h6>
                            <ul class="check-list style-two mb-40" >
                                <li>Learn from experienced professionals.</li>
                                <li>Gain career guidance and real-world insights.</li>
                                <li>Build your network and confidence.</li>
                            </ul>
                            <p>Eligibility: Available to Student Affiliates & Associate Members</p>
                            <a href="{{ route('login') }}" class="read-more style-one">Join as a Mentee</a>
                        </div>
                    </div>
                </div>
                <div  class="col-xl-5 col-md-6 col-sm-12">
                    <!--=== Blog Post Item ===-->
                    <div style="background-color: #FBFBFB; border:1px solid #0000001b; border-radius:8px" 
                    class="bizzen-blog-post-item style-two mb-40" data-aos="fade-up" data-aos-duration="1200">
                        <div class="post-thumbnail">
                            <img class="img-fluid mx-auto d-block w-25 "
                            src="{{ asset('assets/images/innerpage/gallery/mentor.png')}}" alt="Post Thumbnail">
                        </div>
                        <div class="post-content">
                            
                            <h4 class="title text-center">
                                <a href="#">For Mentors</a>
                            </h4>
                            <h6 class="mb-15">Benefits:</h6>
                            <ul class="check-list style-two mb-40" >
                                <li>Share expertise and give back.</li>
                                <li>Strengthen leadership & coaching skills.</li>
                                <li>Gain recognition as an industry leader.</li>
                            </ul>
                            <p>Eligibility: Available to Student Affiliates & Associate Members</p>
                            <a href="{{ route('login') }}" class="read-more style-one">Join as a Mentor</a>
                        </div>
                    </div>
                </div>
            
            </div>
           
        </div>
    </div>
</section>
<!--======  End Service Details Section  ======-->
                


<!--======  Start Become Our Membership ======-->
<section class="bizzen-service_one pt-115  bg_cover pb-50" style="background-image: url(assets/images/home-one/bg/service-bg.png);">
    <div class="container">
        <div class="row ">
            <div class="col-xl-6 col-lg-8">
                <!--=== Section Title ===-->
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-down" data-aos-duration="1000"> Membership</span>
                    <h2 class="text-anm">How Membership Works</h2>
                </div>
            </div>
        </div>
        <div class="row ">
           <div class="col-xl-3 col-md-6">
            <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7 !important;">
                <div class="" >
                    <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                    <div class="">
                        <p class="title">
                            <a href="#"  style=" font-weight: 400; color: #F0F0F0;">Choose the membership category that fits you.</a>
                        </p>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-xl-3 col-md-6">
            <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                <div class="">
                <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                <div class="">
                    <p class="title">
                    <a href="#"  style=" font-weight: 400; color: #F0F0F0;">
                        Complete the membership application form</a>
                    </p>
                </div>
                </div>
            </div>
            </div>

           <div class="col-xl-3 col-md-6">
            <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                <div class="">
                <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                <div class=""><p class="title">
                    <a href="#" style="font-weight: 400; color: #F0F0F0;">
                        Pay your annual membership fee securely online.</a></p>
                    </div>
                </div>
            </div>
            </div>

           <div class="col-xl-3 col-md-6">
            <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                <div class="" style="padding-bottom: 0px;">
                <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                <div class="">
                    <p class="title">
                        <a href="#" style="font-weight: 400; color: #F0F0F0;">
                        Start accessing your member benefits immediately.
                        </a>
                    </p>
                    <br/>
                </div>
                </div>
            </div>
            </div>

        </div>
    </div>
</section>
<!--======  End Become Our Membership ======-->

@endsection
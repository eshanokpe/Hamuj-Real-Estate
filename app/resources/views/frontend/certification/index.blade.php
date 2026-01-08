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
                        <h2 class="text-anm">Advance Your Career. Build Institutional Resilience.</h2>
                    </div>
                    <p class="mb-50" data-aos="fade-up" data-aos-duration="1200">
                        Our professional certifications are designed to equip individuals and institutions with  globally relevant skills to tackle financial crime and compliance risks.
                    </p> 
                    <p class="mb-10" data-aos="fade-up" data-aos-duration="1200">
                        TRUSTED BY
                    </p>
                    <div class="bizzen-button">
                        <div class="row">
                            <div class="col">
                                <div class="bizzen-features-bg bg_cover pl-3 w-20" 
                                    style="background: linear-gradient(180deg, #15528B, #02182ce1); border-radius:10px ">
                                    <div class="bizzen-ratings-box text-center">
                                        <h2 class="text-white">40K+</h2>
                                        <p class="text-white">Leaners</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bizzen-features-bg bg_cover pl-3 w-20" 
                                    style="background: linear-gradient(180deg, #387D5D, #02182ce1); border-radius:10px ">
                                    <div class="bizzen-ratings-box text-center">
                                        <h2 class="text-white">100+</h2>
                                        <p class="text-white">Experts</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
             <div class="col-xl-6">
                <!--=== Bizzen Image ===-->
                <div class="bizzen-image mb-5 mb-xl-0" data-aos="fade-up" data-aos-duration="1200">
                    <img src="{{ asset('assets/images/home-three/gallery/certification.png')}}" alt="who we">
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->

<!--======  Start Service Details Section  ======-->
<section class="service-details-sec pt-50 pb-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!--=== Section Title ===-->
                <div class="section-title text-center mb-60">
                    <h2 class="title" data-aos="fade-up" data-aos-duration="1000">Industry-Relevant Programs to Set you Apart</h2>
                    <div class="content-wrap mb-10">
                        <p data-aos="fade-up" data-aos-duration="1200">
                           At IGRCFP, we provide practical training and globally recognized certifications in governance, risk, compliance, and financial crime prevention. Our programmes are designed to help professionals at every level build skills that matter.
                            Learn online, hybrid, or in-person — with real-world case studies, expert trainers, and assessments that ensure you can apply what you learn. All programs are CPD-accredited & benchmarked to international standards
                        </p>
                    </div>
                    <a style="border-radius: 8px" href="{{ route('training-calender') }}" class="theme-btn style-one">View Training Calender</a>
                </div>
            </div>
        </div>
        <!--=== Service Details Wrapper ===-->
        

        <div class="row justify-content-center">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1000" style="border-radius:10px; border: 0px #fff ">
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
                        <a href="{{ route('certifications.cgfcs') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===--> 
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1200" style="border-radius:10px; border: 0px #fff ">
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
                        <a href="{{ route('certifications.diploma.grc-financial-crime-prevention')}}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1400" style="border-radius:10px; border: 0px #fff ">
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
                        <a href="{{ route('certifications.cybersecurity-finance') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- 2nd row --}}
        <div class="row justify-content-center">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1000" style="border-radius:10px; border: 0px #fff ">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img1.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content ">
                        <h4 class="title"><a href="{{ route('certifications.risk-analytics-monitoring') }}">
                            Monitoring, Reporting & Risk Analytics</a>
                        </h4>
                        <p>
                            Equips compliance teams with tools to design monitoring frameworks, track key risk indicators, and use analytics for regulatory reporting and board-level engagement.
                        </p>
                        <a href="{{ route('certifications.risk-analytics-monitoring') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1200" style="border-radius:10px; border: 0px #fff ">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img2.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content">
                        
                        <h4 class="title">
                            <a href="{{ route('certifications.regulatory-compliance') }}">
                            Regulatory Compliance & Supervisory Engagement
                            </a>
                        </h4>
                        <p>
                            Covers global regulatory requirements, reporting obligations, and how to 
                            engage effectively with supervisors. Includes practical role-play for mock regulatory interviews.
                        </p>
                        <a href="{{ route('certifications.regulatory-compliance') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1400" style="border-radius:10px; border: 0px #fff ">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img3.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content">
                        <h4 class="title"><a href="{{ route('certifications.regtech-suptech') }}">
                            RegTech, SupTech & Innovation in Compliance
                        </a></h4>
                        <p>
                            Explores cutting-edge technology for compliance and supervision, including AI, blockchain, real-time monitoring, and data-driven oversight.
                        </p>
                        <a href="{{ route('certifications.regtech-suptech') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            
        </div>
        {{-- 3rd row --}}
        <div class="row justify-content-left">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1000" style="border-radius:10px; border: 0px #fff ">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img1.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content ">
                        <h4 class="title"><a href="{{ route('certifications.insurtech-fintech') }}">
                            InsurTech, FinTech & Emerging Market Compliance</a>
                        </h4>
                        <p>
                            Specialised course addressing compliance challenges for FinTech and InsurTech models in Africa and global markets. Covers mobile money, cross-border payments, crypto, and ESG in digital finance.
                        </p>
                        <a href="{{ route('certifications.insurtech-fintech') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Blog Post Item ===-->
                <div class="bizzen-blog-post-item style-three mb-40" data-aos="fade-up" data-aos-duration="1200" style="border-radius:10px; border: 0px #fff ">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/service/service-img2.png')}}" alt="Post Thumbnail">
                    </div>
                    <div class="post-content">
                        
                        <h4 class="title">
                            <a href="{{ route('certifications.executive-masterclasses') }}">
                            Executive Masterclasses & Short Courses
                            </a>
                        </h4>
                        <p>
                            Focused electives on emerging topics, including AI in compliance, ESG, forensic investigations, sanctions, and leadership in governance. Designed for senior professionals and executives.
                        </p>
                       <a href="{{ route('certifications.executive-masterclasses') }}" class="read-more style-one fw-normal fs-6">Learn More </a>
                    </div>
                </div>
            </div>
            
            
        </div>


    </div>
</section>
<!--======  End Service Details Section  ======-->
                


 <!--======  Start Who We Section  ======-->
<section class="bizzen-we_two pt-80 pb-20">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-10">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box">
                    <!--=== Section Title ===-->
                    <div class="section-title mb-30">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Why Join?</span>
                        <h2 class="text-anm">Why Join IGRCFP Training?</h2>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-xl-7 col-lg-10">
                <!--=== Bizzen Image Box ===-->
                <div class="bizzen-image-box mb-5 mb-xl-0 " >
                    <p class="mb-3 " data-aos="fade-up" data-aos-duration="1200">
                        At IGRCFP, our goal is to prepare professionals and institutions with the knowledge and tools they need to stay ahead of risks, meet global standards, and prevent financial crime. Here’s what makes our programmes stand out
                    </p>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>
<!--======  End Who We Section  ======-->


<!--======  Start Why Join  ======-->
<section class="bizzen-we_two pt-120 pb-120">
    
    <div class="container ">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5">
            <div class="col" >
                <div class="bizzen-service-item style-one second mb-30" style=" border: none;">
                    <div class="service-inner-content bg-white" >
                    <div class="icon text-center bg-white" >
                        <img src="{{ asset('assets/images/home-three/icon/icon3.png')}}" alt="icon" class="w-50">
                    </div>
                    <div class="text-center bg-white">
                        <p class="title" style="font-size: 20px; font-weight: 400;">
                            <a href="#" >
                                Globally Recognised & CPD-Accredited
                            </a>
                        </p>
                        <p style="color: #666666;" class="mt-10" >
                            Earn certifications and diplomas that are respected across industries and jurisdictions.
                        </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" >
            <div class="bizzen-service-item style-one mb-30" style=" border: none;">
                <div class="service-inner-content" >
                <div class="icon text-center bg-white" >
                    <img src="{{ asset('assets/images/home-three/icon/icon4.png')}}" alt="icon"  class="w-50"></div>
                <div class="text-center bg-white">
                    <p class="title">
                        <a href="#"  style="font-size: 20px; font-weight: 400;">Real-World Learning</a>
                    </p>
                    <p style="color: #666666;" class="mt-10">
                       Every programme includes capstone projects, case studies, and assessments tailored to industries and regulatory environments, ensuring you can apply what you learn.
                    </p>
                    </div>
                </div>
            </div>
            </div>

            <div class="col" >
            <div class="bizzen-service-item style-one mb-30" style=" border: none;">
                <div class="service-inner-content bg-white" >
                <div class="icon text-center bg-white" >
                    <img src="{{ asset('assets/images/home-three/icon/icon5.png')}}" alt="icon" class="w-50"></div>
                <div class="text-center bg-white">
                    <p class="title mt-10">
                        <a href="#"  style="font-size: 20px; font-weight: 400;">
                        Expert-Led Teaching
                        </a>
                    </p>
                    <p style="color: #666666;" class="mt-10">
                        Learn from practitioners, regulators, and global experts with years of experience in governance, compliance, risk, and financial crime prevention.
                    </p>
                    </div>
                </div>
            </div>
            </div>

            <div class="col" >
                <div class="bizzen-service-item style-one mb-30 bg-white" style=" border: none; background-white">
                    <div class="service-inner-content bg-white" >
                        <div class="icon text-center bg-white" >
                            <img src="{{ asset('assets/images/home-three/icon/icon6.png')}}" alt="icon" class="w-50">
                        </div>
                        <div class="text-center bg-white">
                            <p class="title">
                                <a href="#"  style="font-size: 20px; font-weight: 400;">Flexible Delivery</a>
                            </p>
                            <p style="color: #666666;" class="mt-10">
                                Access courses online, in-person, or hybrid — designed to fit around your career and lifestyle.
                            </p>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col" >
            <div class="bizzen-service-item style-one mb-30 " style=" border: none;">
                <div class="service-inner-content bg-white" >
                    <div class="icon text-center bg-white" >
                        <img src="{{ asset('assets/images/home-three/icon/icon7.png')}}" alt="icon" class="w-50"></div>
                    <div class="text-center bg-white">
                        <p class="title">
                            <a href="#"  style="font-size: 20px; font-weight: 400;">Membership Benefits</a>
                        </p>
                        <p style="color: #666666;" class="mt-10">
                            As a member of IGRCFP, you enjoy exclusive discounts, networking opportunities, mentorship, and post-nominals that boost your professional profile.      
                        </p>
                        <br/>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <h6 class="text-center fw-bolder">
            All our programmes are designed to go beyond theory. Every course includes real-world projects, case studies, and practical assessments tailored to industries and jurisdictions. This ensures that you not only learn concepts but also develop the skills to apply them directly in your workplace.
        </h6>
    </div>
</section>
<!--======  End Why Join  ======-->




@endsection
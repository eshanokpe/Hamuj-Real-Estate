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
                    <h2 style="color: black;">Monitoring, Reporting & Risk Analytics</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">Monitoring, Reporting & Risk Analytics</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->

<!--======  Start Program Overview Section  ======-->
<section class="bizzen-we_two pt-20 pb-20">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-10">
                <div class="bizzen-content-box">
                    <div class="section-title mb-30">
                        <h2 class="text-anm">Program Overview</h2>
                    </div>
                    <div class="bizzen-image-box mb-5 mb-xl-0">
                        <p class="mb-3" data-aos="fade-up" data-aos-duration="1200">
                            This specialized course equips compliance and risk teams with advanced tools 
                            to track, measure, and report risk and compliance performance in alignment 
                            with regulatory expectations.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            Participants will learn to design effective monitoring frameworks, develop 
                            insightful dashboards, and create regulatory reports that demonstrate 
                            compliance maturity and risk management effectiveness.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 4 weeks intensive program</li>
                        <li class="pt-10"><strong>Format:</strong> Virtual live sessions with hands-on workshops</li>
                        <li class="pt-10"><strong>Certification:</strong> Certified Monitoring & Reporting Specialist (CMRS)</li>
                        <li class="pt-10"><strong>Level:</strong> Intermediate to Advanced</li>
                        <li class="pt-10"><strong>CPD Credits:</strong> 35 hours accredited</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Program Overview Section  ======-->

<!--======  Start Learning Outcomes Section  ======-->
<section class="bizzen-we_two pt-120 pb-50 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10">
                <div class="bizzen-content-box">
                    <div class="section-title mb-30">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Objectives</span>
                        <h2 class="text-anm">Learning Outcomes</h2>
                    </div>
                    <div class="bizzen-content-box" data-aos="fade-up" data-aos-duration="1600">
                        <h6>Upon successful completion, participants will be able to:</h6>
                        <ul class="check-list style-one mb-40 mt-20">
                            <li><i class="far fa-check"></i>
                                Design and implement comprehensive monitoring frameworks for compliance programs
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Develop and track KPIs and KRIs for effective risk management
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Create risk-based reports for boards, senior management, and regulators
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Implement supervisory technology (SupTech) solutions for automated monitoring
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Apply data analytics and AI-driven approaches to compliance metrics
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Prepare regulatory reports including SAR/STR, ESG disclosures, and prudential risk reports
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Learning Outcomes Section  ======-->

<!--======  Start Target Audience Section  ======-->
<section class="bizzen-service_one pt-115 pb-50" style="background-image: url(assets/images/home-one/bg/service-bg.png);">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Audience</span>
                    <h2 class="text-anm">Who Should Enroll?</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7 !important;">
                    <div class="service-inner-content">
                        <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                        <div class="">
                            <p class="title">
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">Compliance Monitoring Officers</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                    <div class="service-inner-content">
                        <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                        <div class="">
                            <p class="title">
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">
                                    Risk Reporting Analysts
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                    <div class="service-inner-content">
                        <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                        <div class="">
                            <p class="title">
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">
                                    Regulatory Affairs Specialists
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="bizzen-service-item style-one mb-30" style="background-color: #0097A7;">
                    <div class="service-inner-content" style="padding-bottom: 0px;">
                        <div class="icon"><img src="{{ asset('assets/images/home-three/icon/icon8.svg')}}" alt="icon" style="width:50px"></div>
                        <div class="">
                            <p class="title">
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">
                                    Internal Audit & Control Professionals
                                </a>
                            </p>
                            <br/><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Target Audience Section  ======-->

<!--======  Start Course Modules Section  ======-->
<section class="bizzen-blog-grid-sec pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Curriculum</span>
                    <h2 class="text-anm">Course Modules</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $modules = [
                    [
                        'title' => 'Module 1: Designing Effective Monitoring Frameworks',
                        'items' => [
                            'Principles of compliance monitoring and testing',
                            'Risk-based monitoring program design',
                            'Monitoring methodologies and sampling techniques',
                            'Continuous monitoring vs periodic testing approaches'
                        ]
                    ],
                    [
                        'title' => 'Module 2: KPIs, KRIs, and Compliance Dashboards',
                        'items' => [
                            'Key Performance Indicators (KPIs) for compliance functions',
                            'Key Risk Indicators (KRIs) development and tracking',
                            'Executive dashboard design and visualization techniques',
                            'Real-time monitoring and alert systems'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Risk-Based Reporting for Boards and Regulators',
                        'items' => [
                            'Board-level risk reporting requirements',
                            'Regulatory reporting expectations and timelines',
                            'Risk appetite statement alignment in reporting',
                            'Transparency and disclosure best practices'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Supervisory Technology (SupTech) for Monitoring',
                        'items' => [
                            'Introduction to SupTech and RegTech solutions',
                            'Automated transaction monitoring systems',
                            'Regulatory data submission platforms',
                            'Implementation challenges and success factors'
                        ]
                    ],
                    [
                        'title' => 'Module 5: Data Analytics & AI-Driven Compliance Metrics',
                        'items' => [
                            'Data analytics for compliance pattern detection',
                            'Machine learning applications in risk monitoring',
                            'Predictive analytics for risk forecasting',
                            'Data quality and governance for analytics'
                        ]
                    ],
                    [
                        'title' => 'Module 6: Reporting Case Studies',
                        'items' => [
                            'Suspicious Activity/Transaction Reports (SAR/STR)',
                            'ESG and sustainability disclosures',
                            'Prudential risk reporting requirements',
                            'Cross-border regulatory reporting challenges'
                        ]
                    ]
                ];
            @endphp

            @foreach($modules as $index => $module)
                <div class="col-xl-6 col-md-6 col-sm-12 mb-30">
                    <div class="bizzen-blog-post-item style-two" 
                         data-aos="fade-up" 
                         data-aos-duration="{{ 1000 + ($index * 200) }}"
                         style="background-color: #E8EDF7; border-radius:8px; height: 100%;">
                        <div class="post-content">
                            <h4 class="title"><a href="#">{{ $module['title'] }}</a></h4>
                            <ul class="check-list style-two mt-20">
                                @foreach($module['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--======  End Course Modules Section  ======-->

<!--======  Start Assessment Section  ======-->
<section class="bizzen-we_two pt-80 pb-80 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="bizzen-content-box text-center">
                    <div class="section-title mb-40">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Certification</span>
                        <h2 class="text-anm">Certified Monitoring & Reporting Specialist (CMRS)</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="mb-30">
                                    <h4 class="mb-20 text-primary">Certification Requirements</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Complete all 6 course modules</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Pass final examination (minimum 70% score)</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Submit monitoring framework design project</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Create comprehensive risk dashboard prototype</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-30 pt-30 border-top">
                                    <h4 class="mb-20 text-primary">CMRS Designation Benefits</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Use "CMRS" post-nominal designation</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Digital certificate and professional credential</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Access to monitoring & reporting professionals network</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Continuing professional development resources</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Assessment Section  ======-->

<!--======  Start CTA Section  ======-->
<section class="bizzen-cta_one pt-100 pb-100 bg_cover" style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="bizzen-cta-content text-center">
                    <h2 class="title  mb-30">Master Compliance Monitoring & Risk Reporting</h2>
                    <p class=" mb-40">Join compliance and risk professionals in this specialized certification program designed to enhance monitoring capabilities and regulatory reporting effectiveness.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Request Course Outline</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
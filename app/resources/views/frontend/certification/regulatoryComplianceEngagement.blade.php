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
                    <h2 style="color: black;">Regulatory Compliance & Supervisory Engagement</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">Regulatory Compliance & Supervisory Engagement</li>
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
                            This comprehensive program teaches professionals how to effectively navigate 
                            evolving regulatory environments, build strong relationships with regulators, 
                            and ensure enterprise-wide compliance.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            Participants will learn practical strategies for managing regulatory change, 
                            preparing for supervisory reviews, and responding effectively to enforcement 
                            actions through hands-on exercises and real-world case studies.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 5 weeks intensive program</li>
                        <li class="pt-10"><strong>Format:</strong> Virtual live sessions with interactive workshops</li>
                        <li class="pt-10"><strong>Certification:</strong> Certified Regulatory Compliance Specialist (CRCS)</li>
                        <li class="pt-10"><strong>Level:</strong> Intermediate to Advanced</li>
                        <li class="pt-10"><strong>CPD Credits:</strong> 40 hours accredited</li>
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
                                Navigate global regulatory frameworks (FATF, EU AMLA, SEC, FCA, CBN, etc.)
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Implement licensing, prudential, and conduct requirements effectively
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Fulfill regulatory reporting obligations accurately and timely
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Prepare for and manage supervisory reviews and onsite inspections
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Develop strategies for managing regulatory change and enforcement actions
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Engage effectively with regulators through mock interviews and simulations
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
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">Regulatory Compliance Officers</a>
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
                                    Financial Institution Managers
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
                                    Legal & Regulatory Affairs Specialists
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
                                    Financial Services Consultants
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
                        'title' => 'Module 1: Global Regulatory Landscape',
                        'items' => [
                            'FATF recommendations and international standards',
                            'EU AMLA (Anti-Money Laundering Authority) framework',
                            'SEC (US Securities and Exchange Commission) regulations',
                            'FCA (UK Financial Conduct Authority) requirements',
                            'CBN (Central Bank of Nigeria) and other African regulators',
                            'Comparative analysis of regulatory approaches'
                        ]
                    ],
                    [
                        'title' => 'Module 2: Licensing, Prudential & Conduct Requirements',
                        'items' => [
                            'Financial institution licensing processes',
                            'Prudential requirements for capital and liquidity',
                            'Conduct risk management and consumer protection',
                            'Fit and proper assessments for management',
                            'Ongoing regulatory obligations post-licensing'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Regulatory Reporting Obligations',
                        'items' => [
                            'Periodic regulatory reporting requirements',
                            'Ad-hoc and event-driven reporting',
                            'Data quality and validation for regulatory reports',
                            'Timelines and submission processes',
                            'Common reporting errors and how to avoid them'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Supervisory Reviews & Onsite Inspections',
                        'items' => [
                            'Preparing for regulatory examinations',
                            'Onsite inspection protocols and procedures',
                            'Documentation and evidence preparation',
                            'Managing regulator interactions during inspections',
                            'Post-inspection follow-up and remediation'
                        ]
                    ],
                    [
                        'title' => 'Module 5: Managing Regulatory Change & Enforcement Actions',
                        'items' => [
                            'Regulatory change management frameworks',
                            'Impact assessment of new regulations',
                            'Responding to regulatory queries and information requests',
                            'Managing enforcement actions and penalties',
                            'Remediation plans and regulatory engagement'
                        ]
                    ],
                    [
                        'title' => 'Module 6: Practical Role-Play Session',
                        'items' => [
                            'Mock regulatory interview simulation',
                            'Regulator presentation preparation',
                            'Crisis communication with regulators',
                            'Building effective regulator relationships',
                            'Practical case studies and scenarios'
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
                        <h2 class="text-anm">Certified Regulatory Compliance Specialist (CRCS)</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="mb-30">
                                    <h4 class="mb-20 text-primary">Certification Requirements</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Complete all 6 course modules</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Pass final regulatory compliance examination</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Participate in mock regulatory interview simulation</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Submit regulatory change management case study</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-30 pt-30 border-top">
                                    <h4 class="mb-20 text-primary">CRCS Designation Benefits</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Use "CRCS" post-nominal designation</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Digital certificate and professional credential</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Access to regulatory compliance professionals network</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Regulatory updates and continuing education resources</li>
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
                    <h2 class="title  mb-30">Excel in Regulatory Compliance & Supervisory Engagement</h2>
                    <p class=" mb-40">Join regulatory professionals from financial institutions worldwide in this comprehensive certification program designed to enhance regulatory compliance effectiveness and supervisory relationship management.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Download Program Brochure</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
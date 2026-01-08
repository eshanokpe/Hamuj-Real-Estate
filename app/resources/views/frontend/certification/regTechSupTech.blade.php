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
                    <h2 style="color: black;">RegTech, SupTech & Innovation in Compliance</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">RegTech, SupTech & Innovation in Compliance</li>
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
                            This cutting-edge program explores regulatory technology (RegTech) and 
                            supervisory technology (SupTech) solutions that are fundamentally 
                            reshaping the compliance ecosystem.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            Participants will gain practical insights into innovative technologies 
                            transforming compliance functions, from AI-powered monitoring to 
                            blockchain-based regulatory reporting and future quantum computing 
                            applications.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 5 weeks intensive program</li>
                        <li class="pt-10"><strong>Format:</strong> Virtual live sessions with technology demonstrations</li>
                        <li class="pt-10"><strong>Level:</strong> Intermediate to Advanced</li>
                        <li class="pt-10"><strong>Focus:</strong> Practical technology applications in compliance</li>
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
                                Understand the RegTech and SupTech ecosystems and their impact on compliance
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Implement AI, machine learning, and NLP solutions for AML/KYC processes
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Apply blockchain and distributed ledger technology in compliance and supervision
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Design and implement real-time transaction monitoring and case management systems
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Utilize SupTech tools for data-driven regulatory oversight
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Evaluate emerging technologies like quantum computing for future compliance applications
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
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">Compliance Technology Specialists</a>
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
                                    FinTech & RegTech Solution Providers
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
                                    Innovation & Digital Transformation Leaders
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
                                    Regulatory Technology Analysts
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
                        'title' => 'Module 1: Introduction to RegTech & SupTech Ecosystems',
                        'items' => [
                            'Evolution of regulatory technology landscape',
                            'Key players and solution providers in RegTech/SupTech',
                            'Regulatory challenges driving technology adoption',
                            'Global trends and regional variations in technology adoption',
                            'Investment landscape and venture capital in RegTech'
                        ]
                    ],
                    [
                        'title' => 'Module 2: AI, Machine Learning & Natural Language Processing in AML/KYC',
                        'items' => [
                            'Artificial intelligence applications in transaction monitoring',
                            'Machine learning algorithms for suspicious activity detection',
                            'Natural Language Processing for customer due diligence',
                            'Predictive analytics for risk scoring and profiling',
                            'Implementation challenges and ethical considerations'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Blockchain & DLT in Compliance & Supervision',
                        'items' => [
                            'Blockchain fundamentals for compliance professionals',
                            'Distributed ledger technology for regulatory reporting',
                            'Smart contracts in automated compliance processes',
                            'Tokenization and digital assets compliance',
                            'Privacy and security considerations in blockchain solutions'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Real-Time Transaction Monitoring & Case Management',
                        'items' => [
                            'Advanced transaction monitoring systems architecture',
                            'Real-time alert generation and prioritization',
                            'Automated case management workflows',
                            'Integration with existing compliance infrastructure',
                            'Performance metrics and system optimization'
                        ]
                    ],
                    [
                        'title' => 'Module 5: SupTech Tools for Regulators – Data-Driven Oversight',
                        'items' => [
                            'Supervisory technology solutions for regulatory authorities',
                            'Data analytics platforms for regulatory supervision',
                            'Automated reporting and data submission systems',
                            'Risk-based supervision using technology tools',
                            'Regulator-fintech collaboration models'
                        ]
                    ],
                    [
                        'title' => 'Module 6: Future Outlook: Quantum Computing & Compliance',
                        'items' => [
                            'Introduction to quantum computing concepts',
                            'Potential applications in compliance and risk management',
                            'Quantum cryptography and secure communications',
                            'Timeline for practical quantum computing adoption',
                            'Preparing compliance functions for quantum era'
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
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Program Outcomes</span>
                        <h2 class="text-anm">Technology Innovation in Compliance</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="mb-30">
                                    <h4 class="mb-20 text-primary">Program Deliverables</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Comprehensive understanding of RegTech/SupTech landscape</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Practical knowledge of AI/ML applications in compliance</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Blockchain implementation strategies for regulatory compliance</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Technology roadmap for compliance innovation</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-30 pt-30 border-top">
                                    <h4 class="mb-20 text-primary">Professional Benefits</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Stay ahead of technology trends transforming compliance</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Enhanced ability to evaluate and implement technology solutions</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Network with technology and compliance innovation leaders</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Continuing education in emerging compliance technologies</li>
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
                    <h2 class="title  mb-30">Lead the Technology Transformation in Compliance</h2>
                    <p class=" mb-40">Join forward-thinking compliance and technology professionals in this innovative program exploring the cutting-edge technologies reshaping regulatory compliance and supervisory practices.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Request Technology Curriculum</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Enroll in Innovation Program</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
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
                    <h2 style="color: black;">InsurTech, FinTech & Emerging Market Compliance</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">InsurTech, FinTech & Emerging Market Compliance</li>
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
                            This specialized course explores the unique compliance, risk, and regulatory 
                            implications for InsurTech and FinTech business models, with particular focus 
                            on African and global emerging markets.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            Participants will gain practical insights into navigating the complex regulatory 
                            landscape of digital financial services, mobile money ecosystems, and innovative 
                            insurance technologies in developing economies.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 6 weeks comprehensive program</li>
                        <li class="pt-10"><strong>Format:</strong> Virtual live sessions with emerging market case studies</li>
                        <li class="pt-10"><strong>Certification:</strong> Certified FinTech & InsurTech Compliance Specialist (CFICS)</li>
                        <li class="pt-10"><strong>Focus:</strong> Africa and global emerging markets</li>
                        <li class="pt-10"><strong>CPD Credits:</strong> 45 hours accredited</li>
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
                                Identify and manage InsurTech and digital distribution risks
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Implement AML/CTF obligations for diverse FinTech business models
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Navigate regulatory sandboxes and innovation hubs effectively
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Address compliance challenges in cross-border payments, crypto, and stablecoins
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Manage compliance requirements for mobile money and digital lending platforms
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Integrate ESG principles and consumer protection in digital finance solutions
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
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">FinTech & InsurTech Founders</a>
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
                                    Emerging Market Compliance Officers
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
                                    Digital Financial Services Regulators
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
                                    Mobile Money Platform Managers
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
                        'title' => 'Module 1: InsurTech & Digital Distribution Risks',
                        'items' => [
                            'Insurance technology innovation landscape in emerging markets',
                            'Digital distribution channels and regulatory implications',
                            'Peer-to-peer insurance and microinsurance models',
                            'Claims automation and fraud detection technologies',
                            'Regulatory capital requirements for InsurTech companies'
                        ]
                    ],
                    [
                        'title' => 'Module 2: FinTech Business Models & AML/CTF Obligations',
                        'items' => [
                            'Diverse FinTech business model analysis',
                            'Payment institutions vs. electronic money institutions',
                            'Digital banking and neobank compliance frameworks',
                            'Risk-based approach for FinTech AML/CTF programs',
                            'Customer due diligence in digital-only environments'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Regulatory Sandboxes & Innovation Hubs',
                        'items' => [
                            'Global regulatory sandbox models and best practices',
                            'Innovation hub structures and participant requirements',
                            'Testing parameters and supervisory expectations',
                            'Sandbox graduation and full licensing pathways',
                            'Case studies: UK FCA, Singapore MAS, Kenya CMA sandboxes'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Cross-Border Payments, Crypto & Stablecoin Risks',
                        'items' => [
                            'Cross-border payment regulations and compliance',
                            'Cryptocurrency exchange compliance frameworks',
                            'Stablecoin regulatory treatment and reserve requirements',
                            'Travel rule implementation for virtual asset service providers',
                            'Emerging market approaches to crypto regulation'
                        ]
                    ],
                    [
                        'title' => 'Module 5: Compliance in Mobile Money & Digital Lending',
                        'items' => [
                            'Mobile money regulatory frameworks in Africa',
                            'Agent network management and oversight',
                            'Digital lending platforms and consumer credit regulations',
                            'Data privacy and protection in mobile financial services',
                            'Interoperability and systemically important payment systems'
                        ]
                    ],
                    [
                        'title' => 'Module 6: ESG & Consumer Protection in Digital Finance',
                        'items' => [
                            'Environmental, social, and governance considerations',
                            'Financial inclusion and responsible digital finance',
                            'Consumer protection frameworks for digital services',
                            'Transparency, fairness, and dispute resolution mechanisms',
                            'Financial literacy and digital capability building'
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
                        <h2 class="text-anm">Certified FinTech & InsurTech Compliance Specialist (CFICS)</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="mb-30">
                                    <h4 class="mb-20 text-primary">Certification Requirements</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Complete all 6 course modules</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Pass final examination on emerging market FinTech/InsurTech compliance</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Submit emerging market regulatory analysis case study</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Participate in regulatory sandbox simulation exercise</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-30 pt-30 border-top">
                                    <h4 class="mb-20 text-primary">CFICS Designation Benefits</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Use "CFICS" post-nominal designation</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Digital certificate and professional credential</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Access to FinTech/InsurTech compliance professionals network</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Continuing education in digital finance regulation updates</li>
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
                    <h2 class="title  mb-30">Master Digital Finance Compliance in Emerging Markets</h2>
                    <p class=" mb-40">Join FinTech, InsurTech, and compliance professionals from across Africa and emerging markets in this specialized certification program designed for the digital finance revolution.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Download Emerging Markets Curriculum</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Enroll in CFICS Program</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
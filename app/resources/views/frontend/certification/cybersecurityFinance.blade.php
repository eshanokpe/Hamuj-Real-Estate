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
                    <h2 style="color: black;">Cybersecurity & Data Security for Financial Institutions</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">Cybersecurity & Data Security for Financial Institutions</li>
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
                            This intensive course addresses cyber resilience, data protection, and information 
                            governance in today's digital-first financial sector. Designed for banking, insurance, 
                            and fintech professionals, it provides practical skills to protect financial institutions 
                            from evolving cyber threats.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            Participants will learn to implement robust cybersecurity frameworks, manage data privacy 
                            compliance, and develop incident response strategies tailored to financial services.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 5 days intensive / 6 weeks online</li>
                        <li class="pt-10"><strong>Format:</strong> In-person bootcamp or virtual live sessions</li>
                        <li class="pt-10"><strong>Certification:</strong> Certified Cybersecurity & Data Security Professional (CCDSP)</li>
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
                                Implement comprehensive cybersecurity frameworks for financial institutions
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Ensure compliance with data protection regulations (GDPR, POPIA, etc.)
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Develop and execute cyber risk management strategies for banking & insurance
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Design incident response and business continuity plans
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Implement robust digital identity and access control systems
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Analyze and mitigate ransomware, phishing, and insider threats
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
@include('frontend.certification.targetaudience')
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
                        'title' => 'Module 1: Fundamentals of Cybersecurity & Threat Landscape',
                        'items' => [
                            'Current cyber threat landscape for financial institutions',
                            'Attack vectors and vulnerability assessment',
                            'Cybersecurity frameworks (NIST, ISO 27001)',
                            'Regulatory requirements for financial sector'
                        ]
                    ],
                    [
                        'title' => 'Module 2: Data Security, Privacy, and GDPR/POPIA Compliance',
                        'items' => [
                            'Data classification and protection strategies',
                            'GDPR, POPIA, and global data privacy regulations',
                            'Data breach notification requirements',
                            'Privacy by design implementation'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Cyber Risk Management in Banking & Insurance',
                        'items' => [
                            'Cyber risk assessment methodologies',
                            'Third-party risk management for fintech partnerships',
                            'Cyber insurance considerations',
                            'Board-level cyber risk reporting'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Incident Response & Business Continuity Planning',
                        'items' => [
                            'Incident response team structure and roles',
                            'Digital forensics and evidence handling',
                            'Business impact analysis and recovery strategies',
                            'Crisis communication planning'
                        ]
                    ],
                    [
                        'title' => 'Module 5: Digital Identity, Authentication & Access Controls',
                        'items' => [
                            'Multi-factor authentication implementation',
                            'Identity and access management (IAM) systems',
                            'Privileged access management',
                            'Zero trust architecture principles'
                        ]
                    ],
                    [
                        'title' => 'Module 6: Case Studies: Ransomware, Phishing, and Insider Threats',
                        'items' => [
                            'Analysis of major financial sector breaches',
                            'Phishing simulation and employee training',
                            'Insider threat detection and prevention',
                            'Ransomware negotiation and recovery strategies'
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
                        <h2 class="text-anm">Certified Cybersecurity & Data Security Professional (CCDSP)</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="mb-30">
                                    <h4 class="mb-20 text-primary">Certification Requirements</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Complete all 6 course modules</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Pass final examination (minimum 70% score)</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Submit practical cybersecurity assessment</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Participate in incident response simulation</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-30 pt-30 border-top">
                                    <h4 class="mb-20 text-primary">CCDSP Designation Benefits</h4>
                                    <ul class="check-list style-one text-left">
                                        <li><i class="far fa-check"></i> Use "CCDSP" post-nominal designation</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Digital certificate and badge for professional profiles</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Access to cybersecurity professionals network</li>
                                        <li class="mt-10"><i class="far fa-check"></i> Continuing education opportunities</li>
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
                    <h2 class="title  mb-30">Secure Your Financial Institution's Digital Future</h2>
                    <p class=" mb-40">Join cybersecurity professionals from leading financial institutions in this comprehensive certification program designed to combat evolving digital threats.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Download Syllabus</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
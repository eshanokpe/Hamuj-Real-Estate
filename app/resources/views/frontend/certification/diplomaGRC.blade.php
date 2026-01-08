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
                    <h2 style="color: black;">Advanced Diploma in GRC & Financial Crime Prevention</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Certification & Training</a></li>
                        <li class="text-black">Advanced Diploma in GRC & Financial Crime Prevention</li>
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
                            This advanced diploma provides a comprehensive, multi-disciplinary program 
                            covering governance, risk management, compliance, and financial crime prevention. 
                            Designed for senior professionals, it prepares participants for leadership roles 
                            in complex regulatory environments.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            The program combines theoretical frameworks with practical applications, 
                            culminating in a capstone project where participants design enterprise-wide 
                            GRC programs for real-world implementation.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Details:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Duration:</strong> 6 months (part-time) or 12-week accelerated pathway</li>
                        <li class="pt-10"><strong>Format:</strong> Online with live virtual sessions and self-paced learning</li>
                        <li class="pt-10"><strong>Assessment:</strong> Exams, projects, and case study presentations</li>
                        <li class="pt-10"><strong>Certification:</strong> Diploma + eligibility for Fellowship Membership (F.IGRCFP)</li>
                        <li class="pt-10"><strong>CPD Credits:</strong> 120 hours accredited</li>
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
                                Design and implement comprehensive GRC frameworks aligned with international standards
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Lead enterprise risk management initiatives and internal control systems
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Develop and manage advanced AML/CTF compliance programs
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Conduct forensic accounting investigations and financial crime analysis
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Integrate ESG principles and sustainability into organizational governance
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                Navigate global regulatory developments and enforcement actions
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
                        'title' => 'Module 1: Corporate Governance & Ethics in Financial Institutions',
                        'items' => [
                            'Board governance structures and responsibilities',
                            'Ethical leadership and decision-making frameworks',
                            'Stakeholder management and corporate accountability',
                            'Governance in digital and fintech environments'
                        ]
                    ],
                    [
                        'title' => 'Module 2: Enterprise Risk Management Frameworks',
                        'items' => [
                            'COSO ERM and ISO 31000 implementation',
                            'Risk culture assessment and development',
                            'Operational, strategic, and emerging risk identification',
                            'Risk appetite statement development and monitoring'
                        ]
                    ],
                    [
                        'title' => 'Module 3: Advanced AML/CTF & Sanctions Compliance',
                        'items' => [
                            'FATF recommendations and global standards',
                            'Transaction monitoring systems and alert management',
                            'Sanctions evasion techniques and detection',
                            'Correspondent banking and high-risk relationships'
                        ]
                    ],
                    [
                        'title' => 'Module 4: Forensic Accounting & Investigations',
                        'items' => [
                            'Financial statement fraud detection',
                            'Digital forensics and evidence collection',
                            'Asset tracing and recovery methodologies',
                            'Expert witness preparation and testimony'
                        ]
                    ],
                    [
                        'title' => 'Module 5: Global Regulatory Developments & Enforcement',
                        'items' => [
                            'Comparative regulatory frameworks analysis',
                            'Enforcement trends and penalty structures',
                            'Cross-border compliance challenges',
                            'Regulatory technology (RegTech) adoption'
                        ]
                    ],
                    [
                        'title' => 'Module 6: ESG, Sustainability, and Ethical Finance',
                        'items' => [
                            'ESG reporting standards and frameworks',
                            'Climate risk integration into risk management',
                            'Sustainable finance products and green banking',
                            'Social governance and community impact assessment'
                        ]
                    ],
                    [
                        'title' => 'Module 7: Capstone Project',
                        'items' => [
                            'Designing an enterprise-wide GRC program',
                            'Implementation roadmap and change management',
                            'Performance metrics and monitoring systems',
                            'Executive presentation to faculty panel'
                        ]
                    ]
                ];
            @endphp

            @foreach($modules as $index => $module)
                <div class="col-xl-6 col-md-6 col-sm-12 mb-30">
                    <div class="bizzen-blog-post-item style-two mb-35" 
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
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Evaluation</span>
                        <h2 class="text-anm">Assessment & Certification</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); height: 100%;">
                                <h5 class="mb-20">Assessment Components</h5>
                                <ul class="check-list style-one text-left">
                                    <li><i class="far fa-check"></i> Module Examinations (40%)</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Practical Assignments (30%)</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Case Study Presentations (20%)</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Capstone Project (10%)</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); height: 100%;">
                                <h5 class="mb-20">Certification Benefits</h5>
                                <ul class="check-list style-one text-left">
                                    <li><i class="far fa-check"></i> Advanced Diploma Certificate</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Fellowship Membership Eligibility (F.IGRCFP)</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Professional Designation Rights</li>
                                    <li class="mt-10"><i class="far fa-check"></i> Global Professional Network Access</li>
                                </ul>
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
                <div class="bizzen-cta-content text-center text-black">
                    <h2 class="title  mb-30 ">Ready to Advance Your GRC Career?</h2>
                    <p class=" mb-40">Join senior professionals worldwide in this comprehensive diploma program designed for leadership in governance, risk, and compliance.</p>
                    <div class="bizzen-button">
                        <a href="{{ route('contact') }}" class="main-btn btn-filled">Request Program Brochure</a>
                        <a href="{{ route('register') }}" class="main-btn btn-border">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
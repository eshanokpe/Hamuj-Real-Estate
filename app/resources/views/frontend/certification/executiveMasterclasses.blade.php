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
                    <h2 style="color: black;">Executive Masterclasses & Short Courses</h2>
                    <ul>
                        <li><a class="text-black" href="{{ route('index') }}">Home</a></li>
                        <li><a class="text-black" href="{{ route('certifications.index') }}">Training Programs</a></li>
                        <li class="text-black">Executive Masterclasses & Short Courses</li>
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
                            Our Executive Masterclasses & Short Courses provide intensive, focused learning 
                            experiences for senior professionals, executives, and board members seeking 
                            targeted skill development without long-term program commitments.
                        </p>
                        <p data-aos="fade-up" data-aos-duration="1800">
                            These optional electives allow professionals to deepen expertise in specific 
                            areas of GRC, financial crime prevention, and regulatory compliance through 
                            practical, hands-on sessions led by industry experts.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <div style="background-color: #F4F8FE; padding:20px; border-radius:8px" class="bizzen-image-box mb-5 mb-xl-0">
                    <h6 class="mb-15">Program Features:</h6>
                    <ul class="check-list style-three mb-40">
                        <li><strong>Format:</strong> Intensive 1-3 day workshops</li>
                        <li class="pt-10"><strong>Delivery:</strong> In-person, virtual, or hybrid options</li>
                        <li class="pt-10"><strong>Level:</strong> Executive and senior management focus</li>
                        <li class="pt-10"><strong>CPD Credits:</strong> 8-24 hours per masterclass</li>
                        <li class="pt-10"><strong>Flexibility:</strong> Mix-and-match elective options</li>
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
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Benefits</span>
                        <h2 class="text-anm">Why Choose Executive Masterclasses?</h2>
                    </div>
                    <div class="bizzen-content-box" data-aos="fade-up" data-aos-duration="1600">
                        <h6>Executive masterclasses provide focused benefits for busy professionals:</h6>
                        <ul class="check-list style-one mb-40 mt-20">
                            <li><i class="far fa-check"></i>
                                <strong>Time-efficient:</strong> Intensive learning without long-term commitment
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                <strong>Expert-led:</strong> Direct learning from industry leaders and practitioners
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                <strong>Practical focus:</strong> Actionable insights for immediate application
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                <strong>Peer networking:</strong> Connect with senior professionals and executives
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                <strong>Customizable:</strong> Select specific topics relevant to your role
                            </li>
                            <li><i class="far fa-check mt-10"></i>
                                <strong>Flexible delivery:</strong> Choose formats that fit your schedule
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
                    <h2 class="text-anm">Who Should Attend?</h2>
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
                                <a href="#" style="font-weight: 400; color: #F0F0F0;">C-Suite Executives</a>
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
                                    Board Members & Directors
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
                                    Senior Management Teams
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
                                    Department Heads & Leaders
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

<!--======  Start Masterclasses Section  ======-->
<section class="bizzen-blog-grid-sec pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Electives</span>
                    <h2 class="text-anm">Available Masterclasses</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $masterclasses = [
                    [
                        'title' => 'AI in Compliance & Risk Management',
                        'description' => 'Explore artificial intelligence applications in regulatory compliance, risk assessment, and automated monitoring systems.',
                        'duration' => '2 days',
                        'format' => 'In-person workshop',
                        'focus' => 'Practical AI implementation',
                        'level' => 'Intermediate to Advanced'
                    ],
                    [
                        'title' => 'ESG & Sustainable Finance Compliance',
                        'description' => 'Master environmental, social, and governance compliance requirements for financial institutions and corporate sustainability reporting.',
                        'duration' => '1.5 days',
                        'format' => 'Virtual or in-person',
                        'focus' => 'Regulatory frameworks & reporting',
                        'level' => 'All levels'
                    ],
                    [
                        'title' => 'Forensic Investigations & Fraud Analytics',
                        'description' => 'Advanced techniques for financial crime investigations, digital forensics, and fraud detection using data analytics.',
                        'duration' => '2 days',
                        'format' => 'In-person intensive',
                        'focus' => 'Practical investigation skills',
                        'level' => 'Advanced'
                    ],
                    [
                        'title' => 'Leadership in Governance & Ethical Decision-Making',
                        'description' => 'Develop executive leadership skills for effective governance, ethical decision-making, and organizational integrity.',
                        'duration' => '1 day',
                        'format' => 'Executive retreat format',
                        'focus' => 'Strategic leadership',
                        'level' => 'Executive'
                    ],
                    [
                        'title' => 'Global Sanctions & Trade Compliance',
                        'description' => 'Comprehensive overview of international sanctions regimes, export controls, and trade compliance requirements.',
                        'duration' => '2 days',
                        'format' => 'Virtual masterclass',
                        'focus' => 'Global regulatory landscape',
                        'level' => 'Intermediate to Advanced'
                    ],
                    [
                        'title' => 'Custom Corporate Masterclasses',
                        'description' => 'Tailored programs designed specifically for your organization\'s needs, delivered at your location or virtually.',
                        'duration' => 'Custom',
                        'format' => 'Custom delivery',
                        'focus' => 'Organization-specific topics',
                        'level' => 'All levels'
                    ]
                ];
            @endphp

            @foreach($masterclasses as $index => $masterclass)
                <div class="col-xl-6 col-md-6 col-sm-12 mb-30">
                    <div class="bizzen-blog-post-item style-two" 
                         data-aos="fade-up" 
                         data-aos-duration="{{ 1000 + ($index * 200) }}"
                         style="background-color: #E8EDF7; border-radius:8px; height: 100%;">
                        <div class="post-content">
                            <h4 class="title"><a href="#">{{ $masterclass['title'] }}</a></h4>
                            <p class="mt-3 mb-3">{{ $masterclass['description'] }}</p>
                            <div class="masterclass-details mt-20">
                                <div class="row">
                                    <div class="col-6">
                                        <small><strong>Duration:</strong><br>{{ $masterclass['duration'] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <small><strong>Format:</strong><br>{{ $masterclass['format'] }}</small>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small><strong>Focus:</strong><br>{{ $masterclass['focus'] }}</small>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <small><strong>Level:</strong><br>{{ $masterclass['level'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--======  End Masterclasses Section  ======-->

<!--======  Start Registration Section  ======-->
<section class="bizzen-we_two pt-80 pb-80 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="bizzen-content-box text-center">
                    <div class="section-title mb-40">
                        <span class="sub-title" data-aos="fade-down" data-aos-duration="1000">Registration</span>
                        <h2 class="text-anm">Flexible Enrollment Options</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div style="background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="text-center p-4 border rounded h-100">
                                            <h5 class="mb-3 text-primary">Individual Enrollment</h5>
                                            <ul class="check-list style-one text-left">
                                                <li><i class="far fa-check"></i> Single masterclass registration</li>
                                                <li class="mt-10"><i class="far fa-check"></i> Flexible scheduling</li>
                                                <li class="mt-10"><i class="far fa-check"></i> CPD certificate upon completion</li>
                                                <li class="mt-10"><i class="far fa-check"></i> Access to session materials</li>
                                            </ul>
                                            <div class="mt-4">
                                                <a href="{{ route('register') }}" class="main-btn btn-filled btn-sm">Register Individual</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="text-center p-4 border rounded h-100">
                                            <h5 class="mb-3 text-primary">Corporate Packages</h5>
                                            <ul class="check-list style-one text-left">
                                                <li><i class="far fa-check"></i> Multiple participant discounts</li>
                                                <li class="mt-10"><i class="far fa-check"></i> Customized in-house delivery</li>
                                                <li class="mt-10"><i class="far fa-check"></i> Tailored content development</li>
                                                <li class="mt-10"><i class="far fa-check"></i> Volume pricing available</li>
                                            </ul>
                                            <div class="mt-4">
                                                <a href="{{ route('contact') }}" class="main-btn btn-border btn-sm">Request Corporate Package</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Registration Section  ======-->

<!--======  Start CTA Section  ======-->
<section class="bizzen-cta_one pt-100 pb-100 bg_cover" style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="bizzen-cta-content text-center">
                    <h2 class="title  mb-30">Elevate Your Executive Leadership Skills</h2>
                    <p class=" mb-40">Join senior professionals and executives in our intensive masterclasses designed for busy leaders seeking targeted, practical knowledge without long-term commitments.</p>
                 
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End CTA Section  ======-->

@endsection
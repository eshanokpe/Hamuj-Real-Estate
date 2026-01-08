@extends('layouts.app')

@section('content')

 <!--======  Start Page Hero Section  ======-->
<section class="page-hero   mt-100" style="background-image: url({{ asset('assets/images/home-three/blog/blog-bg.png')}}); background-size: cover;background-repeat: no-repeat; ">
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content text-center">
                    <p class="text-white">News & Insights</p>
                    <h1>AI and Compliance: Balancing Innovation with Risk</h1>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->
                   
<!--======  Start Service Details Section  ======-->
<section class="service-details-sec pt-120 pb-95">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <!--=== Service Details Wrapper ===-->
                <div class="service-details-wrapper">
                    <!--=== Service Main ===-->
                    <div class="service-item-main mb-60">
                        
                        <div class="service-content" data-aos="fade-up" data-aos-duration="800">
                            <h4 class="title">Introduction</h4>
                            <p>Artificial Intelligence (AI) is transforming how financial institutions detect risks, prevent financial crimes, and ensure regulatory compliance. From automated transaction monitoring to predictive risk scoring, AI is helping organizations become faster, smarter, and more efficient.</p>
                            <p>Yet, this innovation brings new governance challenges — requiring compliance teams to balance progress with accountability, transparency, and ethical responsibility.</p>
                            <div class="service-thumbnail mb-30" data-aos="fade-up" data-aos-duration="800">
                                <img style="background-size: cover;" src="{{ asset('assets/images/home-three/blog/blog-bg2.png')}}" alt="service image">
                            </div>
                            <div class="row"> 
                                <div class="col-lg-12">
                                    <h6 class="mb-15">AI is not the enemy of compliance — it’s a catalyst for smarter, faster, and more proactive governance. But innovation must go hand-in-hand with accountability to build trust and resilience in the digital compliance era.</h6>
                                    <p>AI is increasingly used for:</p>
                                        <ul class="check-list style-two mb-40">
                                            <li>Anti-Money Laundering (AML): identifying suspicious patterns in large data sets.</li>
                                            <li>Fraud Detection: analyzing behavior anomalies to flag potential insider or cyber fraud.</li>
                                            <li>Regulatory Reporting: automating compliance checks and report submissions</li>
                                            <li>Risk Analytics: predicting where future risks may occur using historical data.</li>
                                        </ul>
                                    <p>These tools improve accuracy, reduce false positives, and free compliance officers from repetitive tasks.</p>

                                </div>
                                <div class="col-lg-12">
                                   <p>Despite its benefits, AI introduces new compliance concerns, such as:</p>
                                    <ul class="check-list style-two mb-40">
                                        <li>Data Privacy and Ethics: improper data use or biased algorithms can lead to regulatory breaches.</li>
                                        <li>Model Transparency: many AI systems operate as “black boxes,” making it hard to explain how decisions are made.</li>
                                        <li>Accountability: unclear ownership when AI-driven errors cause regulatory or reputational harm.</li>
                                        <li>Cybersecurity Threats: increased exposure due to integration of digital systems and APIs.</li>
                                    </ul>
                                    <h6 class="mb-1">Conclusion</h6>
                                    <p>To balance innovation with compliance integrity, organizations should:</p>
                                    <ol class="style-two mb-40">
                                        <li>Adopt a Governance Framework: establish internal AI ethics and compliance policies.</li>
                                        <li>Ensure Human Oversight: AI should assist, not replace, human decision-making.</li>
                                        <li>Audit AI Models Regularly: assess fairness, data quality, and bias.</li>
                                        <li>Train Compliance Teams: build technical literacy for understanding AI tools.</li>
                                    </ol>
                                    <style>
                                        ol.style-two {
                                            list-style-type: decimal; /* options: decimal, lower-alpha, upper-alpha, etc. */
                                            margin-left: 20px; /* adds some spacing on the left */
                                            padding-left: 10px;
                                        }

                                    </style>

                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="row justify-content-center text-center">
                    <div class="col-auto">
                        <h6>Share this post</h6>
                        <div class="blog-details-wrapper">
                            <div class="blog-post-main mb-70">
                                <div class="entry-footer mt-30">
                                    <div class="social-share d-flex justify-content-center gap-3">
                                        <a href="#"><i class="fab fa-instagram"></i></a>
                                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="#"><i class="fab fa-twitter"></i></a>
                                        <a href="#"><i class="fab fa-facebook-f"></i></a>
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
<!--======  End Service Details Section  ======-->

 <!--======  Start Testimonial Section  ======-->
<section class="bizzen-testimonial_three pt-50 pb-120">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <!--=== Section Title ===-->
                <div class="section-title mb-60">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="800">Blogs</span>
                    <h2 class="text-anm">Related Posts</h2>
                    <p>Tool and strategies modern teams need to help their companies grow.</p>
                </div>
            </div>
            <div class="col-lg-3"></div>
            <div class="col-lg-3">
                <!--=== Testimonial Arrows ===-->
                <div class="bizzen-button">
                    <a href="{{  route('login') }}" class="theme-btn style-one">View More News & Insights </a>
                </div>
            </div>
        </div>
        <!--=== Testimonial Slider ===-->
        {{-- <div class="" data-aos="fade-up" data-aos-duration="1000"> --}}
        <!-- Bizzen Testimonial Item -->
        <div id="blogSlider" class="carousel slide" data-bs-ride="carousel" data-aos="fade-up" data-aos-duration="1000">
            <div class="carousel-inner">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <!--=== Bizzen Blog Post ===-->
                        <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                            <div class="post-thumbnail">
                                <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span><a href="#">June 11, 2025</a></span>
                                </div>
                                <h4 class="title">
                                    <a href="#">AI and Compliance: Balancing Innovation with Risk
                                    </a>
                                </h4>
                                <p>AI is reshaping compliance. Learn how to use it responsibly without increasing risk. </p>
                            </div>
                        </div>
                    </div>
                     <div class="col-xl-4 col-md-6 col-sm-12">
                        <!--=== Bizzen Blog Post ===-->
                        <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                            <div class="post-thumbnail">
                                <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span><a href="#">August 20, 2025</a></span>
                                </div>
                                <h4 class="title"><a href="#">
                                    Cybersecurity Trends: Staying Ahead of Threats
                                    </a></h4>
                                <p>Examine the latest cybersecurity threats and strategies to protect your organization. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-sm-12">
                        <!--=== Bizzen Blog Post ===-->
                        <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                            <div class="post-thumbnail">
                                <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                            </div>
                            <div class="post-content">
                                <div class="post-meta">
                                    <span><a href="#">July 15, 2025</a></span>
                                </div>
                                <h4 class="title"><a href="#">Sustainable Tech: Innovating for a Greener Future</a></h4>
                                <p>Explore how technology can drive sustainability and reduce our carbon footprint. </p>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Testimonial Section  ======-->

@endsection
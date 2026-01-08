@extends('layouts.app')

@section('content')

<!--======  Start Page Hero Section  ======-->
<section 
    class="page-hero bg_cover p-r z-1" 
    style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content text-center">
                    <h2 style="color: black;">Blog</h2>
                    <p>
                        Stay updated with the latest regulatory developments, industry trends, and thought leadership in governance, risk, compliance, and financial crime prevention. Our insights help professionals anticipate change, manage risk, and lead with confidence.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->


 <section class="bizzen-blog-grid-sec pt-80 pb-120">
    <div class="container">
         <div class="row justify-content-center">
           
            <!--=== Section Title ===-->
            <div class="section-title text-center mb-20">
                <span class="sub-title" data-aos="fade-up" data-aos-duration="1000">Blogs</span>
                <h2 class="text-anm">Featured Insights</h2>
               
            </div>
           
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1000">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                     </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>June 11, 2025</span>
                        </div>
                        <h4 class="title"><a href="{{ route('blog-details') }}">AI and Compliance: Balancing Innovation with Risk</a></h4>
                        <p>AI is reshaping compliance. Learn how to use it responsibly without increasing risk. </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1200">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>August 20, 2025</span>
                        </div>
                        <h4 class="title"><a href="{{ route('blog-details') }}">Cybersecurity Trends: Staying Ahead of Threats</a></h4>
                        <p>Examine the latest cybersecurity threats and strategies to protect your organization.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1400">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>July 15, 2025</span>
                        </div>
                        <h4 class="title"><a href="#">Sustainable Tech: Innovating for a Greener Future</a></h4>
                        <p>
                            Explore how technology can drive sustainability and reduce our carbon footprint.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1600">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>July 11, 2025</span>
                        </div>
                         <h4 class="title"><a href="#">Nigeria’s CBN Updates AML/CTF Guidelines — What Firms Need to Know</a></h4>
                        <p>AI is reshaping compliance. Learn how to use it responsibly without increasing risk.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="1800">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>August 20, 2025</span>
                        </div>
                         <h4 class="title"><a href="#">Case Study: How Telecoms Manage Cross-Border AML Risks</a></h4>
                        <p>Examine the latest cybersecurity threats and strategies to protect your organization.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <!--=== Bizzen Blog Post ===-->
                <div class="bizzen-blog-post-item style-two mb-35" data-aos="fade-up" data-aos-duration="2000">
                    <div class="post-thumbnail">
                        <img src="{{ asset('assets/images/home-three/blog/blog.png')}}" alt="Blog Grid">
                    </div>
                    <div class="post-content">
                        <div class="post-meta">
                            <span>July 15, 2025</span>
                        </div>
                         <h4 class="title"><a href="#">EU’s AMLA Supervision — Implications for African Banks</a></h4>
                        <p>Explore how technology can drive sustainability and reduce our carbon footprint. </p>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-12">
                <div class="theme-pagination text-center mt-10" data-aos="fade-up" data-aos-duration="2200">
                    <ul>
                        <li><a href="#"><i class="far fa-arrow-left"></i></a></li>
                        <li><a href="#">01</a></li>
                        <li><a href="#">02</a></li>
                        <li><a href="#">03</a></li>
                        <li><a href="#"><i class="far fa-arrow-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</section>


@endsection
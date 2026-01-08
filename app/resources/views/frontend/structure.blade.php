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
                    <h1 style="color: black;">Our Structure</h1>
                        <ul >
                            <li class="text-black"><a href="{{ route('index') }}">Home</a></li>
                            <li class="text-black"> Our Structure</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======  End Page Hero Section  ======-->

<!--======  Start Blog Grid Section  ======-->
<section class="bizzen-blog-standard-sec pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="blog-details-wrapper" style="border: 0 !important; border-width: 0 !important; border-style: none !important; border-color: transparent !important; box-shadow: none !important; background: transparent !important; padding: 0 !important; margin: 0 !important;">
                    <!--=== Blog Post Main ===-->
                    <div class="blog-post-main mb-70" data-aos="fade-up" data-aos-duration="1000">
                        <div class="blog-post-item">
                            
                            <div class="post-content" data-aos="fade-up" data-aos-duration="800">
                               
                                <h4 class="title">Our Board of Trustees</h4>
                                <p>
                                    The Board of Trustees serves as the strategic oversight body of IGRCFP and is responsible for guiding the long-term direction of the Institute. The board ensures that the IGRCFP remains aligned with its mission and vision while upholding ethical standards. 
                                </p>
                                <p class="mb-15">Key Responsibilities:</p>
                                <ul class="check-list style-two mb-40" >
                                    <li>Establishing the strategic vision and mission of IGFCP.</li>
                                    <li>Overseeing governance policies and ensuring the Institute's sustainability.</li>
                                    <li>Approving the annual budget and financial reports.</li>
                                    <li>Appointing the members of the Council and ensuring proper leadership succession.</li>
                                    <li>Ensuring compliance with the laws and international standards.</li>
                                </ul>
                               
                                {{-- <div class="row">
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-1.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">Chairperson</p>
                                            <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">Deputy Chairperson</p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center ">Legal professionals</p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <h4 class="title">The Governing Council</h4>
                                <p>
                                    The Governing Council is responsible for the formulation and implementation of the Institute's policies, providing direction for the activities of the Executive Management, and overseeing the Institute's core functions, including membership, education, certification, and research.  
                                </p>
                                <p class="mb-15">Key Responsibilities:</p>
                                <ul class="check-list style-two mb-40" >
                                    <li>Developing and reviewing policies to ensure alignment with the Institute’s objectives.</li>
                                    <li>Approving the Institute’s code of conduct, certification requirements, and membership policies.</li>
                                    <li>Advising on matters related to education, certification, and professional development.</li>
                                    <li>Overseeing disciplinary matters and upholding ethical standards</li>
                                    <li>Providing guidance on partnerships and collaboration with regulatory bodies and global organizations.</li>
                                </ul>

                                {{-- <div class="row">
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-1.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">President</p>
                                            <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">Vice President</p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center ">Secretary General</p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <h4 class="title">Advisory Committes</h4>
                                <p>
                                    Specialised working groups focused on Education, Research, Policy, and Ethics, fostering collaboration among professionals to shape standards, influence regulatory frameworks, and promote ethical excellence within the industry.  
                                </p>

                                 {{-- <div class="row">
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-1.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">Professor in Financial Crime</p>
                                            <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center">Professor in Financial Crime </p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bizzen-image">
                                            <img src="{{ asset('assets/images/innerpage/trustees/trustees-2.jpg')}}" class="img-fluid mx-auto d-block w-75 rounded-circle" alt="Single blog">
                                            <h6 class="text-center mt-10">Wade Warren</h6>
                                            <p class="text-center ">Professor in Financial Crime</p>
                                             <div style="margin-top: -20px" class="entry-footer pt-0 text-center" data-aos="fade-up" data-aos-duration="1000">
                                                <div class="social-share ">
                                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                      
                    </div>
                    <!--=== Post Navigation ===-->
                   
                </div>
            </div>
            <div class="col-xl-4">
                <!--=== Sidebar widget Area ===-->
                <div class="sidebar-widget-area mb-20">
                    {{-- <h4 class="widget-title">People</h4> --}}
                    {{-- <div class="bizzen-blog-post-item style-one mb-30" data-aos="fade-up" data-aos-duration="1000">
                                           
                        <div class="post-content">
                            <h4 class="title">
                                People
                            </h4>
                            <p>Words matter, and our copy writing rh services ensure your message heard zx loud Whether and clear.</p>
                            <p>
                            <a href="#" class="read-more style-one">Board of Trustees</a>
                            </p>
                            <p>
                            <a href="#" class="read-more style-one">The Governing Council  </a>
                            </p>
                            <p>
                            <a href="#" class="read-more style-one">Advisory Committes</a>
                            </p>
                        </div>
                    </div> --}}
                        
                    <!--===  Sidebar Widget  ===-->
                    <div class="sidebar-widget sidebar-nav-widget mb-30" data-aos="fade-up" data-aos-duration="800">
                            <!--=== Bizzen Blog Item ===-->
                                        
                        <div class="widget-content">
                            <ul>
                                <li><a href="#">Board of Trustees<span><i class="far fa-angle-right"></i></span></a></li>
                                <li><a href="#">The Governing Council<span><i class="far fa-angle-right"></i></span></a></li>
                                <li><a href="#">Advisory Committes<span><i class="far fa-angle-right"></i></span></a></li>
                             </ul>
                        </div>
                    </div>
                    <!--=== Sidebar Widget ===-->
                    <div class="sidebar-widget sidebar-post-widget mb-40" data-aos="fade-up" data-aos-duration="1000">
                        <h4 class="widget-title">Need Help?</h4>
                        <div class="widget-content">
                            <ul class="recent-post-list">
                                <li class="post-thumbnail-content mb-4">
                                    <div class="content">
                                        <h5>Contact Us Here</h5>
                                        <p>enquiries@igrfcp.org</p>
                                    </div>
                                </li>
                               
                            </ul>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
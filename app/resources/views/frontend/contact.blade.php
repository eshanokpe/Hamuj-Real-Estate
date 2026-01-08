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
                    <h1 style="color: black;">Contact us for inquiries</h1>
                        <ul >
                            <li ><a class="text-black" href="{{ route('index') }}">Home</a></li>
                            <li class="text-black">Contact Us</li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!--======  End Page Hero Section  ======-->
<!--======  Start Contact Info Section  ======-->
<section class="bizzen-contact-info-sec pt-105">
    <div class="container">
     
        <div class="row justify-content-center">
            <div class="col-xl-7 col-md-6 col-sm-12">
                <!--=== Bizzen Info Box ===-->
                <div class="bizzen-info-left-box mb-40">
                    <div class="icon">
                        <i class="far fa-map-marker-alt"></i>
                    </div>
                    <div class="content">
                        <h5>Our Address</h5>
                        <p> 85 Great Portland Street First Floor London W1W 7LT, United Kingdom</p>
                        {{-- <p><b>AFRICA: </b> Adeola Adeoye Street, Off Toyin Street, Ikeja, Lagos, Nigeria </p> --}}
                        {{-- <p><b>Asia: </b> 21 Gillabbey Terrace, Gillabbey Street, Cork, T12 KPN4, Republic of Ireland </p> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-sm-12">
                <!--=== Bizzen Info Box ===-->
                <div class="bizzen-info-left-box mb-40">
                    <div class="icon">
                        <i class="far fa-phone-alt"></i>
                    </div>  
                    <div class="content">
                        <h5>Contact Email</h5>
                        {{-- <p><b>Nigeria:</b> <a href="tel:+2349153414314">09153414314</a></p> --}}
                        {{-- <p><b>United Kingdom Tel:</b> <a href="tel:+447466588324">+44 7466588324</a></p> --}}
                        {{-- <p><b>Republic of Ireland:</b> <a href="tel:++353877123968"> +353 877123968</a></p> --}}
                        <p><b>Email: </b><a href="mailto:">enquiries@igrfcp.org</a></p>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</section><!--======  End Contact Info Section  ======-->
<!--======  Start Contact Section  ======-->
<section class="bizzen-contact_two pt-80 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-10">
                <!--=== Map Box ===-->
                <div class="map-box mb-5 mb-xl-0" data-aos="fade-up" data-aos-duration="1300">
                    <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4965.533203224408!2d-0.14576904919392697!3d51.51749783566678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761ad59690e6f1%3A0xe4b8b9128f499bed!2sThe%20London%20Office!5e0!3m2!1sen!2sng!4v1763737002761!5m2!1sen!2sng" 
                    loading="lazy">
                    </iframe>
                    {{-- <iframe src="" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                </div>
            </div>
            <div class="col-xl-6 col-lg-10">
                <!--=== Contact Wrapper ===-->
                <div class="contact-wrapper" data-aos="fade-left" data-aos-duration="1400">
                    <h2>Get In Touch</h2>
                    <form id="contact-form" class="contact-form" action="#" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form_control" placeholder="Your Name" name="name" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="email" class="form_control" placeholder="Email Address" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="text" class="form_control" placeholder="Phone Number" name="phone" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea class="form_control" placeholder="Message" name="message" rows="5" cols="8"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button class="theme-btn style-one">Send Message Us <i class="far fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--======  End Contact Section  ======-->
 

@endsection
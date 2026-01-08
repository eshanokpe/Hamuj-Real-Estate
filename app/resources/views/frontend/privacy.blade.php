@extends('layouts.app')

@section('content')

<!--======  Smooth Wrapper  ======-->
<div id="smooth-wrapper">
    <div id="smooth-content">
        <!--======  Main  ======-->
        <main>
            <!--======  Start Page Hero Section  ======-->
            <section class="page-hero bg_cover p-r z-1"  style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="page-content text-center">
                                <h2 class="text-black">Privacy Policy</h2>
                                <ul>
                                    <li><a class="text-black" href="{{  route('index') }}">Home</a></li>
                                    <li class="text-black">Privacy Policy</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--======  End Page Hero Section  ======-->
            
            <!--======  Start Privacy Policy Section  ======-->
            <section class="bizzen-grow-sec pt-100 pb-70">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <!--=== Privacy Policy Content Box ===-->
                            <div class="bizzen-content-box">
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    This Privacy Policy explains how the Institute of Governance, Risk & Financial Crime Prevention (IGRCFP) (“we”, “our”, “the Institute”) collects, uses, discloses, and protects your personal information when you visit our website (the “Site”) or interact with our services.
                                </p>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    By accessing this Site, you confirm that you accept the practices described in this Privacy Policy. If you do not agree, please discontinue use of the Site.
                                </p>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    This policy is reviewed periodically, and updates will be published on this page.
                                </p>
                                
                                <!-- Section 1 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">1. Information We Collect and How We Use It</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    We collect personal information to deliver requested services, manage membership, process registrations, and improve user experience.
                                </p>
                                <p>We may collect the following:</p>
                                
                                <div class="privacy-subsection mb-4">
                                    <p class="fw-bold">a. Information You Provide Directly</p>
                                    <p>When you:</p>
                                    <ul class="mb-3">
                                        <li>Register as a member, learner, or tutor</li>
                                        <li>Enroll in a course or program</li>
                                        <li>Request information</li>
                                        <li>Subscribe to newsletters</li>
                                        <li>Attend an IGRCFP event</li>
                                        <li>Contact us through forms, email, or phone</li>
                                        <li>Submit a speaker, partnership, or editorial request</li>
                                    </ul>
                                    <p>You may provide:</p>
                                    <ul>
                                        <li>Full name</li>
                                        <li>Email address</li>
                                        <li>Phone number</li>
                                        <li>Country / location</li>
                                        <li>Date of birth (optional)</li>
                                        <li>Employment information</li>
                                        <li>Professional qualifications</li>
                                        <li>Uploaded CV or certifications (for tutors or job applicants)</li>
                                        <li>Username and password (if you create an account)</li>
                                    </ul>
                                </div>
                                
                                <div class="privacy-subsection mb-4">
                                    <p class="fw-bold">b. Automatically Collected Data</p>
                                    <p>When you browse the Site, we may collect:</p>
                                    <ul class="mb-3">
                                        <li>IP address</li>
                                        <li>Browser type</li>
                                        <li>Device information</li>
                                        <li>Pages visited</li>
                                        <li>Time spent on the Site</li>
                                        <li>Cookie information</li>
                                    </ul>
                                    <p>This data helps us understand user behavior and improve our website.</p>
                                </div>
                                
                                <div class="privacy-subsection mb-4">
                                    <p class="fw-bold">c. Surveys & Feedback</p>
                                    <p>From time to time, we may invite you to complete surveys to help us improve our services. Participation is voluntary.</p>
                                </div>
                                
                                <!-- Section 2 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">2. Sensitive Personal Data</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    Some services (e.g., tutor applications or job opportunities) may require additional information such as:
                                </p>
                                <ul class="mb-3">
                                    <li>Professional credentials</li>
                                    <li>Criminal screening declarations (if legally required)</li>
                                    <li>Bio data relevant to regulatory training programs</li>
                                </ul>
                                <p>We only request sensitive data when necessary and process it only with your explicit consent.</p>
                                
                                <!-- Section 3 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">3. Cookies</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    Our Site uses cookies to:
                                </p>
                                <ul class="mb-3">
                                    <li>Improve website functionality</li>
                                    <li>Understand user interactions</li>
                                    <li>Personalize your experience</li>
                                </ul>
                                <p>We use tools such as:</p>
                                <ul class="mb-3">
                                    <li>Google Analytics</li>
                                    <li>Session cookies for login and navigation support</li>
                                </ul>
                                <p>You may disable cookies in your browser, but some features may not work properly.</p>
                                
                                <!-- Section 4 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">4. How We Use Your Information</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    Your personal information is used to:
                                </p>
                                <ul class="mb-3">
                                    <li>Provide access to training, membership, and certification programs</li>
                                    <li>Manage your account and communications</li>
                                    <li>Process event registrations</li>
                                    <li>Share regulatory updates, research, and newsletters (if you opt in)</li>
                                    <li>Improve our Site and services</li>
                                    <li>Respond to enquiries or support requests</li>
                                    <li>Comply with legal or regulatory obligations</li>
                                </ul>
                                <p>You can opt out of marketing messages at any time by emailing <a href="mailto:info@igrcfp.org">info@igrcfp.org</a>.</p>
                                
                                <!-- Section 5 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">5. Updating Your Information</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    You may request corrections or updates to your personal data at any time by contacting us at <a href="mailto:info@igrcfp.org">info@igrcfp.org</a>.
                                </p>
                                
                                <!-- Section 6 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">6. Sharing Your Information</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    We do not sell or use your information for third-party marketing.
                                </p>
                                <p>We may share your data only when:</p>
                                <ul class="mb-3">
                                    <li>Required to deliver a service you requested (e.g., event partners or instructors)</li>
                                    <li>Required by law, regulation, or court order</li>
                                    <li>Necessary to protect IGRCFP's legal rights or prevent fraud</li>
                                </ul>
                                <p>All partners handling data on our behalf must meet IGRCFP's privacy and security standards.</p>
                                
                                <!-- Section 7 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">7. Links to External Websites</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    Our Site may contain links to third-party websites. IGRCFP is not responsible for their privacy practices. We recommend reviewing their policies before providing any information.
                                </p>
                                
                                <!-- Section 8 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">8. Data Retention</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    We retain your information only as long as necessary to:
                                </p>
                                <ul class="mb-3">
                                    <li>Deliver requested services</li>
                                    <li>Fulfill legal obligations</li>
                                    <li>Support membership or training records</li>
                                </ul>
                                <p>If you opt in for updates or newsletters, your information is retained until you unsubscribe.</p>
                                
                                <!-- Section 9 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">9. Protecting Your Information</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    We use industry-standard security measures to protect your data from:
                                </p>
                                <ul class="mb-3">
                                    <li>Loss</li>
                                    <li>Unauthorized access</li>
                                    <li>Misuse</li>
                                    <li>Alteration</li>
                                </ul>
                                <p>Even with strong protections, no internet transmission is 100% secure.</p>
                                
                                <div class="privacy-subsection mb-4">
                                    <p class="fw-bold">How You Can Stay Safe</p>
                                    <ul>
                                        <li>Use strong, unique passwords</li>
                                        <li>Keep your device security up to date</li>
                                        <li>Avoid using public computers for login</li>
                                        <li>Never share your password with anyone</li>
                                        <li>Verify emails claiming to be from IGRCFP</li>
                                    </ul>
                                    <p class="mt-3"><strong>Important:</strong> IGRCFP will never ask for your password via email.</p>
                                    <p>If you suspect any security issue, email <a href="mailto:info@igrcfp.org">info@igrcfp.org</a> immediately.</p>
                                </div>
                                
                                <!-- Section 10 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">10. Changes to This Privacy Policy</h6>
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    Updates to this Privacy Policy will be posted on this page. We encourage you to review it regularly to stay informed.
                                </p>
                                
                                <!-- Section 11 -->
                                <div class="section-title mb-4 mt-5">
                                    <h6 class="text-anm">11. Contact Us</h6>.  
                                </div>
                                <p data-aos="fade-up" data-aos-duration="1000">
                                    For questions about this Privacy Policy or your personal information rights:
                                </p>       
                                <p>Email: <a href="mailto:info@igrcfp.org" class="text-primary" style="text-decoration: underline">info@igrcfp.org</a></p>
                                <p>Website: <a href="https://www.igrcfp.org" target="_blank" rel="noopener" class="text-primary" style="text-decoration: underline">www.igrcfp.org</a></p>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section><!--======  End Privacy Policy Section  ======-->
          
        </main>
       
    </div>
</div>

@endsection()
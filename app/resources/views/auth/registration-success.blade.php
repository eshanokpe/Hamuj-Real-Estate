@extends('layouts.app')

@section('content') 
<section class="bizzen-contact_two pt-100 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="site-branding">
                            <a href="{{ route('index') }}" class="brand-logo">
                                <img class="w-50" src="{{ asset('assets/images/innerpage/success.png')}}" alt="Brand Logo">
                            </a>
                        </div>
                    </div>

                    <div class="section-title text-center mb-50">
                        <h2 class="text-success mb-3">Registration Confirmed!</h2>
                        <p class="lead mb-4">
                            Thank you for joining The Institute of Risk Compliance and Financial Crime Prevention We’re currently setting up your member dashboard and onboarding experience.
                        </p>
                        
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mt-5">
                            <a href="{{ route('login') }}" class="theme-btn style-one me-3" style="border-radius: 8px">
                                Proceed to Sign In
                            </a>
                        </div>
                        <div class="mt-2">
                             <a href="{{ route('index') }}" class="theme-btn style-two" style="border-radius: 8px">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
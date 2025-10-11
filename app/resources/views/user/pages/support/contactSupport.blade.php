@extends('layouts.dashboard')

<div style=" top: 200px; ">
    @include('chattle::chat')
</div> 

@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <!-- End header area -->
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container d-flex">
            <div class="main__content--left">
                <div class="main__content--left__inner">
                    <!-- Welcome section -->
                    <div class="dashboard__chart--box mb-30">
                        <h2 class="dashboard__chart--title"> Contact Support </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        <h1 class="dashboard__chart--title"> Hello, {{ auth::user()->last_name}} {{ auth::user()->first_name}} </h1>
                                        
                                    
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 align-self-center">
                                                <a href="{{ $contactDetials->first_email }}">
                                                <img src="{{ asset('assets/admin/img/dashboard/email.png')}}" alt="Buy" class="me-2" width="30">
                                                </a>
                                            </div>
                                            <div class="flex-grow-1 ms-3 align-self-center">
                                                <a href="">
                                                    <b>{{$contactDetials->first_address}}</b> 
                                                </a>
                                            </div>
                                            <div class="flex-grow-1 ms-3 align-self-center">
                                                <a href="{{ $contactDetials->first_email }}">
                                                    <b>Email us</b> 
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Report Section -->
                    {{-- <div class="sales__report--section p-4" >
                      
                    </div> --}}
                  

                </div>
            </div>
            <div class="main__content--right">
                <div class="dashboard__chart--box mb-30">
                    <h2 class="dashboard__chart--title">  Main Balance</h2>
                    @include('user.partial.mainBalance')
                   
                </div>

                <div class="dashboard__chart--box mb-30">
                    <h2 class="dashboard__chart--title"> Refer and Earn </h2>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="swiper-slide">
                                <div class="currency__card" style="border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                    <h3 class="currency__card--title">
                                        Refer Your Friend and Earn to Your Wallet
                                    </h3>
                                    <div class="referral-code" >
                                        <span class="currency__weekly  referral_code" >
                                            {{ url('/user/register/referral/' . $user->referral_code) }}
                                        </span>
                                        <button class="copy-btn btn btn-success btn-lg" onclick="copyReferralLink()">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="recent__activity--box">
                    <div class="recent__activity--header d-flex align-items-center justify-content-between mb-25">
                        <h2 class="recent__activity--title">Referral history</h2>
                       
                    </div>
                    <ul class="recent__activity--message">
                       
                        @if ($referralsMade->isNotEmpty())
                            @foreach ($referralsMade as $referral)
                                <li class="recent__activity--message__list one d-flex justify-content-between">
                                    <div class="recent__activity--message__content">
                                        <p class="recent__activity--message__desc">
                                            {{ $referral->referred->last_name ?? 'Unknown' }}
                                            {{ $referral->referred->first_name ?? 'Name' }}
                                        </p>
                                    </div>
                                    <span class="recent__activity--message__time">
                                        {{ $referral->created_at->format('g:i A') ?? 'N/A' }}
                                    </span>
                                </li>
                            @endforeach
                            {{-- Display "View More" link if there are additional referrals --}}
                            @if ($hasMoreReferrals)
                                <a href="{{ route('user.referrals.show') }}" class="view-more-link">View More</a>
                            @endif
                        @else
                            <p>No referrals made yet.</p>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
        <!-- dashboard container .\ -->
    </main>
</div>

@endsection 
<script>
    function copyReferralLink() {
        const referralLink = document.querySelector('.referral_code').innerText;
        navigator.clipboard.writeText(referralLink).then(() => {
            const message = document.createElement('span');
            message.className = 'copy-success';
            message.innerText = 'Referral link copied!';
            
            const referralContainer = document.querySelector('.referral-code');
            referralContainer.appendChild(message);

            // Remove the message after 3 seconds
            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        }).catch(() => {
            const message = document.createElement('span');
            message.className = 'copy-fail';
            message.innerText = 'Failed to copy referral link.';
            
            const referralContainer = document.querySelector('.referral-code');
            referralContainer.appendChild(message);

            // Remove the message after 3 seconds
            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        });
    }
   
   


</script>

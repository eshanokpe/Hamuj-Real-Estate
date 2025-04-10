@extends('layouts.dashboard')



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
                        <h2 class="dashboard__chart--title"> Login and Security </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sales__report--section p-4" >
                                    <div class="accordion accordion-flush">
                                     
                                        <div class="accordion-item mb-3">
                                            <div class="d-flex">
                                               
                                                <div class="p-2  w-100 d-flex align-self-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/change_password.avif')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
            
                                                    <h1 class="dashboard__chart--title align-self-center">Change Password</h1>
                                                </div>
                                            
                                                <a href="{{ route('user.change.password') }}">
                                                    <div class="p-2 flex-shrink-1">
                                                        <img src="{{ asset('assets/admin/img/dashboard/right_arrow.jpg')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
                                                    </div>
                                                </a>
                                               
                                            </div>
                                        </div>
                                       

                                        <div class="accordion-item mb-3">
                                            <div class="d-flex">
                                                <div class="p-2  w-100 d-flex align-self-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/pin.jpg')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
            
                                                    <h1 class="dashboard__chart--title align-self-center">Transaction PIN</h1>
                                                </div>
                                                <a href="{{ route('user.transaction.pin') }}">
                                                    <div class="p-2 flex-shrink-1">
                                                        <img src="{{ asset('assets/admin/img/dashboard/right_arrow.jpg')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        {{-- <div class="accordion-item mb-3">
                                            <div class="d-flex">
                                                <div class="p-2  w-100 d-flex align-self-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/security_question.jpg')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
            
                                                    <h1 class="dashboard__chart--title align-self-center">Reset Security Questions</h1>
                                                </div>
                                                <div class="p-2 flex-shrink-1">
                                                    <img src="{{ asset('assets/admin/img/dashboard/right_arrow.jpg')}}" alt="Buy" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain"  >
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="accordion-item mb-3">
                                            <div class="d-flex">
                                                <div class="p-2 w-100 d-flex align-self-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/hide.png')}}" alt="Buy" class="me-2" 
                                                         style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain">
                                        
                                                    <h1 class="dashboard__chart--title align-self-center">Hide Balance</h1>
                                                </div>
                                                <div class="p-2 flex-shrink-1">
                                                    <div class="form-check form-switch">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            role="switch" 
                                                            id="flexSwitchCheckDefault" 
                                                            {{ Auth::user()->hide_balance ? 'checked' : '' }}
                                                            onchange="toggleHideBalance(this)">
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

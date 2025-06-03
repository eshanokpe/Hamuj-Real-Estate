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
            <h2 class="dashboard__chart--title"> Payment History </h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="add__listing--input__box mb-10">
                        <input 
                            class="add__listing--input__field" 
                            id="searchTransactions" 
                            name="search" 
                            placeholder="Search transactions..." 
                            type="text" 
                            value="">
                    </div>
                   
                    <div class="sales__report--section p-4">
                        <div class="accordion accordion-flush">
                            @forelse ($transactions as $transaction)
                                <div class="accordion-item mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 align-self-center">
                                            @if($transaction->type === 'deposit' || $transaction->type === 'credit')
                                                <img src="{{ asset('assets/admin/img/dashboard/up-arrow.png')}}" alt="Deposit" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain">
                                            @else
                                                <img src="{{ asset('assets/admin/img/dashboard/withdraw.png')}}" alt="Withdraw" class="me-2" style="width:50px; height:50px; max-width:100px; max-height:100px; object-fit:contain">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3 align-self-center">
                                            <h1 class="dashboard__chart--title align-self-center">
                                                {{ ucfirst($transaction->type) }}
                                                @if($transaction->reason)
                                                    <small class="text-muted">({{ $transaction->reason }})</small>
                                                @endif
                                            </h1>
                                            <p>{{ $transaction->created_at->format('l h:i A') }}</p>
                                        </div>
                                           
                                        <a href="#">
                                            <div class="p-2 d-flex flex-shrink-2 align-self-center">
                                                <h1 class="dashboard__chart--title pr-3 @if($transaction->type === 'deposit' || $transaction->type === 'credit') text-success @else text-danger @endif">
                                                    @if($transaction->type === 'deposit' || $transaction->type === 'credit') + @else - @endif
                                                    ₦{{ number_format($transaction->amount, 2) }}
                                                </h1>
                                                <svg class="pl-3 mt-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M7.5 3.33333L12.5 8.33333L7.5 13.3333" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                    <hr/>
                                    <div class="px-3 py-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Status:</strong> 
                                                    <span class="badge @if($transaction->status === 'successful') bg-success @elseif($transaction->status === 'pending') bg-warning @else bg-danger @endif">
                                                        {{ ucfirst($transaction->status) }}
                                                    </span>
                                                </p>
                                                @if($transaction->metadata && isset($transaction->metadata['bank_name']))
                                                    <p class="mb-1"><strong>Bank:</strong> {{ $transaction->metadata['bank_name'] }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Date:</strong> {{ $transaction->created_at->format('M d, Y') }}</p>
                                                @if($transaction->metadata && isset($transaction->metadata['account_name']))
                                                    <p class="mb-1"><strong>Account:</strong> {{ $transaction->metadata['account_name'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p>No transactions found</p>
                                </div>
                            @endforelse
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

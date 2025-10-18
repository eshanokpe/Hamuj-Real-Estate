@extends('layouts.dashboard')

<style>
    .copy-success {
        font-size: 14px;
        color: #28a745;
        margin-left: 8px;
        animation: fadeInOut 3s forwards;
    }

    .copy-fail {
        font-size: 14px; 
        color: #dc3545;
        margin-left: 8px;
        animation: fadeInOut 3s forwards;
    }
    .referral-code {
        word-break: break-word; /* Ensure long text breaks into the next line */
        overflow-wrap: break-word; /* Allow content to wrap within the container */
    }

    .referral_code {
        display: block; /* Force the referral code to start on a new line */
        margin-bottom: 10px; /* Add space below the referral code */
        font-size: 14px; /* Adjust font size if needed */
        color: #333; /* Optional: Set a text color */
        max-width: 100%; /* Prevent it from exceeding the container width */
    }


    @keyframes fadeInOut {
        0% { opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>

@section('content')

<div class="page__body--wrapper"  id="dashbody__page--body__wrapper">
   
    <!-- End header area -->
    <main class="main__content_wrapper" >
        <!-- dashboard container -->
        <div class="dashboard__container d-flex">
            <div class="main__content--left">
                <div class="main__content--left__inner">
                    <!-- Welcome section -->
                    <div class="dashboard__chart--box mb-30">
                        <h2 class="dashboard__chart--title"> Hi, {{ auth::user()->last_name}} {{ auth::user()->first_name}}</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        <h3 class="currency__card--title">
                                            <span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.18542 7.50511C5.18542 8.03457 5.59481 8.46032 6.09697 8.46032H7.12313C7.55979 8.46032 7.91459 8.08916 7.91459 7.6252C7.91459 7.12849 7.69626 6.94837 7.37422 6.83374L5.73126 6.26061C5.40922 6.14599 5.19089 5.97132 5.19089 5.46916C5.19089 5.01066 5.54567 4.63403 5.98234 4.63403H7.00851C7.51067 4.63403 7.92006 5.05978 7.92006 5.58924" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6.55005 4.09375V9.00625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.0083 6.54989C12.0083 9.56289 9.56301 12.0082 6.55001 12.0082C3.53701 12.0082 1.09167 9.56289 1.09167 6.54989C1.09167 3.53689 3.53701 1.09155 6.55001 1.09155" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.27917 1.63745V3.82078H11.4625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.0083 1.09155L9.27917 3.82072" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            Total Assets  
                                        </h3> 
                                        <span class="currency__card--amount">₦{{ number_format($totalPropertyAmount, 2)}}</span>
                                        <div class="currency__card--footer"> 
                                          
                                            <span class="currency__weekly">Property assets</span>
                                            <span class="currency__increase ">
                                                <a class="currency__withdrawal" href="{{ route('user.buy') }}">
                                                <svg width="6" height="7" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.71978 0.111888L0.115159 2.63983C0.0408097 2.712 -1.83231e-07 2.80817 -1.78748e-07 2.91073C-1.7426e-07 3.01339 0.0408684 3.10951 0.115159 3.18167L0.351692 3.41119C0.425924 3.4833 0.525076 3.52302 0.630795 3.52302C0.736455 3.52302 0.838949 3.4833 0.913181 3.41119L2.43599 1.93643L2.43599 6.62183C2.43599 6.83308 2.60638 7 2.8241 7L3.15849 7C3.3762 7 3.56378 6.83308 3.56378 6.62183L3.56378 1.91969L5.09509 3.41114C5.16944 3.48324 5.26589 3.52296 5.37161 3.52296C5.47721 3.52296 5.57507 3.48324 5.64936 3.41114L5.88513 3.18162C5.95948 3.10946 6 3.01333 6 2.91067C6 2.80812 5.95896 2.71194 5.88461 2.63978L3.28004 0.11183C3.20546 0.0394972 3.10589 -0.000281947 3.00006 2.72989e-06C2.89387 -0.000225194 2.79425 0.0394977 2.71978 0.111888Z" fill="currentColor"></path>
                                                </svg>
                                                {{$totalTransactionsAssets}}
                                                </a>
                                            </span>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        <h3 class="currency__card--title">
                                            <span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.18542 7.50511C5.18542 8.03457 5.59481 8.46032 6.09697 8.46032H7.12313C7.55979 8.46032 7.91459 8.08916 7.91459 7.6252C7.91459 7.12849 7.69626 6.94837 7.37422 6.83374L5.73126 6.26061C5.40922 6.14599 5.19089 5.97132 5.19089 5.46916C5.19089 5.01066 5.54567 4.63403 5.98234 4.63403H7.00851C7.51067 4.63403 7.92006 5.05978 7.92006 5.58924" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6.55005 4.09375V9.00625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.0083 6.54989C12.0083 9.56289 9.56301 12.0082 6.55001 12.0082C3.53701 12.0082 1.09167 9.56289 1.09167 6.54989C1.09167 3.53689 3.53701 1.09155 6.55001 1.09155" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.27917 1.63745V3.82078H11.4625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.0083 1.09155L9.27917 3.82072" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            Total Referral Reward 
                                        </h3>
                                        <span class="currency__card--amount">₦{{ number_format(auth()->user()->commission_balance, 2) }}</span>
                                        <div class="currency__card--footer"> 
                                        
                                            <span class="currency__weekly">My invite </span>
                                            <span class="currency__increase ">
                                                <a class="currency__withdrawal" href="{{ route('user.referral.index') }}">
                                                <svg width="6" height="7" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.71978 0.111888L0.115159 2.63983C0.0408097 2.712 -1.83231e-07 2.80817 -1.78748e-07 2.91073C-1.7426e-07 3.01339 0.0408684 3.10951 0.115159 3.18167L0.351692 3.41119C0.425924 3.4833 0.525076 3.52302 0.630795 3.52302C0.736455 3.52302 0.838949 3.4833 0.913181 3.41119L2.43599 1.93643L2.43599 6.62183C2.43599 6.83308 2.60638 7 2.8241 7L3.15849 7C3.3762 7 3.56378 6.83308 3.56378 6.62183L3.56378 1.91969L5.09509 3.41114C5.16944 3.48324 5.26589 3.52296 5.37161 3.52296C5.47721 3.52296 5.57507 3.48324 5.64936 3.41114L5.88513 3.18162C5.95948 3.10946 6 3.01333 6 2.91067C6 2.80812 5.95896 2.71194 5.88461 2.63978L3.28004 0.11183C3.20546 0.0394972 3.10589 -0.000281947 3.00006 2.72989e-06C2.89387 -0.000225194 2.79425 0.0394977 2.71978 0.111888Z" fill="currentColor"></path>
                                                </svg>
                                                {{ auth()->user()->referralsMade->count() }}
                                                </a>
                                            </span>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Welcome section .\ -->

                    <!-- Currency section -->
                    <div class="currency__section mb-30">
                        <div class="currency__column4 swiper">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="swiper-slide">
                                        <div class="currency__card">
                                            <!-- Card Header -->
                                            <h3 class="currency__card--title">
                                                <span>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.18542 7.50511C5.18542 8.03457 5.59481 8.46032 6.09697 8.46032H7.12313C7.55979 8.46032 7.91459 8.08916 7.91459 7.6252C7.91459 7.12849 7.69626 6.94837 7.37422 6.83374L5.73126 6.26061C5.40922 6.14599 5.19089 5.97132 5.19089 5.46916C5.19089 5.01066 5.54567 4.63403 5.98234 4.63403H7.00851C7.51067 4.63403 7.92006 5.05978 7.92006 5.58924" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M6.55005 4.09375V9.00625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12.0083 6.54989C12.0083 9.56289 9.56301 12.0082 6.55001 12.0082C3.53701 12.0082 1.09167 9.56289 1.09167 6.54989C1.09167 3.53689 3.53701 1.09155 6.55001 1.09155" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M9.27917 1.63745V3.82078H11.4625" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12.0083 1.09155L9.27917 3.82072" stroke="#9E38FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                                 Invest
                                            </h3>
                                             
                                            <!-- Buy, Sell, Transfer Buttons -->
                                            <div class="currency__actions mt-3 d-flex justify-content-around">
                                                <a href="{{ route('user.properties') }}" class="btn btn-primary align-items-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/buy.png')}}" alt="Buy" class="me-2" width="50">
                                                   <snap style="font-size: 14px"> Buy </snap>
                                                </a>
                                                <a href="{{ route('user.sell') }}" class="btn btn-secondary align-items-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/sell.png')}}" alt="Sell" class="me-2" width="50">
                                                    <snap style="font-size: 14px">Sell </snap>
                                                </a>
                                                <a href="{{ route('user.transfer') }}" class="btn btn-success align-items-center">
                                                    <img src="{{ asset('assets/admin/img/dashboard/transfer.png')}}" alt="Transfer" class="me-2" width="50">
                                                    <snap style="font-size: 14px"> Transfer</snap>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Currency section .\ -->

                   <!-- Transaction Report Section -->
                    <div class="sales__report--section">
                        <div class="sales__report--heading d-flex align-items-center justify-content-between mb-30">
                            <h2 class="sales__report--heading__title">Property Transaction </h2>
                            <div class="sales__report--short-by select">
                                <form method="GET" id="sortForm">
                                    <select name="filter" class="sales__report--short-by__select" onchange="document.getElementById('sortForm').submit();">
                                        <option value="">Sort By</option>
                                        <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                                        <option value="yesterday" {{ request('filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                        <option value="last7days" {{ request('filter') == 'last7days' ? 'selected' : '' }}>Last 7 Days</option>
                                        <option value="thismonth" {{ request('filter') == 'thismonth' ? 'selected' : '' }}>This Month</option>
                                        <option value="lastmonth" {{ request('filter') == 'lastmonth' ? 'selected' : '' }}>Last Month</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <table class="sales__report--table table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 5%; padding: 10px;">#</th> <!-- Minimal space for index -->
                                    <th style="width: 20%; padding: 5px;">Transaction Ref</th>
                                    <th style="width: 20%; padding: 5px;">Property Status</th>
                                    <th style="width: 15%; padding: 5px;">Amount</th>
                                    <th style="width: 15%; padding: 5px;">Created</th>
                                    <th style="width: 10%; padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @forelse($transactions as $index => $transaction)
                                <tr>
                                    <td style="padding: 10px;">{{ $index + 1 }}</td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">{{ ucfirst($transaction->reference) }}</span>
                                    </td>
                                    <td style="padding: 5px;"> 
                                        <span class="sales__report--body__text">
                                            @if (strtolower($transaction->payment_method) === 'transfer_property')
                                                Transfer Property 
                                            @elseif(strtolower($transaction->payment_method) === 'buy_property')
                                                Buy Property
                                            @else
                                                {{ ucfirst($transaction->payment_method) }}
                                            @endif
                                        </span> 
                                    </td>  
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">₦{{ number_format($transaction->amount, 2) }}</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">{{ ($transaction->created_at->format('d F Y')) }}</span>
                                    </td> 
                                    <td style="padding: 5px;">
                                        @if($transaction->status === 'pending')
                                            <button class="btn btn-warning btn-sm">{{ ucfirst($transaction->status) }}</button>
                                        @elseif($transaction->status === 'completed' || $transaction->status === 'success')
                                            <button class="btn btn-success btn-sm">{{ ucfirst($transaction->status) }}</button>
                                        @elseif($transaction->status === 'failed' || $transaction->status === 'cancelled')
                                            <button class="btn btn-danger btn-sm">{{ ucfirst($transaction->status) }}</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                       
                        @if($totalTransactionsAssets > 6)
                            <div class="text-center mt-3">
                                <a class="welcome__content--btn solid__btn" href="{{ route('user.transactions') }}">View More Transactions</a>
                            </div>
                        @endif
                    </div>
                    <!-- Transaction Report Section End -->

                </div>
            </div>
            <div class="main__content--right">
                <div class="dashboard__chart--box mb-30">
                    <h2 class="dashboard__chart--title"> Account Details</h2>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="swiper-slide">
                                <div class="currency__card">
                                    <h4 class="currency__card--title">
                                       Account number
                                    </h4> 
                                    <span class="currency__card--amount" style="margin-top: -15px"> 
                                        {{ $user->virtualAccounts->first()->account_number ?? ''}}
                                    </span>
                                    <h4 class="currency__card--title">
                                        Account Bank
                                    </h4>
                                     <span class="currency__card--amount"  style="margin-top: -15px"> 
                                        {{ $user->virtualAccounts->first()->bank_name ?? ''}}
                                    </span>
                                    <h4 class="currency__card--title">
                                        Recipient ID
                                    </h4>
                                     <span class="currency__card--amount"  style="margin-top: -15px;  font-size: 1.6rem;"> 
                                        {{ Auth::user()->recipient_id }}
                                    </span>
                                    
                                  
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
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

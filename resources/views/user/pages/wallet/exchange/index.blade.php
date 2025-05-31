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

    @keyframes fadeInOut {
        0% { opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>

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
                        <h2 class="dashboard__chart--title">Currency Exchange</h2>
                        <p class="mb-0">Convert {{ $fromCurrency }} to other currencies</p>
                        
                        <div class="card-body">
                            @if($fromCurrency === 'GBP')
                            <form id="gbpToNgnForm" action="{{ route('user.wallet.exchange-gbp-to-ngn') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Amount in GBP</label>
                                    <div class="input-group">
                                        <span class="input-group-text">£</span>
                                        <input type="number" 
                                            class="form-control" 
                                            name="amount" 
                                            step="0.01" 
                                            min="1" 
                                            max="{{ $availableBalance }}"
                                            required>
                                        <button class="btn btn-outline-secondary" type="button" id="useMaxGbp">Max</button>
                                    </div>
                                    <small class="text-muted">Available: £{{ number_format($availableBalance, 2) }}</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Exchange Rate</label>
                                    <input type="text"   class="add__listing--input__field"  value="1 GBP = {{ $exchangeRates['gbp_to_ngn'] }} NGN" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">You'll Receive</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input type="text" class="form-control" id="ngnReceivingAmount" readonly>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="solid__btn add__property--btn w-100">Exchange to NGN</button>

                            </form>
                            @else
                                <form id="ngnToGbpForm" action="{{ route('user.wallet.exchange-ngn-to-gbp') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Amount in NGN</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="number" 
                                                class="form-control" 
                                                name="amount" 
                                                {{-- step="1" 
                                                min="100"  --}}
                                                required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Exchange Rate</label>
                                        <input type="text"   class="add__listing--input__field"  value="1 NGN = {{ number_format($exchangeRates['ngn_to_gbp'], 6) }} GBP" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">You'll Receive</label>
                                        <div class="input-group">
                                            <span class="input-group-text">£</span>
                                            <input type="text" class="form-control" id="gbpReceivingAmount" readonly>
                                        </div>
                                    </div>
                                    <br/>
                                    <button type="submit" class="solid__btn add__property--btn w-100">Exchange to GBP</button>
                                </form>
                            @endif
                        </div>
                    </div>

                     <!-- Transaction Report Section -->
                     <div class="sales__report--section">
                        <div class="sales__report--heading d-flex align-items-center justify-content-between mb-30">
                            <h2 class="sales__report--heading__title">Latest Transaction </h2>
                            <div class="sales__report--short-by select">
                               View all
                            </div>
                        </div>
                        <table class="sales__report--table table-responsive">
                            <thead>
                                <tr> 
                                    <th style="width: 5%; padding: 10px;">#</th> <!-- Minimal space for index -->
                                    <th style="width: 20%; padding: 5px;">Transaction Ref</th>
                                    <th style="width: 20%; padding: 5px;">Payment Method</th>
                                    <th style="width: 15%; padding: 5px;">Amount</th>
                                    <th style="width: 15%; padding: 5px;">Created</th>
                                    <th style="width: 10%; padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 10px;">1</td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text"> Top up</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">Card</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">₦120,000.00</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">date</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <button class="btn btn-warning btn-sm">Success</button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        
                        {{-- @if($totalTransactions > 6)
                            <div class="text-center mt-3">
                                <a class="welcome__content--btn solid__btn" href="{{ route('user.transactions') }}">View More Transactions</a>
                            </div>
                        @endif --}}
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
                                        {{ $user->virtualAccounts->first()->account_number}}
                                    </span>
                                    <h4 class="currency__card--title">
                                        Account Bank
                                    </h4>
                                     <span class="currency__card--amount"  style="margin-top: -15px"> 
                                        {{ $user->virtualAccounts->first()->bank_name}}
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const exchangeRate = {{ $exchangeRates['gbp_to_ngn'] }};
    
    // GBP to NGN Conversion
    if (document.getElementById('gbpToNgnForm')) {
        const gbpAmountInput = document.querySelector('#gbpToNgnForm input[name="amount"]');
        const ngnReceivingAmount = document.getElementById('ngnReceivingAmount');
        const useMaxGbpBtn = document.getElementById('useMaxGbp');
        
        if (useMaxGbpBtn) {
            useMaxGbpBtn.addEventListener('click', function() {
                gbpAmountInput.value = {{ $availableBalance }};
                calculateGbpToNgn();
            });
        }
        
        gbpAmountInput.addEventListener('input', calculateGbpToNgn);
        
        function calculateGbpToNgn() {
            const amount = parseFloat(gbpAmountInput.value) || 0;
            const ngnAmount = amount * exchangeRate;
            ngnReceivingAmount.value = ngnAmount.toFixed(2);
        }
    }
    
    // NGN to GBP Conversion
    if (document.getElementById('ngnToGbpForm')) {
        const ngnAmountInput = document.querySelector('#ngnToGbpForm input[name="amount"]');
        const gbpReceivingAmount = document.getElementById('gbpReceivingAmount');
        
        ngnAmountInput.addEventListener('input', function() {
            const amount = parseFloat(ngnAmountInput.value) || 0;
            const gbpAmount = amount / exchangeRate;
            gbpReceivingAmount.value = gbpAmount.toFixed(2);
        });
    }
});
</script>

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
    
    .top-up-cards {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }
    
    .top-up-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        width: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .top-up-card:hover {
        border-color: #4a90e2;
        background-color: #f8f9fa;
    }
    
    .top-up-card.active {
        border-color: #4a90e2;
        background-color: #e7f0fd;
    }
    
    .top-up-card h3 {
        margin-bottom: 10px;
        color: #333;
    }
    
    .top-up-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }
    
    .top-up-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .modal-header h3 {
        margin: 0;
    }
    
    .close-modal {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }
    
    .amount-input {
        position: relative;
        margin-bottom: 20px;
    }
    
    .amount-input .currency-symbol {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: bold;
        font-size: 18px;
    }
    
    .amount-input input {
        padding-left: 40px;
        height: 50px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%;
        font-size: 16px;
    }
    
    .proceed-btn {
        width: 100%;
        padding: 15px;
        border-radius: 5px;
        font-weight: bold;
        background-color: #4a90e2;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 16px;
    }
    
    .proceed-btn:hover {
        background-color: #3a7bc8;
    }
    
    .min-amount {
        font-size: 14px;
        color: #666;
        margin-top: -15px;
        margin-bottom: 20px;
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
                        <h2 class="dashboard__chart--title"> Top Up Account Details</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        
                                        <section class="welcome__section d-flex justify-content-between align-items-center">
                                            <div class="welcome__content">
                                                <h4 class="currency__card--title">
                                                    Account number
                                                 </h4> 
                                                 <span class="currency__card--amount" style="margin-top: -5px"> 
                                                     {{ $user->virtualAccounts->first()->account_number}}
                                                 </span>
                                                 <h4 class="currency__card--title">
                                                    Account Bank
                                                </h4>
                                                 <span class="currency__card--amount"  style="margin-top: -5px"> 
                                                    {{ $user->virtualAccounts->first()->bank_name}}
                                                </span>
                                                <h4 class="currency__card--title">
                                                    Recipient ID
                                                </h4>
                                                 <span class="currency__card--amount"  style="margin-top: -15px;  font-size: 1.6rem;"> 
                                                    {{ Auth::user()->recipient_id }}
                                                </span>
                                                <h4 class="currency__card--title">
                                                    Acount Name
                                                </h4>
                                                 <span class="currency__card--amount"  style="margin-top: -15px;  font-size: 1.6rem;"> 
                                                    {{ Auth::user()->last_name.' '.Auth::user()->first_name }}
                                                </span>
                                                 
                                            </div>
                                            
                                            
                                        </section>
                                        
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Up Accounts Section -->
                    <div class="dashboard__chart--box mb-30">
                        <h2 class="dashboard__chart--title">Top Up Your Accounts</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        <div class="top-up-cards">
                                            <div class="top-up-card" onclick="openTopUpModal('GBP', '£')">
                                                <h3>Top Up Pound Account</h3>
                                                <p>Add funds to your GBP account using card payment</p>
                                                <div class="currency__card--amount">£{{ number_format($wallet->gbp_balance ?? 0, 2) }}</div>
                                            </div> 
                                            <div class="top-up-card" onclick="openTopUpModal('USD', '$')">
                                                <h3>Top Up Dollar Account</h3>
                                                <p>Add funds to your USD account using card payment</p>
                                                <div class="currency__card--amount">${{ number_format($wallet->usd_balance ?? 0, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Top Up Accounts Section -->

                    <!-- Top Up Modal -->

                    <div class="top-up-modal" id="topUpModal">
                        <div id=topUpRevolutModal></div>

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
                    </div>
                    <!-- Transaction Report Section End -->

                </div>
            </div>
            <div class="main__content--right">
                <div class="dashboard__chart--box mb-30">
                    <h2 class="dashboard__chart--title">Main Balances</h2>
                    @include('user.partial.mainBalance')
                </div>

                <div class="dashboard__chart--box mb-30">
                    <h2 class="dashboard__chart--title">Refer and Earn</h2>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="swiper-slide">
                                <div class="currency__card" style="border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                    <h3 class="currency__card--title">
                                        Refer Your Friend and Earn to Your Wallet
                                    </h3>
                                    <div class="referral-code">
                                        <span class="currency__weekly referral_code">
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
    </main>
</div>
{{-- React Mount Point --}}
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

            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        }).catch(() => {
            const message = document.createElement('span');
            message.className = 'copy-fail';
            message.innerText = 'Failed to copy referral link.';
            
            const referralContainer = document.querySelector('.referral-code');
            referralContainer.appendChild(message);

            setTimeout(() => {
                referralContainer.removeChild(message);
            }, 3000);
        });
    }
    
    function openTopUpModal(currency, symbol) {
        const modal = document.getElementById('topUpModal');
        const modalTitle = document.getElementById('modalTitle');
        const currencySymbol = document.getElementById('modalCurrencySymbol');
        const minAmount = document.getElementById('minAmount');
        const currencyType = document.getElementById('currencyType');
        
        // Set modal content based on selected currency
        modalTitle.textContent = `Top Up ${currency === 'GBP' ? 'Pound' : 'Dollar'} Account`;
        currencySymbol.textContent = symbol;
        minAmount.textContent = `${symbol}10.00`; 
        currencyType.value = currency;
        
        // Show modal
        modal.style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('topUpModal').style.display = 'none';
    }
    
    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('topUpModal');
        if (event.target === modal) {
            closeModal();
        }
    }

</script>

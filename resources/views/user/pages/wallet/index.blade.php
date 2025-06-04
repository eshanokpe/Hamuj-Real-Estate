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
                        <h2 class="dashboard__chart--title"> Main Balance</h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        
                                        <section class="welcome__section d-flex justify-content-between align-items-center">
                                            <div class="welcome__content">
                                                <span class="currency__card--amount">{{ Auth::user()->hide_balance ? '••••' : $wallet->currency}} {{ Auth::user()->hide_balance ? '••••' : number_format($wallet->balance, 2) }}</span>
                                            </div>
                                            
                                        </section>
                                        <div class="currency__card--footer">
                                        
                                            <div class="col-lg-12">
                                                <div class="swiper-slide">
                                                    <div class="currency__card">
                                                        <!-- Buy, Sell, Transfer Buttons -->
                                                        <div class="currency__actions mt-3 d-flex justify-content-around">
                                                            <a href="{{ route('user.wallet.topUp') }}" class="btn  d-flex flex-column align-items-center justify-content-center text-center">
                                                                <img src="{{ asset('assets/admin/img/dashboard/top-up.png')}}" alt="Buy" class="me-2 mb-2" width="50">
                                                               <snap style="font-size: 14px"> Top up </snap>
                                                            </a>
                                                            <a href="{{ route('user.wallet.withdraw') }}" class="btn d-flex flex-column align-items-center justify-content-center text-center">
                                                                <img src="{{ asset('assets/admin/img/dashboard/withdrawn.png')}}" alt="Sell" class="me-2 mb-2" width="50">
                                                                <snap style="font-size: 14px">Withdraw </snap>
                                                            </a> 
                                                             
                                                            <a href="{{ route('user.payment.history') }}" class="btn d-flex flex-column align-items-center justify-content-center text-center">
                                                                <img 
                                                                    src="{{ asset('assets/admin/img/dashboard/history.png')}}" 
                                                                    alt="Transfer" 
                                                                    class="mb-2" 
                                                                    width="50">
                                                                <span style="font-size: 14px">Payment History</span>
                                                            </a>
                                                            
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
 
                     <!-- Transaction Report Section -->
                     <div class="sales__report--section">
                        <div class="sales__report--heading d-flex align-items-center justify-content-between mb-30">
                            <h2 class="sales__report--heading__title">Wallet Transaction </h2>
                            <div class="sales__report--short-by">
                                <a href="{{ route('user.payment.history') }}" class=" p-0" style="text-decoration: none;">
                                    View all
                                </a>
                            </div> 
                        </div> 
                        <table class="sales__report--table table-responsive">
                            <thead>
                                <tr> 
                                    <th style="width: 5%; padding: 10px;">#</th>
                                    <th style="width: 20%; padding: 5px;">Type</th>
                                    <th style="width: 20%; padding: 5px;">Details</th>
                                    <th style="width: 15%; padding: 5px;">Amount</th>
                                    <th style="width: 15%; padding: 5px;">Created</th>
                                    <th style="width: 10%; padding: 5px;">Status</th>
                                    <th style="width: 10%; padding: 5px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestTransactions as $transaction)
                                    <tr>
                                        <td style="padding: 10px;">{{ $loop->iteration }}</td>
                                       <td style="padding: 5px;">
                                        <span class="sales__report--body__text">
                                            {{ $transaction }}
                                            @if (isset($transaction->payment_method) && strtolower($transaction->payment_method) === 'dedicated_nuban')
                                                Deposit
                                            @elseif(isset($transaction->payment_method))
                                                {{ ucfirst($transaction->payment_method) }}
                                            @else
                                                {{ ucfirst($transaction->type ?? 'N/A') }}
                                            @endif
                                            <br>
                                            @if(isset($transaction->reason) && $transaction->reason != null)
                                                <small class="text-muted">{{ $transaction->reason }}</small>
                                            @elseif(isset($transaction->description) && $transaction->description != null)
                                                <small class="text-muted">{{ $transaction->description }}</small>
                                            @endif
                                        </span>
                                    </td>
                                        <td style="padding: 5px;"> 
                                            @if(isset($transaction->bankName) || isset($transaction->accountName))
                                                <span class="sales__report--body__text"> 
                                                    {{ $transaction->bankName ?? '' }}<br>
                                                    <b>{{ ucfirst($transaction->accountName ?? '') }}</b>
                                                </span>
                                            @elseif(isset($transaction->description) || isset($transaction->description))
                                            {{ ucfirst($transaction->description) }}

                                                <span class="sales__report--body__text"> 
                                                    {{ $transaction->bank_name ?? '' }}<br>
                                                    <b>{{ ucfirst($transaction->account_name ?? $transaction->recipient_name ?? '') }}</b>
                                                </span>
                                            @else
                                                <span class="sales__report--body__text">N/A</span>
                                            @endif
                                        </td>
                                        <td style="padding: 5px;">
                                            <span class="sales__report--body__text">
                                                @if(is_object($transaction) && isset($transaction->amount))
                                                    -₦{{ number_format($transaction->amount, 2) }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td style="padding: 5px;">
                                            <span class="sales__report--body__text">
                                                @if(is_object($transaction) && !empty($transaction->created_at))
                                                    {{ $transaction->created_at->format('M d, Y g:i A') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </td>
                                        <td style="padding: 5px;">
                                            @php
                                                $status = strtolower($transaction->status ?? $transaction->transaction_state ?? 'pending');
                                                $statusClass = 'secondary';
                                                
                                                if(in_array($status, ['successful', 'completed', 'success'])) {
                                                    $statusClass = 'success';
                                                } elseif($status == 'pending') {
                                                    $statusClass = 'warning';
                                                } elseif(in_array($status, ['failed', 'cancelled'])) {
                                                    $statusClass = 'danger';
                                                }
                                            @endphp
                                            <button class="btn btn-{{ $statusClass }} btn-sm">
                                                {{ ucfirst($status) }}
                                            </button>
                                        </td>
                                       
                                        <td style="padding: 5px;">
                                            @if(is_object($transaction) && isset($transaction->id))
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('user.transaction.download', $transaction->id) }}"
                                                       class="btn btn-primary"
                                                       title="Download Receipt">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="{{ route('user.transaction.show', $transaction->id) }}"
                                                       class="btn btn-info"
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-primary btn-sm" title="Download Receipt" disabled><i class="fas fa-download"></i></button>
                                                    <button class="btn btn-info btn-sm" title="View Details" disabled><i class="fas fa-eye"></i></button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center" style="padding: 10px;">
                                            No transactions found.
                                        </td>
                                    </tr>
                                @endforelse
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

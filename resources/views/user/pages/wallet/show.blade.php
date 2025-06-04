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
                        <h2 class="dashboard__chart--title">Main Balance</h2>

                        <div class="container py-4">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h4 class="mb-0">Transaction Details</h4>
                                                <div class="btn-group">
                                                    <button onclick="window.print()" class="btn btn-light btn-sm">
                                                        <i class="fas fa-print me-1"></i> Print
                                                    </button>
                                                    @if($transaction->isNotEmpty())
                                                    <a href="{{ route('user.transaction.download', $transaction->first()->id) }}" class="btn btn-light btn-sm">
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                    @endif
                                                    <button class="btn btn-light btn-sm" id="shareBtn" style="display: none;">
                                                        <i class="fas fa-share-alt me-1"></i> Share
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body" id="receiptContent">
                                            @forelse($transaction as $txn)
                                            <div class="transaction-detail mb-4 pb-4 border-bottom">
                                                <div class="row mb-4">
                                                    <div class="col-md-6 text-md-end">
                                                        <img src="{{ asset('assets/img/dohmaynlogo.png') }}" style="width: 40px; height:40px" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="text-primary">{{ config('app.name') }}</h5>
                                                        <p class="mb-1"><strong>Date:</strong> {{ $txn->created_at->format('M d, Y') }}</p>
                                                        <p class="mb-1"><strong>Transaction Reference:</strong> {{ $txn->reference ?? 'N/A' }}</p>

                                                    </div>
                                                   
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="card border-0 bg-light">
                                                            <div class="card-body">
                                                                <h6 class="card-title text-muted">Transaction Details</h6>
                                                                <div class="mb-2">
                                                                    <small class="text-muted">Type</small>
                                                                    <p class="mb-0 fw-bold">
                                                                        @if(isset($txn->payment_method) && strtolower($txn->payment_method) === 'wallet')
                                                                            Wallet Deposit
                                                                        @elseif(isset($txn->payment_method))
                                                                            {{ ucfirst($txn->payment_method) }} Payment
                                                                        @else
                                                                            {{ ucfirst($txn->type ?? 'Transaction') }}
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <small class="text-muted">Amount</small>
                                                                    <p class="mb-0 fw-bold">₦{{ number_format($txn->amount, 2) }}</p>
                                                                </div>
                                                                <div>
                                                                    <small class="text-muted">Status</small>
                                                                    <p class="mb-0">
                                                                        @php
                                                                            $status = strtolower($txn->status ?? $txn->transaction_state ?? 'pending');
                                                                            $statusClass = match(true) {
                                                                                in_array($status, ['successful', 'completed', 'success']) => 'success',
                                                                                $status === 'pending' => 'warning',
                                                                                in_array($status, ['failed', 'cancelled']) => 'danger',
                                                                                default => 'secondary',
                                                                            };
                                                                        @endphp
                                                                        <span class="badge bg-{{ $statusClass }}">{{ ucfirst($status) }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="card border-0 bg-light">
                                                            <div class="card-body">
                                                                <h6 class="card-title text-muted">Recipient Details</h6>
                                                                {{$txn->metadata}}
                                                                @if(is_array($txn->metadata))
                                                                    <div class="mb-2">
                                                                        <small class="text-muted">Account Number</small>
                                                                        <p class="mb-0 fw-bold">{{ $txn->metadata['receiver_account_number'] ?? 'N/A' }}</p>
                                                                            {{$txn->metadata['receiver_bank'] }}

                                                                    </div>
                                                                @endif
                                                                 {{-- <div class="mb-2">
                                                                    <small class="text-muted">Account Number</small>
                                                                    <p class="mb-0 fw-bold">{{ $txn->metadata['receiver_account_number']}}</p>
                                                                </div> --}}
                                                                @if(isset($txn->bankName) || isset($txn->accountName) || isset($txn->bank_name) || isset($txn->account_name))
                                                                <div class="mb-2">
                                                                    <small class="text-muted">Bank</small>
                                                                    <p class="mb-0 fw-bold">{{ $txn->bankName ?? $txn->bank_name ?? 'N/A' }}</p>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <small class="text-muted">Account Name</small>
                                                                    <p class="mb-0 fw-bold">{{ $txn->accountName ?? $txn->account_name ?? 'N/A' }}</p>
                                                                </div>
                                                                @if(isset($txn->account_number))
                                                                <div>
                                                                    <small class="text-muted">Account Number</small>
                                                                    <p class="mb-0 fw-bold">{{ $txn->account_number ?? 'N/A' }}</p>
                                                                </div>
                                                                @endif
                                                                @else
                                                                <p class="text-muted">No recipient details available</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(isset($txn->reason) || isset($txn->description))
                                                <div class="card border-0 bg-light mb-4">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-muted">Description</h6>
                                                        <p>{{ $txn->reason ?? $txn->description }}</p>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @empty
                                                <p class="text-center text-muted">No transaction found.</p>
                                            @endforelse

                                            <div class="d-flex justify-content-between align-items-center mt-4">
                                                <a href="{{ route('user.wallet.index') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-arrow-left me-1"></i> Back to Wallet
                                                </a>
                                                @if($transaction->isNotEmpty())
                                                <small class="text-muted">Processed on: {{ $transaction->last()->created_at->format('M d, Y g:i A') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                if (navigator.share) {
                                    document.getElementById('shareBtn').style.display = 'block';

                                    document.getElementById('shareBtn').addEventListener('click', async () => {
                                        try {
                                            await navigator.share({
                                                title: 'Transaction Receipt',
                                                text: 'Transaction Reference: {{ $transaction->first()->id ?? 'N/A' }}',
                                                url: window.location.href,
                                            });
                                        } catch (err) {
                                            console.error('Error sharing:', err);
                                        }
                                    });
                                }
                            });
                        </script>
                        @endpush

                        <style>
                            @media print {
                                body * {
                                    visibility: hidden;
                                }
                                #receiptContent, #receiptContent * {
                                    visibility: visible;
                                }
                                #receiptContent {
                                    position: absolute;
                                    left: 0;
                                    top: 0;
                                    width: 100%;
                                    padding: 20px;
                                }
                                .no-print {
                                    display: none !important;
                                }
                                .card {
                                    border: none !important;
                                    box-shadow: none !important;
                                }
                                .border-bottom {
                                    border-bottom: 1px solid #dee2e6 !important;
                                }
                            }
                        </style>
                    </div>
 
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

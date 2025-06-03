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
                        <table class="sales__report--table table-responsive">
                            <thead>
                                <tr> 
                                    <th style="width: 5%; padding: 10px;">#</th>
                                    <th style="width: 20%; padding: 5px;">Type</th>
                                    <th style="width: 20%; padding: 5px;">Details</th>
                                    <th style="width: 15%; padding: 5px;">Amount</th>
                                    <th style="width: 15%; padding: 5px;">Created</th>
                                    <th style="width: 10%; padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td style="padding: 10px;">{{ $loop->iteration }}</td>
                                        <td style="padding: 5px;">
                                            <span class="sales__report--body__text">
                                                {{ ucfirst($transaction->type) }}<br>
                                                @if($transaction->reason != null)
                                                    <small class="text-muted">{{ $transaction->reason ??'' }}</small>
                                                @endif
                                            </span>
                                        </td> 
                                        <td style="padding: 5px;"> 
                                            @if(isset($transaction->bankName) || isset($transaction->accountName ))
                                                <span class="sales__report--body__text"> 
                                                    {{ $transaction->bankName ?? '' }}<br>
                                                    {{ $transaction->accountName ?? '' }}
                                                </span>
                                            @else
                                                <span class="sales__report--body__text">N/A</span>
                                            @endif
                                        </td>
                                        <td style="padding: 5px;">
                                            <span class="sales__report--body__text">
                                                ₦{{ number_format($transaction->amount, 2) }}
                                                
                                            </span>
                                             <span class="sales__report--body__text @if($transaction->type === 'transfer') text-danger @else text-danger @endif">
                                                    @if($transaction->type === 'transfer') - @else + @endif
                                                    ₦{{ number_format($transaction->amount, 2) }}
                                            </span>
                                        </td>
                                        <td style="padding: 5px;">
                                            <span class="sales__report--body__text">
                                                {{ $transaction->created_at->format('M d, Y g:i A') }}
                                            </span>
                                        </td>
                                        <td style="padding: 5px;">
                                            @php
                                                $status = strtolower($transaction->status);
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
                                                {{ ucfirst($transaction->status) }}
                                            </button>
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
                        <div class="accordion accordion-flush">

                            
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

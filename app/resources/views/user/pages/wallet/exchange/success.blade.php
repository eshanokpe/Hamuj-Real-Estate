@extends('layouts.dashboard')

@section('content')
<style>
    .alert-success {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
 
    .alert-success .btn-close {
        background: none;
        border: none;
        color: white;
        opacity: 0.8;
        font-size: 1.2rem;
    }

    .alert-success .btn-close:hover {
        opacity: 1;
    }

    .success-card {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        border: 1px solid #eaeaea;
    }

    .success-icon {
        font-size: 4rem;
        color: #4CAF50;
        margin-bottom: 20px;
    }

    .success-card h2 {
        font-size: 1.8rem;
        margin-bottom: 15px;
        color: #333;
        font-weight: 600;
    }

    .success-card p {
        color: #666;
        margin: 15px 0;
        line-height: 1.6;
        font-size: 1.05rem;
    }

    .transaction-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin: 25px 0;
        text-align: left;
    }

    .transaction-details h5 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .transaction-details ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .transaction-details li {
        margin-bottom: 8px;
        color: #555;
        display: flex;
    }

    .transaction-details li:before {
        content: "•";
        color: #4CAF50;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }

    .btn-return {
        background-color: #47008E;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        display: inline-block;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        margin-top: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-return:hover {
        background-color: #5a00b3;
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .success-card {
            margin: 20px;
            padding: 20px;
        }
        
        .success-icon {
            font-size: 3rem;
        }
        
        .success-card h2 {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    // Auto-hide success alert after 5 seconds
    setTimeout(function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }
    }, 5000);
</script>

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <main class="main__content_wrapper">
        <div class="dashboard__container d-flex">
            <div class="container my-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="success-card">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h2>Exchange Successful</h2>
                    <p>
                        @if(!is_null($message))
                            {{ $message }}
                        @else
                           Your payment has been successfully processed.
                        @endif
                    </p>
                    
                    @if (isset($transaction_id))
                        <div class="transaction-details">
                            <h5>Transaction Details</h5>
                            <ul>
                                <li><strong>Transaction ID:</strong> {{ $transaction_id }}</li>
                                @if(isset($gbp_amount))<li><strong>GBP Amount:</strong> £{{ number_format($gbp_amount, 2) }}</li>@endif
                                @if(isset($ngn_amount))<li><strong>NGN Amount:</strong> ₦{{ number_format($ngn_amount, 2) }}</li>@endif
                            </ul>
                        </div>
                    @endif
                    
                    <a href="{{ route('user.dashboard') }}" class="btn-return">
                        Return to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
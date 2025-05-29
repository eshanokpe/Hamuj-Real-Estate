@extends('layouts.dashboard')

@section('content')
<style>
    .alert-success {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
 
    .alert-success .btn-close {
        background-color: transparent;
        border: none;
    }

    .success-message {
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-top: 50px;
    }

    .success-message h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #28a745;
    }

    .success-message p {
        margin: 5px 0;
    }

    .btn-return {
        background-color: #47008E;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-return:hover {
        background-color: #3a0075;
    }

</style>

<script>
    // Auto-hide success alert after 5 seconds
    setTimeout(function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            successAlert.classList.add('fade');
            successAlert.classList.remove('show');
        }
    }, 5000);
</script>

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <!-- End header area -->
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container d-flex">
            <div class="container my-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="success-message">
                    <h3>Payment Successful</h3>
                    <p>Your payment has been successfully processed.</p>
                    <p>Thank you for your purchase! You will receive an email confirmation shortly.</p>
                    {{-- <a>{{ json_encode($order, true) ?? ''}}</a> --}}
                    <div class="order-details">
                        <h3>Order: {{ $order['description'] ?? 'N/A' }}</h3>
                        <p><strong>Status:</strong> {{ $order['state'] ?? 'N/A' }}</p>
                        <p><strong>Order ID:</strong> {{ $order['public_id'] ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y H:i') }}</p>
                        <p><strong>Amount:</strong> £{{ number_format($order['order_amount']['value'] / 100, 2) }} GBP</p>
                        
                        @if(!empty($order['payments']))
                        <div class="payment-details">
                            <h4>Payment Information</h4>
                            <p><strong>Method:</strong> {{ $order['payments'][0]['payment_method']['card']['card_brand'] ?? 'N/A' }}</p>
                            <p><strong>Card:</strong> **** **** **** {{ $order['payments'][0]['payment_method']['card']['card_last_four'] ?? 'N/A' }}</p>
                            <p><strong>Settled Amount:</strong> £{{ number_format($order['payments'][0]['settled_amount']['value'] / 100, 2) }}</p>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="btn-return">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection

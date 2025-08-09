@extends('layouts.dashboard')

@section('content')
<style>
    .alert-danger { /* Changed from alert-success */
        background-color: #dc3545; /* Red color for failure/error */
        color: white;
        border: none;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
 
    .alert-danger .btn-close { /* Changed from alert-success */
        background-color: transparent;
        border: none;
    }

    .failure-message { /* Renamed from success-message */
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-top: 50px;
    }

    .failure-message h3 { /* Renamed from success-message */
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #dc3545; /* Red color for failure/error */
    }

    .failure-message p { /* Renamed from success-message */
        margin: 5px 0;
    }

    .btn-return {
        background-color: #47008E; /* Kept existing button style */
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-return:hover {
        background-color: #3a0075; /* Kept existing button hover style */
    }

</style>

<script>
    // Auto-hide failure alert after 5 seconds
    setTimeout(function() {
        const failureAlert = document.querySelector('.alert-danger'); // Changed selector
        if (failureAlert) {
            // Ensure Bootstrap's JS is loaded for fade/show to work as expected
            // or implement custom fade out logic if not using Bootstrap JS for this
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const alertInstance = bootstrap.Alert.getInstance(failureAlert);
                if (alertInstance) {
                    alertInstance.close();
                }
            } else {
                // Fallback to simple hide if Bootstrap JS for Alert is not available
                failureAlert.style.display = 'none';
            }
        }
    }, 5000);
</script>

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
    <!-- End header area -->
    <main class="main__content_wrapper">
        <!-- dashboard container -->
        <div class="dashboard__container d-flex">
            <div class="container my-4">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                        <strong>Payment Failed!</strong> {{ session('error') }} 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="failure-message"> 
                    <h3>Payment Failed</h3> 
                    <p>Unfortunately, your payment could not be processed at this time.</p>
                    <p>Please check your payment details and try again. If the problem persists, contact support.</p> 
                    <a href="{{ route('user.dashboard') }}" class="btn-return">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection

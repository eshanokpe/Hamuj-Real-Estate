@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container setting__container">
                <div class="add__property--heading mb-30">
                    <h2 class="add__property--heading__title">Transaction PIN</h2>
                    <p class="add__property--desc">Set a 4-digit PIN for secure transactions</p>
                </div>
                
                <div class="setting__page--inner">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="setting__profile edit-profile">
                            <div class="col-8">
                                <form action="{{ route('user.transaction.create.pin', Auth::user()->id) }}" method="POST" id="pinForm">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="edit__profile--step">
                                        <h3 class="setting__profile--title">
                                            @if(Auth::user()->transaction_pin)
                                                Change Your Transaction PIN
                                            @else
                                                Create Your Transaction PIN
                                            @endif
                                        </h3>
                                        
                                        <div class="setting__profile--inner">
                                            @if(Auth::user()->transaction_pin)
                                                <!-- Old PIN (Only show if PIN exists) -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="old_pin">Current PIN</label>
                                                    <input 
                                                        class="add__listing--input__field w-100" 
                                                        id="old_pin" 
                                                        name="old_pin" 
                                                        placeholder="Enter Current PIN" 
                                                        type="password" 
                                                        inputmode="numeric"
                                                        pattern="\d{4}"
                                                        minlength="4"
                                                        maxlength="4"
                                                        required
                                                        autocomplete="off">
                                                </div>
                                            @endif
                                            
                                            <!-- New PIN -->
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="new_pin">
                                                    @if(Auth::user()->transaction_pin)
                                                        New PIN
                                                    @else
                                                        Create PIN
                                                    @endif
                                                </label>
                                                <input 
                                                    class="add__listing--input__field" 
                                                    id="new_pin" 
                                                    name="new_pin" 
                                                    placeholder="Enter 4-digit PIN" 
                                                    type="password" 
                                                    inputmode="numeric"
                                                    pattern="\d{4}"
                                                    minlength="4"
                                                    maxlength="4"
                                                    required
                                                    autocomplete="off">
                                            </div>
                                            
                                            <!-- Confirm New PIN -->
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="confirm_pin">Confirm PIN</label>
                                                <input 
                                                    class="add__listing--input__field" 
                                                    id="confirm_pin" 
                                                    name="new_pin_confirmation" 
                                                    placeholder="Re-enter 4-digit PIN" 
                                                    type="password" 
                                                    inputmode="numeric"
                                                    pattern="\d{4}"
                                                    minlength="4"
                                                    maxlength="4"
                                                    required
                                                    autocomplete="off">
                                            </div>
                                            
                                            <!-- Submit Button -->
                                            <button type="submit" class="solid__btn add__property--btn">
                                                @if(Auth::user()->transaction_pin)
                                                    Update PIN
                                                @else
                                                    Set PIN
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            </div>
            <!-- dashboard container .\ -->
        </main>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pinForm = document.getElementById('pinForm');
    
    // Prevent form submission if PINs don't match
    pinForm.addEventListener('submit', function(e) {
        const newPin = document.getElementById('new_pin').value;
        const confirmPin = document.getElementById('confirm_pin').value;
        
        if (newPin !== confirmPin) {
            e.preventDefault();
            alert('PINs do not match. Please ensure both PIN fields are identical.');
        }
        
        // Additional validation can be added here
        if (newPin.length !== 4 || !/^\d+$/.test(newPin)) {
            e.preventDefault();
            alert('PIN must be exactly 4 digits.');
        }
    });
    
    // Auto-advance between PIN fields
    const pinInputs = document.querySelectorAll('input[type="password"][inputmode="numeric"]');
    pinInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length === 4) {
                const nextInput = this.nextElementSibling;
                if (nextInput && nextInput.tagName === 'INPUT') {
                    nextInput.focus();
                }
            }
        });
    });
});
</script>
@endpush
@endsection
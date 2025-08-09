@extends('layouts.app')

@section('content')


  <!-- Account Page section -->
  <section class="account__page--section section--padding">
    <div class="container">
        <div class="account__section--inner">
            <div class="account__tab--btn">
                <ul class="account__tab--btn__wrapper d-flex justify-content-center">
                    <li class="account__tab--btn__items">
                        <span class="account__tab--btn__field active">Verify Your Account</span>
                    </li>
                </ul>
            </div>
            <div class="account__form--wrapper">
               
                <div class="account__form">
                    <form method="POST" action="{{ route('verification.otp') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <div class="account__form--input mb-20">
                            <label class="account__form--input__label mb-12" for="email">Enter OTP</label>
                            <input id="otp" placeholder="Enter 6-digit code" 
                          
                            maxLength="6"
                            inputMode="numeric"
                            pattern="\d{6}"

                            type="number"
                            class="account__form--input__field  @error('otp') is-invalid @enderror"
                            name="otp" value="{{ old('otp') }}" required autofocus>
                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong> 
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="account__form--btn solid__btn">Verify OTP</button>

                    </form>
                    <script>
                        function togglePasswordVisibility(fieldId) {
                            const inputField = document.getElementById(fieldId);
                            if (inputField.type === "password") {
                                inputField.type = "text";
                            } else {
                                inputField.type = "password";
                            }
                        }

                    </script>
                   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Account Page section .\ -->

@endsection
 
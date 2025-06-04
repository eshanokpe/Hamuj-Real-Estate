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
    button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        opacity: 0.6;
    }

</style>

<style>
    .resolved-account-display {
        padding: .75rem 1rem; /* Match your input field padding */
        border: 1px solid #ced4da; /* Match your input field border */
        border-radius: .25rem; /* Match your input field border-radius */
        background-color: #e9ecef; /* Light background to indicate read-only */
        min-height: calc(1.5em + 1.5rem + 2px); /* Match your input field height */
        line-height: 1.5;
        color: #495057; /* Default text color */
    }
    .resolved-account-display .account-name { font-weight: bold; display: block; color: #28a745; /* Green for success */}
    .resolved-account-display .bank-name { font-size: 0.9em; color: #555; display: block; }
    .resolved-account-display .status-message { color: #007bff; /* Blue for neutral/verifying messages */ }
    .resolved-account-display .status-message.error { color: #dc3545; /* Red for error messages */ }

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
                        <h2 class="dashboard__chart--title"> Transfer to </h2>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiper-slide">
                                    <div class="currency__card">
                                        
                                        <section class="">
                                            <div class="welcome__content">
                                                <div class="setting__profile--inner">
                                                    <div class="add__listing--form">
                                                        @csrf
                                                        <!-- Account Number Input -->
                                                        <div class="add__listing--input__box mb-20">
                                                            <label class="add__listing--input__label" for="name">Recipient Account Number</label>
                                                            <input 
                                                                class="add__listing--input__field" 
                                                                id="number" 
                                                                name="account_number" 
                                                                placeholder="Enter 10 digits Account Number" 
                                                                type="number" 
                                                                value="">
                                                        </div>
                                                        
                                                        <!-- Bank Select -->
                                                        <div class="add__listing--input__box mb-20">
                                                            <label class="add__listing--input__label" for="bank">Select Bank</label>
                                                            <select name="bank_code" id="bank" class="add__listing--input__field js-bank-select">
                                                                <option value="">Select a bank</option>
                                                                @if(!empty($banks))
                                                                    @foreach($banks as $bank)
                                                                        <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No banks available</option>
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <!-- Account Name Display -->
                                                        <div class="add__listing--input__box mb-20">
                                                            <label class="add__listing--input__label">Verified Account Details</label>
                                                            <div id="resolved_account_info_display" class="resolved-account-display">
                                                                <span class="status-message">Details will appear here upon verification.</span>
                                                            </div>
                                                        </div>

                                                        <div class="add__listing--input__box mb-20" id="amount-container" style="display: none;">
                                                            <label class="add__listing--input__label" for="amount">Amount (₦)</label>
                                                            <input 
                                                                type="number" 
                                                                id="amount_display" 
                                                                placeholder="0.00" 
                                                                min="0" 
                                                                step="0.01"
                                                                name="amount" 
                                                                class="add__listing--input__field" 
                                                                required
                                                                {{-- disabled --}}
                                                            />
                                                        </div>
                                                    
                                                        <!-- Submit Button -->
                                                        <button type="button" class="solid__btn add__property--btn" id="next-button" data-bs-toggle="modal" data-bs-target="#modaladdcontact" aria-label="popup button" disabled>
                                                            Next
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
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
 <!-- Modal -->
 <div class="modal fade" id="modaladdcontact" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal__contact--main__content">
            <div class="modal__contact--header d-flex align-items-center justify-content-between">
                <h3 class="modal__contact--header__title">Transfer Confirmation</h3>
                <button type="button" class="modal__contact--close__btn" data-bs-dismiss="modal" aria-label="Close">    
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.711" height="12.711" viewBox="0 0 12.711 12.711">
                        <g id="Group_7205" data-name="Group 7205" transform="translate(-113.644 -321.644)">
                          <path id="Vector" d="M0,9.883,9.883,0" transform="translate(115.059 323.059)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                          <path id="Vector-2" data-name="Vector" d="M9.883,9.883,0,0" transform="translate(115.059 323.059)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </g>
                      </svg>                                                              
                </button>
            </div>
            <div class="modal-body modal__contact--body">
                <div class="modal__contact--form">
                    <form  id="create-recipient-form">
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name">Account Number</label>
                            <input name="modal-account-number" class="modal__contact--input__field" id="modal-account-number" type="text" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name">Account Name</label>
                            <input name="modal-account-name" class="modal__contact--input__field" id="modal-account-name"  type="text" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name">Bank Name</label>
                            <input name="bank_name" class="modal__contact--input__field" id="modal-bank-name"  type="text" readonly>
                            <input name="modal-bankCode" class="modal__contact--input__field" id="modal-bankCode"  type="hidden" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name"> Amount</label>
                            <input name="modal-amount" class="modal__contact--input__field" id="modal-amount" type="text" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name"> Enter 4-digit Transaction PIN</label>
                            <input name="modal-pin" class="modal__contact--input__field"  maxlength="4"  inputmode="numeric"
                                   pattern="\d{4}"
                                   placeholder="****" id="transactionPin" type="password" required>
                        </div>
                       
                        <div class="modal__contact--footer">
                            <button class="solid__btn border-0" id="process-transfer" type="submit">
                                <span class="button-text">Process Transfer</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                            {{-- <button class="solid__btn border-0"  type="submit">Process Transfer</button> --}}
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 



    
<script>
    @auth
        @if (!auth()->user()->transaction_pin)
            window.location.href = "{{ route('user.transaction.pin') }}"; 
        @endif
    @endauth 
    document.addEventListener("DOMContentLoaded", function () {
        const amountInput = document.getElementById("amount");

        amountInput.addEventListener("input", function () {
            let value = amountInput.value.replace(/,/g, ""); // Remove existing commas
            if (!isNaN(value) && value) {
                amountInput.value = new Intl.NumberFormat().format(value); // Add commas
            } else if (!value) {
                amountInput.value = ""; // Clear the field if input is invalid
            }
        });
    });
    $(document).ready(function() {
        $('.js-bank-select').select2({
            placeholder: "Select a bank",
            allowClear: false,
            // width: '100%',
        });
    });
    $(document).ready(function () {
        const $accountNumber = $('#number');
        const $bankSelect = $('#bank');
        const $nextButton = $('#next-button');

        function toggleNextButton() {
            const isAccountNumberValid = $accountNumber.val().length === 10;
            const isBankSelected = $bankSelect.val() !== '';
            $nextButton.prop('disabled', !(isAccountNumberValid && isBankSelected));
        }

        // Listen for input changes
        $accountNumber.on('input', function () {
            const currentValue = $accountNumber.val();
            if (currentValue.length > 10) {
                $accountNumber.val(currentValue.slice(0, 10)); 
            }
            toggleNextButton();
        });
        $bankSelect.on('change', toggleNextButton);
    });

    $(document).ready(function () {
        $('#create-recipient-form').on('submit', function (e) {
            e.preventDefault(); // Prevent form submission
             
            // Collect form data
            const accountNumber = $('#modal-account-number').val();
            const accountName = $('#modal-account-name').val();
            const bankCode = $('#modal-bankCode').val();
            const amount = $('#modal-amount').val();
            const $button = $('#process-transfer');
            const transactionPin = $('#transactionPin').val();
            // Check if Transaction PIN is empty
           

            // Show loading state
            $button.prop('disabled', true);
            $button.find('.button-text').text('Verifying PIN...');
            $button.find('.spinner-border').removeClass('d-none');

            // Step 1: Verify PIN
            $.ajax({
                url: '{{ route("user.wallet.verifyPin") }}', 
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({ 
                    entered_pin: $('#transactionPin').val().trim(),
                    user_id: {{ auth()->id() }}
                }),
                success: function(response) {
                    resetButtonState($button);
                    if (response.status === 'success') {
                        console.log("Complete pin_match:", response.pin_match);

                        if (response.pin_match) {
                            // PIN is correct, proceed to create recipient
                            $button.find('.button-text').text('Processing Transfer...');
                            // Step 2: Create Recipient 
                            $.ajax({
                                url: "{{ route('user.wallet.createRecipient') }}", 
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }, 
                                data: JSON.stringify({
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    name: accountName,
                                    account_number: accountNumber,
                                    bank_code: bankCode
                                }),
                                success: function (response) {
                                    if (response.status === 'success') {
                                        const recipientCode = response.recipient_code;
                                        // Step 3: Initiate Transfer
                                        $.ajax({
                                            url: "{{ route('user.wallet.initiateTransfer') }}",
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }, 
                                            data: JSON.stringify({
                                                _token: $('meta[name="csrf-token"]').attr('content'),
                                                name: accountName, 
                                                account_number: accountNumber,
                                                bank_code: bankCode,
                                                recipient_code: recipientCode,
                                                amount: amount,
                                                reason: 'Payment', 
                                                transfer_reference: generateUUID()
                                            }),
                                            success: function (transferResponse) {
                                                if (transferResponse.status === 'success') {
                                                    toastr.success('The transfer has been completed successfully.', 'Success');
                                                    setTimeout(() => { 
                                                        window.location.href = transferResponse.redirect_url;
                                                    }, 1500);

                                                } else {
                                                    toastr.error('Transfer failed: ' + transferResponse.message, 'Error');
                                                }
                                            },
                                            error: function () {
                                                // toastr.error('An error occurred during the transfer process.', 'Error');
                                            },
                                            complete: function () {
                                                resetButtonState($button);
                                            }
                                        });
                                    } else {
                                        toastr.error('Recipient creation failed: '+ response.message, 'Error');
                                        resetButtonState($button);
                                    }
                                },
                                error: function () {
                                    toastr.error('An error occurred while creating the recipient.', 'Error');
                                    resetButtonState($button);
                                }
                            });
                        } else {
                            toastr.error('The PIN you entered is incorrect.', 'PIN Mismatch');
                            resetButtonState($button);
                        }
                    } else if (response.status === 'error') {
                        // PIN is incorrect
                        toastr.error(response.message || 'Invalid transaction PIN.', 'PIN Verification Failed');
                        resetButtonState($button);
                    }
                },
                error: function () {
                    toastr.error('An error occurred while verifying PIN. Please try again.', 'Error');
                    resetButtonState($button);
                }
            });
        });
        function resetButtonState($button) {
            $button.prop('disabled', false);
            $button.find('.button-text').text('Process Transfer');
            $button.find('.spinner-border').addClass('d-none'); 
        }

        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
    });

   
    $(document).ready(function () {
        $('#bank, #number, #amount_display').on('input change', function () {
            const accountNumber = $('#number').val().trim();
            const bankCode = $('#bank').val();
            const amount = $('#amount_display').val();

            if (accountNumber.length === 10 && bankCode) {
                $('#resolved_account_info_display').html('<span class="status-message">Verifying...</span>');
                $('#next-button').prop('disabled', true);

                // Send AJAX request
                $.ajax({
                    url: "{{ route('user.wallet.resolve.account') }}", 
                    method: "GET",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }, 
                    data: {
                        account_number: accountNumber,
                        bank_code: bankCode,
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            const selectedBankName = $('#bank option:selected').text();
                            $('#resolved_account_info_display').html(
                                '<span class="account-name">' + data.account_name + '</span>' +
                                '<span class="bank-name">' + selectedBankName + '</span>'
                            );

                            $('#modal-account-name').val(data.account_name);

                            $('#account_number').text(data.account_number); 
                            $('#modal-account-number').val(data.account_number); 

                            $('#modal-bank-name').val($('#bank option:selected').text());
                            $('#modal-amount').val(amount);
                            $('#modal-bankCode').val(bankCode);

                            $('#amount').prop('disabled', false);
                            $('#amount-container').show();

                            if (amount && parseFloat(amount) > 0) {
                                $('#next-button').prop('disabled', false);
                            } else {
                                $('#next-button').prop('disabled', true);
                            }
                        } else {
                            $('#resolved_account_info_display').html('<span class="status-message error">' + (response.message || 'Account details not found.') + '</span>');
                            $('#amount').prop('disabled', true);
                            $('#amount-container').hide();
                            $('#next-button').prop('disabled', true);
                        }
                    },
                    error: function () {
                        $('#next-button').prop('disabled', true);
                        $('#resolved_account_info_display').html('<span class="status-message error">Unable to verify account. Please try again.</span>');
                    },
                });
            } else {
                $('#resolved_account_info_display').html('<span class="status-message">Details will appear here upon verification.</span>');
                $('#next-button').prop('disabled', true); // Ensure button remains disabled
            }
        });
        // Additional event listener to ensure button enables when `amount_display` is filled
        $('#amount_display').on('input', function () {
            const amount = $(this).val();

            if (amount && parseFloat(amount) > 0) {
                $('#next-button').prop('disabled', false);
            } else {
                $('#next-button').prop('disabled', true);
            }
        });
    });


</script>
@endsection 
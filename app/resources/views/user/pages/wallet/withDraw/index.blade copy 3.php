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

    .resolved-account-display {
        padding: .75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        background-color: #e9ecef;
        min-height: calc(1.5em + 1.5rem + 2px);
        line-height: 1.5;
        color: #495057;
    }
    .resolved-account-display .account-name { font-weight: bold; display: block; color: #28a745; }
    .resolved-account-display .bank-name { font-size: 0.9em; color: #555; display: block; }
    .resolved-account-display .status-message { color: #007bff; }
    .resolved-account-display .status-message.error { color: #dc3545; }

    .beneficiary-option {
        display: flex;
        justify-content: space-between;
    }
    .beneficiary-account {
        font-weight: bold;
    }
    .beneficiary-bank {
        color: #666;
        font-size: 0.9em;
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
                                                        <!-- Beneficiary Selection -->
                                                        <div class="add__listing--input__box mb-20">
                                                            <label class="add__listing--input__label">Select from saved beneficiaries</label>
                                                            <select id="savedBeneficiaries" class="add__listing--input__field">
                                                                <option value="">Select a saved beneficiary</option>
                                                                @foreach($beneficiaries as $beneficiary)
                                                                    <option 
                                                                        value="{{ $beneficiary->id }}"
                                                                        data-account-number="{{ $beneficiary->account_number }}"
                                                                        data-bank-code="{{ $beneficiary->bank_code }}"
                                                                        data-account-name="{{ $beneficiary->account_name }}"
                                                                        data-bank-name="{{ $beneficiary->bank_name }}">
                                                                        {{ $beneficiary->account_name }} - {{ $beneficiary->account_number }} ({{ $beneficiary->bank_name }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

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
                                    <th style="width: 5%; padding: 10px;">#</th>
                                    <th style="width: 20%; padding: 5px;">Transaction Ref</th>
                                    <th style="width: 20%; padding: 5px;">Payment Method</th>
                                    <th style="width: 15%; padding: 5px;">Amount</th>
                                    <th style="width: 15%; padding: 5px;">Created</th>
                                    <th style="width: 10%; padding: 5px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $index => $transaction)
                                <tr>
                                    <td style="padding: 10px;">{{ $index + 1 }}</td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">{{ $transaction->reference }}</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">{{ $transaction->payment_method }}</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">₦{{ number_format($transaction->amount, 2) }}</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <span class="sales__report--body__text">{{ $transaction->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <td style="padding: 5px;">
                                        <button class="btn btn-{{ $transaction->status == 'success' ? 'success' : 'warning' }} btn-sm">{{ ucfirst($transaction->status) }}</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($transactions->hasPages())
                            <div class="mt-3">
                                {{ $transactions->links() }}
                            </div>
                        @endif
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
                                    <div class="referral-code">
                                        <span class="currency__weekly  referral_code">
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
                        @forelse ($referralsMade as $referral)
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
                        @empty
                            <p>No referrals made yet.</p>
                        @endforelse

                        @if ($referralsMade->hasMorePages())
                            <a href="{{ route('user.referrals.show') }}" class="view-more-link">View More</a>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- dashboard container .\ -->
    </main>
</div>

<!-- Transfer Confirmation Modal -->
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
                            <input name="modal-account-name" class="modal__contact--input__field" id="modal-bank-name"  type="text" readonly>
                            <input name="modal-bankCode" class="modal__contact--input__field" id="modal-bankCode"  type="hidden" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <label class="modal__contact--input__label" for="name"> Amount</label>
                            <input name="modal-amount" class="modal__contact--input__field" id="modal-amount" type="text" readonly>
                        </div>
                        <div class="modal__contact--form__input mb-20">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="saveAsBeneficiary" checked>
                                <label class="form-check-label" for="saveAsBeneficiary">
                                    Save this account as beneficiary for future transfers
                                </label>
                            </div>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Success Modal Template -->
<div class="modal fade" id="transferSuccessModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success">Transfer Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <svg width="60" height="60" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#28a745"/><path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <p class="mt-3 mb-0">The transfer has been completed successfully.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
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

    $(document).ready(function() {
        $('.js-bank-select').select2({
            placeholder: "Select a bank",
            allowClear: false
        });

        // Handle beneficiary selection
        $('#savedBeneficiaries').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            if (selectedOption.val()) {
                $('#number').val(selectedOption.data('account-number')).trigger('input');
                $('#bank').val(selectedOption.data('bank-code')).trigger('change');
                $('#resolved_account_info_display').html(
                    `<span class="account-name">${selectedOption.data('account-name')}</span>
                     <span class="bank-name">${selectedOption.data('bank-name')}</span>`
                );
                $('#amount-container').show();
                $('#next-button').prop('disabled', false);
            }
        });

        // Account verification logic
        $('#bank, #number, #amount_display').on('input change', function() {
            const accountNumber = $('#number').val().trim();
            const bankCode = $('#bank').val();
            const amount = $('#amount_display').val();

            if (accountNumber.length === 10 && bankCode) {
                $('#resolved_account_info_display').html('<span class="status-message">Verifying...</span>');
                $('#next-button').prop('disabled', true);

                $.ajax({
                    url: "{{ route('user.wallet.resolve.account') }}", 
                    method: "GET",
                    data: {
                        account_number: accountNumber,
                        bank_code: bankCode,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            const selectedBankName = $('#bank option:selected').text();
                            $('#resolved_account_info_display').html(
                                '<span class="account-name">' + data.account_name + '</span>' +
                                '<span class="bank-name">' + selectedBankName + '</span>'
                            );

                            // Populate modal fields
                            $('#modal-account-name').val(data.account_name);
                            $('#modal-account-number').val(data.account_number);
                            $('#modal-bank-name').val(selectedBankName);
                            $('#modal-amount').val(amount);
                            $('#modal-bankCode').val(bankCode);

                            $('#amount-container').show();

                            if (amount && parseFloat(amount) > 0) {
                                $('#next-button').prop('disabled', false);
                            } else {
                                $('#next-button').prop('disabled', true);
                            }
                        } else {
                            $('#resolved_account_info_display').html('<span class="status-message error">' + (response.message || 'Account details not found.') + '</span>');
                            $('#amount-container').hide();
                            $('#next-button').prop('disabled', true);
                        }
                    },
                    error: function() {
                        $('#next-button').prop('disabled', true);
                        $('#resolved_account_info_display').html('<span class="status-message error">Unable to verify account. Please try again.</span>');
                    },
                });
            } else {
                $('#resolved_account_info_display').html('<span class="status-message">Details will appear here upon verification.</span>');
                $('#next-button').prop('disabled', true);
            }
        });

        // Amount validation
        $('#amount_display').on('input', function() {
            const amount = $(this).val();
            $('#next-button').prop('disabled', !(amount && parseFloat(amount) > 0));
        });

        // Transfer form submission
        $('#create-recipient-form').on('submit', function(e) {
            e.preventDefault();
             
            const accountNumber = $('#modal-account-number').val();
            const accountName = $('#modal-account-name').val();
            const bankCode = $('#modal-bankCode').val();
            const amount = $('#modal-amount').val();
            const $button = $('#process-transfer');
            const transactionPin = $('#transactionPin').val();
            const saveAsBeneficiary = $('#saveAsBeneficiary').is(':checked');

            if (!transactionPin) {
                toastr.error('Please enter your transaction PIN', 'Error');
                return;
            }

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
                    entered_pin: transactionPin,
                    user_id: {{ auth()->id() }}
                }),
                success: function(response) {
                    if (response.status === 'success' && response.pin_match) {
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
                                name: accountName,
                                account_number: accountNumber,
                                bank_code: bankCode
                            }),
                            success: function(response) {
                                if (response.status === 'success') {
                                    const recipientCode = response.recipient_code;
                                    
                                    // Save beneficiary if checkbox is checked
                                    if (saveAsBeneficiary) {
                                        saveBeneficiary(accountName, accountNumber, bankCode, $('#bank option:selected').text(), recipientCode);
                                    }

                                    // Step 3: Initiate Transfer
                                    initiateTransfer(accountName, accountNumber, bankCode, recipientCode, amount, $button);
                                } else {
                                    toastr.error('Recipient creation failed: '+ response.message, 'Error');
                                    resetButtonState($button);
                                }
                            },
                            error: function() {
                                toastr.error('An error occurred while creating the recipient.', 'Error');
                                resetButtonState($button);
                            }
                        });
                    } else {
                        toastr.error('The PIN you entered is incorrect.', 'PIN Mismatch');
                        resetButtonState($button);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while verifying PIN. Please try again.', 'Error');
                    resetButtonState($button);
                }
            });
        });

        function saveBeneficiary(accountName, accountNumber, bankCode, bankName, recipientCode) {
            $.ajax({
                url: "{{ route('user.wallet.saveBeneficiary') }}",
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({
                    account_name: accountName,
                    account_number: accountNumber,
                    bank_code: bankCode,
                    bank_name: bankName,
                    recipient_code: recipientCode
                }),
                success: function(response) {
                    if (response.status === 'success') {
                        // Refresh beneficiary dropdown
                        loadBeneficiaries();
                    }
                },
                error: function(error) {
                    console.error('Error saving beneficiary:', error);
                }
            });
        }

        function initiateTransfer(accountName, accountNumber, bankCode, recipientCode, amount, $button) {
            $.ajax({
                url: "{{ route('user.wallet.initiateTransfer') }}",
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }, 
                data: JSON.stringify({
                    name: accountName, 
                    account_number: accountNumber,
                    bank_code: bankCode,
                    recipient_code: recipientCode,
                    amount: amount,
                    reason: 'Payment', 
                    transfer_reference: generateUUID()
                }), 
                success: function(response) {
                    if (response.status === 'success') {
                        // Show success modal
                        $('#modaladdcontact').modal('hide');
                        $('body').append(`
                            <div class="modal fade" id="transferSuccessModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-success">Transfer Successful</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <svg width="60" height="60" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#28a745"/><path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <p class="mt-3 mb-0">The transfer has been completed successfully.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        var modal = new bootstrap.Modal(document.getElementById('transferSuccessModal'));
                        modal.show();
                        setTimeout(() => { 
                            window.location.href = response.redirect_url || "{{ route('user.transactions') }}";
                        }, 2000);
                    } else {
                        toastr.error('Transfer failed: ' + response.message, 'Error');
                    }
                },
                error: function() {
                    toastr.error('An error occurred during the transfer process.', 'Error');
                },
                complete: function() {
                    resetButtonState($button);
                }
            });
        }

        function loadBeneficiaries() {
            $.ajax({
                url: "{{ route('user.beneficiaries.index') }}",
                method: "GET",
                success: function(response) {
                    const $select = $('#savedBeneficiaries');
                    $select.empty().append('<option value="">Select a saved beneficiary</option>');
                    
                    response.data.forEach(beneficiary => {
                        $select.append(
                            `<option 
                                value="${beneficiary.id}" 
                                data-account-number="${beneficiary.account_number}"
                                data-bank-code="${beneficiary.bank_code}"
                                data-account-name="${beneficiary.account_name}"
                                data-bank-name="${beneficiary.bank_name}">
                                ${beneficiary.account_name} - ${beneficiary.account_number} (${beneficiary.bank_name})
                            </option>`
                        );
                    });
                }
            });
        }

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

        // Copy referral link function
        function copyReferralLink() {
            const referralLink = document.querySelector('.referral_code').textContent;
            navigator.clipboard.writeText(referralLink).then(() => {
                toastr.success('Referral link copied to clipboard!');
            }).catch(err => {
                toastr.error('Failed to copy referral link');
            });
        }
    });
</script>
@endsection
@extends('layouts.dashboard')

@section('content')
<div class="dashboard__page--wrapper">
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        <main class="main__content_wrapper">
            <div class="dashboard__container setting__container">
                <div class="add__property--heading mb-30">
                    <h2 class="add__property--heading__title">Identity Verification</h2>
                    <p class="add__property--desc">Verify your BVN and NIN separately</p>
                </div>
               
                <div class="setting__page--inner">
                 
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="setting__profile edit-profile">
                               <br/>
                            <div class="col-12">
                                <!-- BVN Verification Section -->
                                <div class="verification-section mb-40">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="setting__profile--title">BVN Verification</h3>
                                        @if(Auth::user()->bvn_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                        @endif
                                    </div>
                                    
                                    @if(!Auth::user()->bvn_verified_at)
                                    <form id="bvnVerificationForm">
                                        @csrf
                                        <div class="add__listing--input__box mb-3">
                                            <label class="add__listing--input__label" for="bvn">Bank Verification Number</label>
                                            <input 
                                                class="add__listing--input__field" 
                                                id="bvn" 
                                                name="bvn" 
                                                placeholder="Enter 11-digit BVN" 
                                                type="text" 
                                                pattern="[0-9]{11}"
                                                maxlength="11"
                                                value="{{ old('bvn') }}"
                                                required>
                                            <small class="text-muted">We'll verify this with your bank</small>
                                            <div id="bvnError" class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="bvn_consent" name="consent" required>
                                            <label class="form-check-label" for="bvn_consent">
                                                I consent to BVN verification
                                            </label>
                                        </div>
                                        
                                        <button type="submit" id="verifyBvnBtn" class="btn btn-primary">
                                            Verify BVN
                                        </button>
                                    </form>
                                    @else
                                        <div class="verified-info">
                                            <p>BVN verified on: {{ Auth::user()->bvn_verified_at->format('M d, Y H:i') }}</p>
                                            <p class="text-muted">Last 4 digits: *******{{ substr(Auth::user()->bvn, -4) }}</p>
                                        </div>
                                    @endif
                                </div>
                                  
                                <!-- NIN Verification Section -->
                                <div class="verification-section">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h3 class="setting__profile--title">NIN Verification</h3>
                                        @if(Auth::user()->nin_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                        @endif
                                    </div>
                                    
                                    @if(!Auth::user()->nin_verified_at)
                                    <form id="ninVerificationForm">
                                        @csrf
                                        <div class="add__listing--input__box mb-3">
                                            <label class="add__listing--input__label" for="nin">National Identity Number</label>
                                            <input 
                                                class="add__listing--input__field" 
                                                id="nin" 
                                                name="nin" 
                                                placeholder="Enter 11-digit NIN" 
                                                type="text" 
                                                pattern="[0-9]{11}"
                                                maxlength="11"
                                                value="{{ old('nin') }}"
                                                required>
                                            <small class="text-muted">We'll verify this with NIMC</small>
                                            <div id="ninError" class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="nin_consent" name="consent" required>
                                            <label class="form-check-label" for="nin_consent">
                                                I consent to NIN verification
                                            </label>
                                        </div>
                                        
                                        <button type="submit" id="verifyNinBtn" class="btn btn-primary">
                                            Verify NIN
                                        </button>
                                    </form>
                                    @else
                                        <div class="verified-info">
                                            <p>NIN verified on: {{ Auth::user()->nin_verified_at->format('M d, Y H:i') }}</p>
                                            <p class="text-muted">Last 4 digits: *******{{ substr(Auth::user()->nin, -4) }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Verification Success Modal -->
                                <div class="modal fade" id="verificationSuccessModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Verification Successful</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Dynamic content will be inserted here -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .verification-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }
    
    .verified-info {
        background: #e8f5e9;
        padding: 15px;
        border-radius: 5px;
        border-left: 4px solid #4caf50;
    }
    
    .badge {
        padding: 8px 12px;
        font-size: 14px;
    }
    
    .verification-details {
        margin-top: 20px;
    }
    
    .detail-row {
        display: flex;
        margin-bottom: 10px;
    }
    
    .detail-label {
        font-weight: bold;
        width: 120px;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<script>
$(document).ready(function() {
    // Format BVN/NIN inputs to only allow numbers
    $('#bvn, #nin').on('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });
    
    // BVN Verification Form Submission
    $('#bvnVerificationForm').on('submit', function(e) {
        e.preventDefault();
        
        const bvn = $('#bvn').val();
        const consent = $('#bvn_consent').is(':checked');
        
        // Clear previous errors
        clearErrors('bvn');
        
        // Validate inputs
        if (!/^\d{11}$/.test(bvn)) {
            showError('bvn', 'BVN must be exactly 11 digits');
            return;
        }
        
        if (!consent) {
            alert('You must consent to BVN verification');
            return;
        }
        
        verifyBvn(bvn);
    });
    
    // NIN Verification Form Submission
    $('#ninVerificationForm').on('submit', function(e) {
        e.preventDefault();
        
        const nin = $('#nin').val();
        const consent = $('#nin_consent').is(':checked');
        
        // Clear previous errors
        clearErrors('nin');
        
        // Validate inputs
        if (!/^\d{11}$/.test(nin)) {
            showError('nin', 'NIN must be exactly 11 digits');
            return;
        }
        
        if (!consent) {
            alert('You must consent to NIN verification');
            return;
        }
        
        verifyNin(nin);
    });

    // Focus management for modal
    $('#verificationSuccessModal').on('shown.bs.modal', function () {
        $(this).find('.btn-secondary').focus();
    });

    $('#verificationSuccessModal').on('hidden.bs.modal', function () {
        $('#verifyBvnBtn, #verifyNinBtn').filter(':visible').focus();
    });
    
    // Function to verify BVN
    function verifyBvn(bvn) {
        $('#verifyBvnBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...');
        
        $.ajax({
            url: '{{ route("verify-bvn") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                bvn: bvn,
                firstname: '{{ Auth::user()->first_name }}',
                lastname: '{{ Auth::user()->last_name }}'
            },
            success: function(response) {
                if (response.status === true && response.data) {
                    const userData = response.data;
                    console.log('BVN Verification Success:', userData);
                    
                    // Build modal content
                    const modalContent = `
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">BVN Verified Successfully</h4>
                        </div>
                        <div class="verification-details">
                            ${buildDetailRow('First Name', userData.firstName || '{{ Auth::user()->first_name }}')}
                            ${userData.middleName ? buildDetailRow('Middle Name', userData.middleName) : ''}
                            ${buildDetailRow('Last Name', userData.lastName || '{{ Auth::user()->last_name }}')}
                            ${userData.dateOfBirth ? buildDetailRow('Date of Birth', userData.dateOfBirth) : ''}
                            ${userData.phoneNumber ? buildDetailRow('Phone Number', userData.phoneNumber) : ''}
                        </div>
                        <div class="mt-3">
                            <button id="updateBvnBtn" class="btn btn-primary">
                                Save BVN to My Profile
                            </button>
                        </div>
                    `;

                    // Update modal and show
                    $('#verificationSuccessModal .modal-body').html(modalContent);
                    var modal = new bootstrap.Modal(document.getElementById('verificationSuccessModal'));
                    modal.show();

                    // Handle BVN update when user clicks the save button
                    $('#updateBvnBtn').on('click', function() {
                        updateBvnInDatabase(bvn, modal);
                    });
                    
                    toastr.success('BVN verification successful!', 'Success');
                } else {
                    handleVerificationError(response, 'bvn');
                }
            },
            error: function(xhr) {
                handleVerificationError(xhr.responseJSON || { message: 'Network error occurred' }, 'bvn');
            },
            complete: function() {
                $('#verifyBvnBtn').prop('disabled', false).html('Verify BVN');
            }
        });
    }

    // Function to update BVN in database
    function updateBvnInDatabase(bvn, modal) {
        $('#updateBvnBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving...');
        
        $.ajax({
            url: '{{ route("user.update-bvn") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                bvn: bvn
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('BVN saved successfully!', 'Success');
                    modal.hide();
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Failed to save BVN', 'Error');
                    $('#updateBvnBtn').prop('disabled', false).html('Save BVN to My Profile');
                }
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Network error occurred';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                }
                toastr.error(errorMessage, 'Error');
                $('#updateBvnBtn').prop('disabled', false).html('Save BVN to My Profile');
            }
        });
    }

    // Function to verify NIN
    function verifyNin(nin) {
        $('#verifyNinBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Verifying...');
        
        $.ajax({
            url: '{{ route("verify-nin") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nin: nin,
                firstname: '{{ Auth::user()->first_name }}',
                lastname: '{{ Auth::user()->last_name }}'
            },
            success: function(response) {
                if (response.success === true || response.status === true) {
                    const userData = response.data;
                    console.log('NIN Verification Success:', userData);
                    
                    if (isDataMasked(userData)) {
                        showSuspendedNinModal();
                        return;
                    }
                    
                    const modalContent = `
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">NIN Verified Successfully</h4>
                        </div>
                        <div class="verification-details">
                            ${buildDetailRow('First Name', userData.firstname || '{{ Auth::user()->first_name }}')}
                            ${userData.middlename ? buildDetailRow('Middle Name', userData.middlename) : ''}
                            ${buildDetailRow('Last Name', userData.surname || '{{ Auth::user()->last_name }}')}
                        </div>
                        <div class="mt-3">
                            <button id="updateNinBtn" class="btn btn-primary">
                                Save NIN to My Profile
                            </button>
                        </div>
                    `;

                    $('#verificationSuccessModal .modal-body').html(modalContent);
                    var modal = new bootstrap.Modal(document.getElementById('verificationSuccessModal'));
                    modal.show();
                    
                    $('#updateNinBtn').on('click', function() {
                        updateNinInDatabase(nin, modal);
                    });
                    
                    toastr.success('NIN verification successful!', 'Success');
                } else {
                    handleVerificationError(response, 'nin');
                }
            },
            error: function(xhr) {
                handleVerificationError(xhr.responseJSON || { message: 'Network error occurred' }, 'nin');
            },
            complete: function() {
                $('#verifyNinBtn').prop('disabled', false).html('Verify NIN');
            }
        });
    }

    // Function to update NIN in database
    function updateNinInDatabase(nin, modal) {
        $('#updateNinBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving...');
        
        $.ajax({
            url: '{{ route("user.update-nin") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nin: nin
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('NIN saved successfully!', 'Success');
                    modal.hide();
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Failed to save NIN', 'Error');
                    $('#updateNinBtn').prop('disabled', false).html('Save NIN to My Profile');
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Network error occurred', 'Error');
                $('#updateNinBtn').prop('disabled', false).html('Save NIN to My Profile');
            }
        });
    }
    
    // Helper function to build detail row
    function buildDetailRow(label, value) {
        return `
            <div class="detail-row">
                <div class="detail-label">${label}:</div>
                <div>${value || 'Not provided'}</div>
            </div>
        `;
    }
    
    // Helper function to check for masked data
    function isDataMasked(data) {
        for (const key in data) {
            if (typeof data[key] === 'string' && data[key].includes('***')) {
                return true;
            }
        }
        return false;
    }
    
    // Helper function to show error
    function showError(field, message) {
        $(`#${field}`).addClass('is-invalid');
        $(`#${field}Error`).text(message).show();
    }
    
    // Helper function to clear errors
    function clearErrors(field) {
        $(`#${field}`).removeClass('is-invalid');
        $(`#${field}Error`).text('').hide();
    }
    
    // Function to handle verification errors
    function handleVerificationError(response, field = null) {
        const errorMessage = response.message || 'Verification failed';
        
        if (field) {
            showError(field, errorMessage);
        }
        
        toastr.error(errorMessage, 'Error');
        
        // Special case for suspended NIN
        if (response.code === 'NIN_SUSPENDED') {
            showSuspendedNinModal();
        }
    }
    
    // Function to show suspended NIN modal
    function showSuspendedNinModal() {
        const modalContent = `
            <div class="text-center mb-4">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                <h4 class="mt-3">NIN Verification Issue</h4>
            </div>
            <div class="alert alert-warning">
                <p>Your NIN appears to be suspended or restricted.</p>
                <p>Please visit the nearest NIMC office to resolve this issue.</p>
            </div>
        `;
        
        $('#verificationSuccessModal .modal-body').html(modalContent);
        var modal = new bootstrap.Modal(document.getElementById('verificationSuccessModal'));
        modal.show();
    }
});
</script>
@endsection
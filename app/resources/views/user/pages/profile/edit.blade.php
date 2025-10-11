@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container setting__container">
                <div class="add__property--heading mb-30">
                    <h2 class="add__property--heading__title">Settings Page</h2>
                    <p class="add__property--desc">We are glad to see you again!</p>
                </div>
               
                    <div class="setting__page--inner ">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="setting__profile edit-profile">
                                <div class="col-8">
                                    <form action="{{ route('user.profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="edit__profile--step">
                                            <h3 class="setting__profile--title">My Profile</h3>
                                            <div class="setting__profile--author d-flex align-items-center">
                                                <div class="setting__profile--author__thumb">
                                                    <img 
                                                        id="profile_image_preview"
                                                        src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) :  asset('assets/admin/img/dashboard/avater.jpg') }}"
                                                        style="border-radius:50px; max-height: 100%; max-width:100%; width:65px; height:65px; object-fit: cover;"
                                                        alt="Profile Image">
                                                </div>
                                                <div class="setting__profile--author__text">
                                                    <h3 class="setting__profile--author__name">Edit your photo</h3>
                                                    <div class="setting__profile--author__btn d-flex">
                                                        <label for="profile_image" class="btn btn-secondary">Upload</label>
                                                        <input type="file" id="profile_image" name="profile_image" style="display: none;" accept="image/*" onchange="previewImage(event)">
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                function previewImage(event) {
                                                    const file = event.target.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = function(e) {
                                                            // Update the profile picture preview
                                                            const profileImagePreview = document.getElementById('profile_image_preview');
                                                            profileImagePreview.src = e.target.result;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                }

                                            </script>
                                            <div class="setting__profile--inner">
                                                <!-- Name Input -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="name">Last name</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="name" 
                                                        name="last_name" 
                                                        placeholder="Last name" 
                                                        type="text" 
                                                        value="{{ old('last_name', Auth::user()->last_name) }}">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="name">First name</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="name" 
                                                        name="first_name" 
                                                        placeholder="First name" 
                                                        type="text" 
                                                        value="{{ old('first_name', Auth::user()->first_name) }}">
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                    
                                                <!-- Email Input -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="email">Email-Address</label>
                                                    <input 
                                                        disabled 
                                                        class="add__listing--input__field" 
                                                        id="email" 
                                                        placeholder="Email-Address" 
                                                        type="email" 
                                                        value="{{ Auth::user()->email }}">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                    
                                                 <!-- BOD Input -->
                                                 <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="dob">Date of Birth</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="dob" 
                                                        name="dob" 
                                                        placeholder="Date of birth" 
                                                        type="date" 
                                                        value="{{ \Carbon\Carbon::parse(Auth::user()->dob)->format('Y-m-d') }}">
                                                    @error('dob')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                

                                                <!-- Phone Input -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="phone">Phone</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="phone" 
                                                        name="phone" 
                                                        placeholder="Phone number" 
                                                        type="tel" 
                                                        value="{{ old('phone', Auth::user()->phone) }}">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                    
                                                <!-- Update Button -->
                                                <button type="submit" class="solid__btn add__property--btn">Update</button>
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
        
       

@endsection 

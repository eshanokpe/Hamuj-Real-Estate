@extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container setting__container">
                <div class="add__property--heading mb-30">
                    <h2 class="add__property--heading__title">Change Password</h2>
                    <p class="add__property--desc">Enter new password, confirm it to update your password</p>
                </div>
               
                    <div class="setting__page--inner ">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger ">
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
                                   

                                    <form action="{{ route('user.change.password.post', Auth::user()->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="edit__profile--step">
                                            <h3 class="setting__profile--title">Change your password</h3>
                                            <div class="setting__profile--inner">
                                                <!-- Old Password -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="old_password">Old Password</label>
                                                    <input 
                                                        class="add__listing--input__field w-100" 
                                                        id="old_password" 
                                                        name="old_password" 
                                                        placeholder="Old Password" 
                                                        type="password" 
                                                        required>
                                                </div>
                                                <!-- New Password -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="new_password">New Password</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="new_password" 
                                                        name="new_password" 
                                                        placeholder="New Password" 
                                                        type="password" 
                                                        required>
                                                </div>
                                                <!-- Confirm New Password -->
                                                <div class="add__listing--input__box mb-20">
                                                    <label class="add__listing--input__label" for="confirm_password">Confirm New Password</label>
                                                    <input 
                                                        class="add__listing--input__field" 
                                                        id="new_password_confirmation" 
                                                        name="new_password_confirmation" 
                                                        placeholder="Confirm New Password" 
                                                        type="password" 
                                                        required>
                                                </div>
                                                <!-- Submit Button -->
                                                <button type="submit" class="solid__btn add__property--btn">Change Password</button>
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

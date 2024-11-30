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
                                    <div class="edit__profile--step">
                                        <h3 class="setting__profile--title">My Profile</h3>
                                        <div class="setting__profile--author d-flex align-items-center">
                                            <div class="setting__profile--author__thumb">
                                                <img 
                                                src="{{ Auth::user()->profile_image ? asset('storage/'.$user->profile_image) : asset('assets/admin/img/dashboard/avater.jpg') }}"
                                                style="border-radius:50px; max-height: 100%; max-width:100%; width:59px; height:59px;  object-fit: cover;"
                                                alt="img">
                                            </div>
                                            <div class="setting__profile--author__text">
                                                <h3 class="setting__profile--author__name">Edit your photo</h3>
                                                <div class="setting__profile--author__btn d-flex">
                                                    <button class="delete">Delete</button>
                                                    <button class="update">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="setting__profile--inner">
                                           
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="email">Name</label>
                                                <input class="add__listing--input__field" id="name" name="name" placeholder="Name" type="email" value="{{ Auth::user()->name}}">
                                             </div>
                                             <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="email">Email-Address</label>
                                                <input disabled class="add__listing--input__field" id="email" placeholder="Email-Address" type="email" value="{{ Auth::user()->email}}">
                                             </div>
                                            <div class="add__listing--input__box mb-20">
                                                <label class="add__listing--input__label" for="website">Phone</label>
                                                <input class="add__listing--input__field" name="phone" id="website" placeholder="Phone number" type="tel" value="{{ Auth::user()->phone}}">
                                            </div>
                                            <button class="solid__btn add__property--btn">Update</button>
                                        </div>
                                    </div>
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

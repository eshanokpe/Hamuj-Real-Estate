
  <!-- Start footer section -->
  <footer class="footer footer__section ">
    <div class="container">
        
        <div class="main__footer footer__wrapper color-offwhite">
            <div class="row ">
                <div class="col-xl-4 col-lg-5 col-md-6">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title about">About <button class="footer__widget--button" aria-label="footer widget button"></button>
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </h2> 
                        <div class="footer__widget--inner">
                            <div class="footer__logo" >
                                <a class="footer__logo--link display-block" href="{{ url('/') }}" style="background-color: #fff; padding:8px; margin-right:50%; object-fit: cover;">
                                    <img class="footer__logo--img" src="{{ asset($contactDetials->site_logo) }}" alt="l{{ $contactDetials->company_name }}" style="object-fit: cover; width: 171px; height: 30px;">
                                </a>
                            </div>
                            <p class="footer__widget--desc" style="color: #fff">
                                {!! Str::limit($about->content, 160 )!!}
                            </p>
                            <a class="blog__link--btn" href="{{ route('home.pages','about') }}">
                                Read More 
                            </a>
                            <ul class="footer__widget--info">
                                <li class="footer__widget--info_list">
                                    <svg class="footer__widget--info__icon" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.3641 0C6.97117 0 3.39868 3.86831 3.39868 8.625C3.39868 14.6036 10.5888 22.4581 10.8941 22.7901C11.0242 22.9296 11.1942 23 11.3641 23C11.534 23 11.704 22.9296 11.8341 22.7901C12.1394 22.4581 19.3295 14.6036 19.3295 8.625C19.3295 3.86831 15.757 0 11.3641 0ZM11.3641 21.2419C9.77898 19.4048 4.72625 13.1919 4.72625 8.625C4.72625 4.66181 7.70399 1.4375 11.3641 1.4375C15.0242 1.4375 18.002 4.66181 18.002 8.625C18.002 13.1876 12.9492 19.4048 11.3641 21.2419Z" fill="#fff"/>
                                        <path d="M11.3638 4.3125C9.16801 4.3125 7.3811 6.24737 7.3811 8.625C7.3811 11.0026 9.16801 12.9375 11.3638 12.9375C13.5596 12.9375 15.3465 11.0026 15.3465 8.625C15.3465 6.24737 13.5596 4.3125 11.3638 4.3125ZM11.3638 11.5C9.8995 11.5 8.70867 10.2106 8.70867 8.625C8.70867 7.03944 9.8995 5.75 11.3638 5.75C12.8281 5.75 14.019 7.03944 14.019 8.625C14.019 10.2106 12.8281 11.5 11.3638 11.5Z" fill="#fff"/>
                                    </svg>
                                    <p class="footer__widget--info__text"> {{$contactDetials->first_address}} </p>
                                </li>
                                <li class="footer__widget--info_list">                                     
                                    <svg class="footer__widget--info__icon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#fff" d="M2.51763 19.6352C2.20325 19.6334 1.90222 19.4974 1.67992 19.2567C1.45762 19.016 1.33199 18.69 1.33032 18.3496V7.77586C1.332 7.07078 1.59142 6.39509 2.05186 5.89652C2.5123 5.39795 3.13632 5.11705 3.78748 5.11523H15.3749C16.0271 5.11523 16.6528 5.39533 17.1146 5.89409C17.5764 6.39286 17.8367 7.06959 17.8384 7.77586V14.8227C17.8384 15.529 17.5797 16.2065 17.1191 16.7065C16.6584 17.2066 16.0335 17.4884 15.3812 17.4902H5.71765C5.6079 17.4912 5.50123 17.5297 5.41289 17.6002L3.2351 19.3809C3.02744 19.547 2.77583 19.6362 2.51763 19.6352ZM3.78748 6.49023C3.4731 6.49204 3.17207 6.62807 2.94977 6.86878C2.72747 7.10949 2.60184 7.43545 2.60017 7.77586V18.1777L4.65098 16.5002C4.95955 16.2521 5.33329 16.1172 5.71765 16.1152H15.3749C15.6914 16.1152 15.995 15.9791 16.2189 15.7367C16.4428 15.4943 16.5685 15.1655 16.5685 14.8227V7.77586C16.5669 7.43545 16.4412 7.10949 16.2189 6.86878C15.9966 6.62807 15.6956 6.49204 15.3812 6.49023H3.78748Z" fill="currentColor"/>
                                        <path fill="#fff" d="M12.0855 12.0522C12.436 12.0522 12.7202 11.7444 12.7202 11.3647C12.7202 10.9851 12.436 10.6772 12.0855 10.6772C11.7351 10.6772 11.4509 10.9851 11.4509 11.3647C11.4509 11.7444 11.7351 12.0522 12.0855 12.0522Z" fill="currentColor"/>
                                        <path fill="#fff" d="M9.62168 12.0522C9.97216 12.0522 10.2563 11.7444 10.2563 11.3647C10.2563 10.9851 9.97216 10.6772 9.62168 10.6772C9.27119 10.6772 8.98706 10.9851 8.98706 11.3647C8.98706 11.7444 9.27119 12.0522 9.62168 12.0522Z" fill="currentColor"/>
                                        <path fill="#fff" d="M7.08237 12.0522C7.43286 12.0522 7.71698 11.7444 7.71698 11.3647C7.71698 10.9851 7.43286 10.6772 7.08237 10.6772C6.73188 10.6772 6.44775 10.9851 6.44775 11.3647C6.44775 11.7444 6.73188 12.0522 7.08237 12.0522Z" fill="currentColor"/>
                                        <path fill="#fff" d="M19.7433 12.6777C19.5749 12.6777 19.4134 12.6053 19.2944 12.4764C19.1753 12.3474 19.1084 12.1726 19.1084 11.9902V5.02586C19.1067 4.68545 18.9811 4.35949 18.7588 4.11878C18.5365 3.87807 18.2355 3.74204 17.9211 3.74023H5.14005C4.97166 3.74023 4.81016 3.6678 4.69109 3.53887C4.57202 3.40994 4.50513 3.23507 4.50513 3.05273C4.50513 2.8704 4.57202 2.69553 4.69109 2.5666C4.81016 2.43767 4.97166 2.36523 5.14005 2.36523H17.9211C18.5723 2.36705 19.1963 2.64795 19.6567 3.14652C20.1172 3.64509 20.3766 4.32078 20.3782 5.02586V11.9902C20.3782 12.1726 20.3114 12.3474 20.1923 12.4764C20.0732 12.6053 19.9117 12.6777 19.7433 12.6777Z" fill="currentColor"/>
                                    </svg>
                                    <a class="footer__widget--info__text" href="#">
                                        {{$contactDetials->first_email}} 
                                        @if( $contactDetials->second_email == null)
                                        , {{$contactDetials->second_email}}
                                        @endif
                                    </a>
                                </li>
                                <li class="footer__widget--info_list"> 
                                    <svg class="footer__widget--info__icon" width="20" height="20" viewBox="0 0 20 20" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#fff" d="M13.31 1.52371L18.6133 2.11296C18.6133 2.11296 19.2026 7.41627 13.31 13.3088C7.41748 19.2014 2.11303 18.6133 2.11303 18.6133L1.52377 13.31L5.64971 10.9529L7.71153 13.0148C7.71153 13.0148 9.18467 12.7201 10.9524 10.9524C12.7202 9.18461 13.0148 7.71147 13.0148 7.71147L10.953 5.64965L13.31 1.52371Z" stroke="" stroke-width="2"></path>
                                    </svg>
                                    <a class="footer__widget--info__text" href="#">
                                          {{$contactDetials->first_phone}}  
                                         @if( $contactDetials->second_phone == null)
                                        , {{$contactDetials->second_phone}}
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-2 col-lg-3 col-md-3">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title ">Services <button class="footer__widget--button" aria-label="footer widget button"></button>
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </h2>
                        <ul class="footer__widget--menu footer__widget--inner">
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="./listing.html">Property on sale</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="./listing.html">Offices for Buy</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="./listing.html">Terms of use</a></li>
                        </ul>
                    </div>
                </div> --}}
                <div class="col-xl-2 col-lg-3 col-md-3">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title ">Contact <button class="footer__widget--button" aria-label="footer widget button"></button>
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </h2>
                        <ul class="footer__widget--menu footer__widget--inner">
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('home.pages','faqs') }}">Help/FAQ</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('home.pages','contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-3">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title ">Quick Links <button class="footer__widget--button" aria-label="footer widget button"></button>
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </h2>
                        <ul class="footer__widget--menu footer__widget--inner">
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('home.pages','about')}}">About</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('home.pages','blog') }}">Blog</a></li>
                            <li class="footer__widget--menu__list"><a class="footer__widget--menu__text" href="{{ route('home.pages','properties') }}">Properties</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-5 col-md-6">
                    <div class="footer__widget">
                        <h2 class="footer__widget--title ">Newsletter <button class="footer__widget--button" aria-label="footer widget button"></button>
                            <svg class="footer__widget--title__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                            </svg>
                        </h2>
                        <div class="footer__widget--inner newsletter">
                            <div class="newsletter__subscribe">
                                <form class="newsletter__subscribe--form" action="#">
                                    <label>
                                        <input class="newsletter__subscribe--input" placeholder=" Enter Email Adress" type="text">   
                                    </label>
                                    <button class="newsletter__subscribe--button" type="submit">Subscribe</button>
                                </form>   
                            </div> 
                            <p class="email__except">
                                <label class="email__except--label" for="except">I agree to all terms and policies</label>
                                <input class="email__except--check__input" id="except" type="checkbox">
                                <span class="email__except--checkmark"></span>
                            </p>
                            <ul class=" footer__social d-flex align-items-center">
                                <li class="footer__social--list">
                                    <a class="footer__social--icon" target="_blank" href="{{$sociallink->facebook}}">
                                        <svg width="10" height="17" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.62891 8.625L8.01172 6.10938H5.57812V4.46875C5.57812 3.75781 5.90625 3.10156 7 3.10156H8.12109V0.941406C8.12109 0.941406 7.10938 0.75 6.15234 0.75C4.15625 0.75 2.84375 1.98047 2.84375 4.16797V6.10938H0.601562V8.625H2.84375V14.75H5.57812V8.625H7.62891Z" fill="currentColor"></path>
                                        </svg>
                                        <span class="visually-hidden">Facebook</span>
                                    </a>
                                </li>
                                <li class="footer__social--list">
                                    <a class="footer__social--icon" target="_blank" href="{{$sociallink->twitter}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"></path>
                                          </svg>
                                        <span class="visually-hidden">Twitter</span>
                                    </a>
                                </li>
                                <li class="footer__social--list">
                                    <a class="footer__social--icon" target="_blank" href="{{$sociallink->instagram}}">
                                        <svg width="16" height="16" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.125 3.60547C5.375 3.60547 3.98047 5.02734 3.98047 6.75C3.98047 8.5 5.375 9.89453 7.125 9.89453C8.84766 9.89453 10.2695 8.5 10.2695 6.75C10.2695 5.02734 8.84766 3.60547 7.125 3.60547ZM7.125 8.80078C6.00391 8.80078 5.07422 7.89844 5.07422 6.75C5.07422 5.62891 5.97656 4.72656 7.125 4.72656C8.24609 4.72656 9.14844 5.62891 9.14844 6.75C9.14844 7.89844 8.24609 8.80078 7.125 8.80078ZM11.1172 3.49609C11.1172 3.08594 10.7891 2.75781 10.3789 2.75781C9.96875 2.75781 9.64062 3.08594 9.64062 3.49609C9.64062 3.90625 9.96875 4.23438 10.3789 4.23438C10.7891 4.23438 11.1172 3.90625 11.1172 3.49609ZM13.1953 4.23438C13.1406 3.25 12.9219 2.375 12.2109 1.66406C11.5 0.953125 10.625 0.734375 9.64062 0.679688C8.62891 0.625 5.59375 0.625 4.58203 0.679688C3.59766 0.734375 2.75 0.953125 2.01172 1.66406C1.30078 2.375 1.08203 3.25 1.02734 4.23438C0.972656 5.24609 0.972656 8.28125 1.02734 9.29297C1.08203 10.2773 1.30078 11.125 2.01172 11.8633C2.75 12.5742 3.59766 12.793 4.58203 12.8477C5.59375 12.9023 8.62891 12.9023 9.64062 12.8477C10.625 12.793 11.5 12.5742 12.2109 11.8633C12.9219 11.125 13.1406 10.2773 13.1953 9.29297C13.25 8.28125 13.25 5.24609 13.1953 4.23438ZM11.8828 10.3594C11.6914 10.9062 11.2539 11.3164 10.7344 11.5352C9.91406 11.8633 8 11.7812 7.125 11.7812C6.22266 11.7812 4.30859 11.8633 3.51562 11.5352C2.96875 11.3164 2.55859 10.9062 2.33984 10.3594C2.01172 9.56641 2.09375 7.65234 2.09375 6.75C2.09375 5.875 2.01172 3.96094 2.33984 3.14062C2.55859 2.62109 2.96875 2.21094 3.51562 1.99219C4.30859 1.66406 6.22266 1.74609 7.125 1.74609C8 1.74609 9.91406 1.66406 10.7344 1.99219C11.2539 2.18359 11.6641 2.62109 11.8828 3.14062C12.2109 3.96094 12.1289 5.875 12.1289 6.75C12.1289 7.65234 12.2109 9.56641 11.8828 10.3594Z" fill="currentColor"></path>
                                        </svg>  
                                        <span class="visually-hidden">Instagram</span>
                                    </a>
                                    <li class="footer__social--list">
                                        <a class="social__media--link" target="_blank" href="{{$sociallink->whatsapp}}">
                                            <svg width="20" height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.5 10C18.5 5.71875 15.0312 2.25 10.75 2.25C6.46875 2.25 3 5.71875 3 10C3 13.3125 5.03125 16.0938 7.90625 17.2188C7.84375 16.625 7.78125 15.6875 7.9375 15C8.09375 14.4062 8.84375 11.1562 8.84375 11.1562C8.84375 11.1562 8.625 10.6875 8.625 10C8.625 8.9375 9.25 8.125 10.0312 8.125C10.6875 8.125 11 8.625 11 9.21875C11 9.875 10.5625 10.875 10.3438 11.8125C10.1875 12.5625 10.75 13.1875 11.5 13.1875C12.875 13.1875 13.9375 11.75 13.9375 9.65625C13.9375 7.78125 12.5938 6.5 10.7188 6.5C8.5 6.5 7.21875 8.15625 7.21875 9.84375C7.21875 10.5312 7.46875 11.25 7.78125 11.625C7.84375 11.6875 7.84375 11.7812 7.84375 11.8438C7.78125 12.0938 7.625 12.625 7.625 12.7188C7.59375 12.875 7.5 12.9062 7.34375 12.8438C6.375 12.375 5.78125 10.9688 5.78125 9.8125C5.78125 7.375 7.5625 5.125 10.9062 5.125C13.5938 5.125 15.6875 7.0625 15.6875 9.625C15.6875 12.2812 14 14.4375 11.6562 14.4375C10.875 14.4375 10.125 14.0312 9.875 13.5312C9.875 13.5312 9.5 15.0312 9.40625 15.375C9.21875 16.0625 8.75 16.9062 8.4375 17.4062C9.15625 17.6562 9.9375 17.75 10.75 17.75C15.0312 17.75 18.5 14.2812 18.5 10Z" fill="black"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 22H5.5C4.04133 21.9999 2.64242 21.4205 1.61098 20.389C0.579547 19.3576 6.38127e-05 17.9587 0 16.5L0 5.5C6.38127e-05 4.04133 0.579547 2.64242 1.61098 1.61098C2.64242 0.579547 4.04133 6.38127e-05 5.5 0L16.5 0C17.9587 0 19.3576 0.579463 20.3891 1.61091C21.4205 2.64236 22 4.04131 22 5.5V16.5C22 17.9587 21.4205 19.3576 20.3891 20.3891C19.3576 21.4205 17.9587 22 16.5 22Z" fill="black"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3125 6.1875H16.5C17.2931 6.18745 18.0559 5.88282 18.6309 5.33652C19.2059 4.79021 19.5491 4.04396 19.5897 3.25188C19.6303 2.45979 19.3652 1.68237 18.849 1.08015C18.3329 0.47794 17.6052 0.0969313 16.8163 0.0158125C16.7111 0.00996875 16.6069 0 16.5 0H5.5C4.04133 6.38127e-05 2.64242 0.579547 1.61098 1.61098C0.579547 2.64242 6.38127e-05 4.04133 0 5.5L0 16.5C6.3815e-05 13.765 1.08658 11.142 3.02053 9.20803C4.95449 7.27408 7.57748 6.18757 10.3125 6.1875Z" fill="black"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 11C15.4122 11 14.3488 11.3226 13.4444 11.9269C12.5399 12.5313 11.8349 13.3902 11.4187 14.3952C11.0024 15.4002 10.8935 16.5061 11.1057 17.573C11.3179 18.6399 11.8417 19.6199 12.6109 20.3891C13.3801 21.1583 14.3601 21.6821 15.427 21.8943C16.4939 22.1065 17.5998 21.9976 18.6048 21.5813C19.6098 21.1651 20.4687 20.4601 21.0731 19.5556C21.6774 18.6512 22 17.5878 22 16.5V5.5C22 6.95869 21.4205 8.35764 20.3891 9.38909C19.3576 10.4205 17.9587 11 16.5 11Z" fill="black"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.45011 16.1883C7.54161 16.1623 7.63751 16.1555 7.73176 16.1684C7.82601 16.1813 7.91656 16.2136 7.99771 16.2632C9.36447 17.0775 10.9817 17.3644 12.5451 17.0698C14.1086 16.7753 15.5105 15.9197 16.4874 14.6639C17.4642 13.4082 17.9485 11.8387 17.8492 10.2509C17.75 8.66304 17.074 7.16616 15.9485 6.04178C14.8229 4.91741 13.3253 4.24302 11.7373 4.14547C10.1494 4.04791 8.58047 4.53391 7.32574 5.51206C6.071 6.4902 5.21688 7.89308 4.92402 9.45685C4.63116 11.0206 4.91974 12.6375 5.73549 14.0034C5.78495 14.0843 5.81709 14.1746 5.82987 14.2686C5.84265 14.3625 5.8358 14.4581 5.80974 14.5493C5.61827 15.2268 5.15627 16.8438 5.15627 16.8438C5.15627 16.8438 6.77327 16.3818 7.45011 16.1883ZM4.54405 14.6899C3.56124 13.0332 3.21704 11.0746 3.57607 9.1821C3.9351 7.28956 4.97267 5.59318 6.49394 4.41151C8.01522 3.22984 9.91554 2.64416 11.8381 2.76447C13.7606 2.88477 15.5731 3.70277 16.9352 5.06487C18.2973 6.42697 19.1153 8.23946 19.2356 10.162C19.3559 12.0845 18.7702 13.9849 17.5886 15.5061C16.4069 17.0274 14.7105 18.065 12.818 18.424C10.9254 18.783 8.96692 18.4388 7.31021 17.456C7.31021 17.456 5.11811 18.0823 4.03255 18.3927C3.97358 18.4095 3.91119 18.4102 3.85185 18.3948C3.7925 18.3794 3.73835 18.3484 3.69499 18.3051C3.65164 18.2617 3.62065 18.2076 3.60524 18.1482C3.58983 18.0889 3.59055 18.0265 3.60733 17.9675C3.91774 16.882 4.54405 14.6899 4.54405 14.6899Z" fill="white"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.55649 8.5207C7.66343 10.0599 8.32036 11.5094 9.40733 12.6044C10.4943 13.6995 11.9388 14.3671 13.4772 14.4855H13.4779C13.7235 14.5045 13.9704 14.4701 14.2014 14.3846C14.4325 14.2992 14.6423 14.1647 14.8165 13.9905L15.0564 13.7505C15.1697 13.6372 15.2334 13.4835 15.2335 13.3232V12.8138C15.2334 12.7499 15.2157 12.6873 15.1821 12.633C15.1485 12.5787 15.1005 12.5347 15.0434 12.5061C14.6814 12.3253 13.8956 11.9324 13.5106 11.7399C13.446 11.7076 13.3729 11.6965 13.3017 11.708C13.2304 11.7195 13.1646 11.7532 13.1135 11.8042C12.9217 11.996 12.6185 12.2995 12.4467 12.4711C12.4067 12.5111 12.3574 12.5406 12.3033 12.557C12.2491 12.5735 12.1918 12.5763 12.1363 12.5653L12.1332 12.5646C11.4677 12.4315 10.8565 12.1044 10.3766 11.6245C9.89667 11.1446 9.56956 10.5334 9.43646 9.86786L9.43577 9.86477C9.42474 9.80927 9.42756 9.75191 9.44399 9.69777C9.46042 9.64362 9.48995 9.59437 9.52996 9.55436C9.70149 9.38248 10.005 9.0793 10.1968 8.88748C10.2478 8.83641 10.2815 8.77059 10.293 8.69934C10.3046 8.62809 10.2934 8.55501 10.2611 8.49045C10.0686 8.10545 9.67571 7.31964 9.49489 6.95767C9.46631 6.90056 9.42239 6.85252 9.36805 6.81895C9.31371 6.78538 9.25111 6.76759 9.18724 6.76758H8.75411C8.65126 6.76761 8.54957 6.78923 8.45559 6.83103C8.36162 6.87284 8.27747 6.9339 8.20858 7.01027C8.13949 7.08727 8.06008 7.17527 7.98033 7.26395C7.83024 7.43051 7.71521 7.62558 7.6421 7.83754C7.56899 8.04949 7.53929 8.274 7.55477 8.49767C7.55546 8.50523 7.5558 8.5128 7.55649 8.5207Z" fill="white"/>
                                            </svg>
                                            <span class="visually-hidden">Whatsapp</span>
                                        </a>
                                    </li>
                                    
                                <li class="footer__social--list">
                                    <a class="social__media--link" target="_blank" href="{{$sociallink->youtube}}">
                                        <svg width="20" height="25" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.5673 2.30071C20.3252 1.40109 19.616 0.691976 18.7165 0.449728C17.0732 0 10.4998 0 10.4998 0C10.4998 0 3.92659 0 2.28325 0.432585C1.40109 0.674672 0.674512 1.40125 0.432425 2.30071C0 3.94389 0 7.3517 0 7.3517C0 7.3517 0 10.7767 0.432425 12.4027C0.674672 13.3021 1.38379 14.0114 2.28341 14.2537C3.94389 14.7034 10.5 14.7034 10.5 14.7034C10.5 14.7034 17.0732 14.7034 18.7165 14.2708C19.6161 14.0287 20.3252 13.3195 20.5675 12.42C20.9999 10.7767 20.9999 7.369 20.9999 7.369C20.9999 7.369 21.0172 3.94389 20.5673 2.30071Z" fill="white"/>
                                            <path d="M8.40625 10.4996L13.8724 7.35138L8.40625 4.20312V10.4996Z" fill="black"/>
                                        </svg>
                                        <span class="visually-hidden">Youtube</span>
                                    </a>
                                </li>
                                
                                <li class="footer__social--list">
                                    <a class="footer__social--icon" target="_blank" href="{{$sociallink->linkedin}}">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.938 0C1.318 0 0 1.318 0 2.938c0 1.62 1.318 2.938 2.938 2.938 1.62 0 2.938-1.318 2.938-2.938C5.876 1.318 4.558 0 2.938 0zM.344 15.656h5.188V5.813H.344v9.844zM11.5 5.782c-1.378 0-2.312.751-2.703 1.403V5.813H6.75v9.844h2.047v-4.844c0-1.281.242-2.5 1.875-2.5 1.625 0 1.656 1.406 1.656 2.594v4.75h2.031v-5.344c0-2.563-.547-4.031-3.859-4.031z" fill="currentColor" />
                                        </svg> 
                                        <span class="visually-hidden">LinkedIn</span>
                                    </a>
                                </li>
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom color-offwhite">
        <div class="container">
            <div class="footer__bottom--inner d-flex justify-content-between align-items-center">
                <p class="copyright__content mb-0"><span class="text__secondary">© {{ date('Y') }}</span> Powered By <a class="copyright__content--link" target="_blank" href="#">Dohmayn</a> .  All Rights Reserved.</p>
                
                <ul class="footer__bottom--menu d-flex">
                    <li><a href="{{ route('home.pages','terms-of-use') }}">Terms of Use</a></li>
                    <li><a href="{{ route('home.pages', 'privacy-policy') }}">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- End footer section -->


 <!-- Quickview Wrapper -->
 <div class="modal fade" id="advanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog advance__filter--main--wrapper modal-dialog-centered">
      <div class="modal-content advance__filter--main__content">
        <div class="advance__filter--header d-flex justify-content-between align-items-center">
            <h2 class="advance__filter--header__title">More Filter</h2>
            <button type="button" class="btn-close quickview__close--btn" data-bs-dismiss="modal" aria-label="Close">✕</button>
        </div>
        <div class="modal-body advance__filter--details">
            <div class="advance__price--range modal__price--range">
                <h3 class="advance__price--range__title">Filter By Price</h3>
                <div class="advance__filter--price advance__price--filter">
                    <div class="widget__price--filtering">
                        <div class="price-input">
                            <input type="number" class="input-min" value="2500">
                            <div class="separator">-</div>
                            <input type="number" class="input-max" value="7500">
                        </div>
                        <div class="price-slider">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
                            <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
                        </div>
                        <button class="advance__filter--btn solid__btn">Filter</button>
                    </div>
                </div>
            </div>
            <div class="advance__apeartment--area">
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Type</label>
                    <div class="select">
                        <select class="advance__apeartment--select">
                            <option selected="" value="1">Apartments</option>
                            <option value="2">Office</option>
                            <option value="3">Condo</option>
                            <option value="4">Apartment</option>
                            <option value="5">House</option>
                            <option value="6">Single Family</option>
                            <option value="7">Land</option>
                        </select>
                    </div>
                </div>
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Property ID</label>
                    <input class="advance__apeartment--input__field" placeholder="Th26157096" type="text">
                </div>
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Bedrooms</label>
                    <div class="select">
                        <select class="advance__apeartment--select">
                            <option selected="" value="1">Bedrooms</option>
                            <option value="2">1+</option>
                            <option value="3">2+</option>
                            <option value="4">3+</option>
                            <option value="5">4+</option>
                            <option value="6">5+</option>
                            <option value="7">6+</option>
                        </select>
                    </div>
                </div>
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Bathrooms</label>
                    <div class="select">
                        <select class="advance__apeartment--select">
                            <option selected="" value="1">Bathrooms</option>
                            <option value="2">1+</option>
                            <option value="3">2+</option>
                            <option value="4">3+</option>
                            <option value="5">4+</option>
                            <option value="6">5+</option>
                            <option value="7">6+</option>
                        </select>
                    </div>
                </div>
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Year built</label>
                    <div class="select">
                        <select class="advance__apeartment--select">
                            <option selected="" value="1">Year built</option>
                            <option value="2">2020</option>
                            <option value="3">2021</option>
                            <option value="4">2022</option>
                            <option value="5">2023</option>
                            <option value="6">2024</option>
                            <option value="7">2025</option>
                        </select>
                    </div>
                </div>
                <div class="advance__apeartment--list">
                    <label class="advance__apeartment--label">Location</label>
                    <div class="select">
                        <select class="advance__apeartment--select">
                            <option selected="" value="1">Canada</option>
                            <option value="2">United</option>
                            <option value="3">Adana</option>
                            <option value="4">Antalya</option>
                            <option value="5">Bursa</option>
                            <option value="6">Gaziantep</option>
                            <option value="7">New York</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="interior__amenities--area">
                <h3 class="interior__amenitie--title">Interior Amenities</h3>
                <div class="advance__apeartment--iner d-flex">
                    <ul class="interior__amenities--check">
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check1">Air Conditioning</label>
                            <input class="interior__amenities--check__input" id="check1" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        
                    </ul>
                    <ul class="interior__amenities--check">
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check5">Barbeque</label>
                            <input class="interior__amenities--check__input" id="check5" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check6">Washer</label>
                            <input class="interior__amenities--check__input" id="check6" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check7">Microwave</label>
                            <input class="interior__amenities--check__input" id="check7" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check8">Dryer</label>
                            <input class="interior__amenities--check__input" id="check8" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                    </ul>
                    <ul class="interior__amenities--check">
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check9">TV Cable</label>
                            <input class="interior__amenities--check__input" id="check9" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check10">Refrigerator</label>
                            <input class="interior__amenities--check__input" id="check10" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check11">Laundry</label>
                            <input class="interior__amenities--check__input" id="check11" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check12">Gym</label>
                            <input class="interior__amenities--check__input" id="check12" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                    </ul>
                    <ul class="interior__amenities--check">
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check13">Front yard</label>
                            <input class="interior__amenities--check__input" id="check13" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check14">WiFi</label>
                            <input class="interior__amenities--check__input" id="check14" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check15">Sauna</label>
                            <input class="interior__amenities--check__input" id="check15" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                        <li class="interior__amenities--check__list">
                            <label class="interior__amenities--check__label" for="check16">Wine cellar</label>
                            <input class="interior__amenities--check__input" id="check16" type="checkbox">
                            <span class="interior__amenities--checkmark"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="advance__filter--footer d-flex justify-content-between align-items-center">
                <button class="advance__filter--reset__btn">Reset all filters</button>
                <button class="advance__filter--search__btn solid__btn">Search <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.60519 0C2.96319 0 0 2.96338 0 6.60562C0 10.2481 2.96319 13.2112 6.60519 13.2112C10.2474 13.2112 13.2104 10.2481 13.2104 6.60562C13.2104 2.96338 10.2474 0 6.60519 0ZM6.60519 11.9918C3.6355 11.9918 1.21942 9.57553 1.21942 6.60565C1.21942 3.63576 3.6355 1.2195 6.60519 1.2195C9.57487 1.2195 11.991 3.63573 11.991 6.60562C11.991 9.5755 9.57487 11.9918 6.60519 11.9918Z" fill="white"/>
                    <path d="M14.8206 13.9597L11.325 10.4638C11.0868 10.2256 10.701 10.2256 10.4628 10.4638C10.2246 10.7018 10.2246 11.088 10.4628 11.326L13.9585 14.8219C14.0776 14.941 14.2335 15.0006 14.3896 15.0006C14.5454 15.0006 14.7015 14.941 14.8206 14.8219C15.0588 14.5839 15.0588 14.1977 14.8206 13.9597Z" fill="white"/>
                    </svg>
                </button>   
            </div>
        </div>
      </div>
    </div>
</div>
<!-- Quickview Wrapper End -->

<!-- Scroll top bar -->
{{-- <button id="scroll__top"> 
    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
    <path fill="none" stroke="currentColor" stroke-linecap="round"  stroke-width="48" d="M112 244l144-144 144 144M256 120v292"/></svg>
</button> --}}
   
<!-- All Script JS Plugins here  -->
<script src="{{ asset('assets/js/vendor/popper.js')}}" defer="defer"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.min.js')}}" defer="defer"></script>
<script src="{{ asset('assets/js/plugins/swiper-bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/glightbox.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/aos.js')}}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Customscript js -->
<script src="{{ asset('assets/js/script.js')}}"></script>
<script src="{{ asset('assets/js/chat-widget.js')}}"></script>

<style>
    /* Increase font size of Toastr */
    #toast-container > .toast {
        font-size: 20px; /* You can change 18px to any size you want */
    } 
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000",
            "positionClass": "toast-top-right"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        @if(session('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if($errors->any()) 
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });
</script> 
{{-- https://risingtheme.com/html/demo-newvilla/newvilla/contact.html --}}



 @extends('layouts.dashboard')


@section('content')

 
<div class="dashboard__page--wrapper">
    <!-- Dashboard sidebar .\ -->
    <div class="page__body--wrapper" id="dashbody__page--body__wrapper">
        
        <main class="main__content_wrapper">
            <!-- dashboard container -->
            <div class="dashboard__container dashboard__profile--container">
                <div class="profile__heading mb-30">
                    <h2 class="profile__heading--title">My Profile</h2>
                    <p class="profile__heading--desc">We are glad to see you again!</p>
                </div>
                <div class="dashboard__profile--wrapper">
                    <div class="profile__sticky--thumbnail position-relative">
                        <img src="{{ asset('/assets/admin/img/dashboard/profile-sticky-thumbpng.png')}}" alt="">
                        <a class="profile__edit--btn" href="{{ route('user.profile.edit', encrypt(Auth::user()->id) ) }}"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_222_1260)">
                            <path d="M6.47428 2.24498L5.97601 1.68443V1.68443L6.47428 2.24498ZM11.5257 2.24498L12.024 1.68443V1.68443L11.5257 2.24498ZM11.3639 2.10115L10.8656 2.6617L11.3639 2.10115ZM6.6361 2.10115L7.13437 2.6617V2.6617L6.6361 2.10115ZM3.04581 15.7837L3.48664 15.177L3.04581 15.7837ZM2.21619 14.9541L2.82295 14.5133L2.21619 14.9541ZM15.7838 14.9541L15.1771 14.5133L15.7838 14.9541ZM14.9542 15.7837L14.5134 15.177L14.9542 15.7837ZM15.75 5.9886V9.7499H17.25V5.9886H15.75ZM9.75 15.7499H8.25V17.2499H9.75V15.7499ZM2.25 9.7499V5.9886H0.75V9.7499H2.25ZM10.8656 2.6617L11.0274 2.80554L12.024 1.68443L11.8622 1.54059L10.8656 2.6617ZM6.97255 2.80554L7.13437 2.6617L6.13783 1.54059L5.97601 1.68443L6.97255 2.80554ZM4.4887 3.7499C5.40436 3.7499 6.28818 3.41387 6.97256 2.80554L5.97601 1.68443C5.56621 2.04869 5.03699 2.2499 4.4887 2.2499V3.7499ZM11.0274 2.80554C11.7118 3.41387 12.5956 3.7499 13.5113 3.7499V2.2499C12.963 2.2499 12.4338 2.04869 12.024 1.68443L11.0274 2.80554ZM11.8622 1.54059C10.2299 0.0896604 7.77012 0.0896602 6.13783 1.54059L7.13437 2.6617C8.19834 1.71596 9.80166 1.71596 10.8656 2.6617L11.8622 1.54059ZM8.25 15.7499C6.82714 15.7499 5.82025 15.7489 5.04373 15.6647C4.28125 15.5821 3.83036 15.4267 3.48664 15.177L2.60497 16.3905C3.247 16.8569 3.99205 17.0596 4.88216 17.156C5.75823 17.2509 6.86056 17.2499 8.25 17.2499V15.7499ZM0.75 9.7499C0.75 11.1393 0.748971 12.2417 0.843887 13.1177C0.940324 14.0078 1.14296 14.7529 1.60942 15.3949L2.82295 14.5133C2.57323 14.1695 2.41777 13.7187 2.33516 12.9562C2.25103 12.1797 2.25 11.1728 2.25 9.7499H0.75ZM3.48664 15.177C3.23196 14.9919 3.00799 14.7679 2.82295 14.5133L1.60942 15.3949C1.88698 15.777 2.22294 16.1129 2.60497 16.3905L3.48664 15.177ZM15.75 9.7499C15.75 11.1728 15.749 12.1797 15.6648 12.9562C15.5822 13.7187 15.4268 14.1695 15.1771 14.5133L16.3906 15.3949C16.857 14.7529 17.0597 14.0078 17.1561 13.1177C17.251 12.2417 17.25 11.1393 17.25 9.7499H15.75ZM9.75 17.2499C11.1394 17.2499 12.2418 17.2509 13.1178 17.156C14.0079 17.0596 14.753 16.8569 15.395 16.3905L14.5134 15.177C14.1696 15.4267 13.7188 15.5821 12.9563 15.6647C12.1798 15.7489 11.1729 15.7499 9.75 15.7499V17.2499ZM15.1771 14.5133C14.992 14.7679 14.768 14.9919 14.5134 15.177L15.395 16.3905C15.7771 16.1129 16.113 15.777 16.3906 15.3949L15.1771 14.5133ZM17.25 5.9886C17.25 3.92377 15.5761 2.2499 13.5113 2.2499V3.7499C14.7477 3.7499 15.75 4.7522 15.75 5.9886H17.25ZM2.25 5.9886C2.25 4.7522 3.2523 3.7499 4.4887 3.7499V2.2499C2.42387 2.2499 0.75 3.92377 0.75 5.9886H2.25ZM5.25 9.7499C5.25 11.821 6.92893 13.4999 9 13.4999V11.9999C7.75736 11.9999 6.75 10.9925 6.75 9.7499H5.25ZM9 13.4999C11.0711 13.4999 12.75 11.821 12.75 9.7499H11.25C11.25 10.9925 10.2426 11.9999 9 11.9999V13.4999ZM12.75 9.7499C12.75 7.67883 11.0711 5.9999 9 5.9999V7.4999C10.2426 7.4999 11.25 8.50726 11.25 9.7499H12.75ZM9 5.9999C6.92893 5.9999 5.25 7.67883 5.25 9.7499H6.75C6.75 8.50726 7.75736 7.4999 9 7.4999V5.9999Z" fill="currentColor"></path>
                            <path d="M12.75 6C12.75 6.41421 13.0858 6.75 13.5 6.75C13.9142 6.75 14.25 6.41421 14.25 6C14.25 5.58579 13.9142 5.25 13.5 5.25C13.0858 5.25 12.75 5.58579 12.75 6Z" fill="currentColor"></path>
                            </g>
                            <defs>
                            <clipPath id="clip0_222_1260">
                            <rect width="18" height="18" fill="currentColor"></rect>
                            </clipPath>
                            </defs>
                            </svg>
                             Edit</a>
                    </div>
                    <div class="profile__main--content d-flex justify-content-between align-items-center">
                        <div class="profile__author d-flex align-items-center">
                            <div class="profile__author--thumbnail position-relative">
                                <img 
                                src="{{ Auth::user()->profile_image ? asset('storage/'.$user->profile_image) : asset('assets/admin/img/dashboard/avater.jpg') }}" 
                                alt="img"
                                style="max-height: 100%; max-height:100%; object-fit:cover; width:198px; height:187px"
                                >
                                <a class="profile__author--instagram__icon" href="https://www.instagram.com" target="_blank"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_222_1256)">
                                    <path d="M5.39524 1.87078L5.06305 1.49707L5.06305 1.49707L5.39524 1.87078ZM9.60476 1.87078L9.93695 1.49707V1.49707L9.60476 1.87078ZM9.46992 1.75091L9.13774 2.12462V2.12462L9.46992 1.75091ZM5.53008 1.75091L5.86226 2.12462V2.12462L5.53008 1.75091ZM2.53817 13.1531L2.83206 12.7485L2.53817 13.1531ZM1.84682 12.4617L2.25133 12.1678L1.84682 12.4617ZM13.1532 12.4617L12.7487 12.1678L13.1532 12.4617ZM12.4618 13.1531L12.1679 12.7485L12.4618 13.1531ZM13.25 4.99046V8.12488H14.25V4.99046H13.25ZM8.125 13.2499H6.875V14.2499H8.125V13.2499ZM1.75 8.12488V4.99046H0.75V8.12488H1.75ZM9.13774 2.12462L9.27258 2.24448L9.93695 1.49707L9.8021 1.37721L9.13774 2.12462ZM5.72742 2.24448L5.86226 2.12462L5.1979 1.37721L5.06305 1.49707L5.72742 2.24448ZM3.74058 2.99988C4.47302 2.99988 5.17999 2.73109 5.72742 2.24448L5.06305 1.49707C4.69867 1.82097 4.2281 1.99988 3.74058 1.99988V2.99988ZM9.27258 2.24448C9.82001 2.73109 10.527 2.99988 11.2594 2.99988V1.99988C10.7719 1.99988 10.3013 1.82097 9.93695 1.49707L9.27258 2.24448ZM9.8021 1.37721C8.48921 0.210201 6.51079 0.210201 5.1979 1.37721L5.86226 2.12462C6.79626 1.2944 8.20374 1.2944 9.13774 2.12462L9.8021 1.37721ZM6.875 13.2499C5.69207 13.2499 4.84504 13.2492 4.18964 13.1782C3.54361 13.1082 3.14335 12.9747 2.83206 12.7485L2.24428 13.5576C2.75445 13.9282 3.35081 14.0932 4.08193 14.1724C4.80369 14.2506 5.71435 14.2499 6.875 14.2499V13.2499ZM0.75 8.12488C0.75 9.28553 0.749314 10.1962 0.827512 10.9179C0.906724 11.6491 1.07166 12.2454 1.44231 12.7556L2.25133 12.1678C2.02517 11.8565 1.89169 11.4563 1.82169 10.8102C1.75069 10.1548 1.75 9.30781 1.75 8.12488H0.75ZM2.83206 12.7485C2.60922 12.5866 2.41324 12.3907 2.25133 12.1678L1.44231 12.7556C1.6659 13.0633 1.93654 13.334 2.24428 13.5576L2.83206 12.7485ZM13.25 8.12488C13.25 9.30781 13.2493 10.1548 13.1783 10.8102C13.1083 11.4563 12.9748 11.8565 12.7487 12.1678L13.5577 12.7556C13.9283 12.2454 14.0933 11.6491 14.1725 10.9179C14.2507 10.1962 14.25 9.28553 14.25 8.12488H13.25ZM8.125 14.2499C9.28565 14.2499 10.1963 14.2506 10.9181 14.1724C11.6492 14.0932 12.2456 13.9282 12.7557 13.5576L12.1679 12.7485C11.8566 12.9747 11.4564 13.1082 10.8104 13.1782C10.155 13.2492 9.30793 13.2499 8.125 13.2499V14.2499ZM12.7487 12.1678C12.5868 12.3907 12.3908 12.5866 12.1679 12.7485L12.7557 13.5576C13.0635 13.334 13.3341 13.0633 13.5577 12.7556L12.7487 12.1678ZM14.25 4.99046C14.25 3.33881 12.9111 1.99988 11.2594 1.99988V2.99988C12.3588 2.99988 13.25 3.89109 13.25 4.99046H14.25ZM1.75 4.99046C1.75 3.89109 2.64121 2.99988 3.74058 2.99988V1.99988C2.08893 1.99988 0.75 3.33881 0.75 4.99046H1.75ZM4.5 8.12488C4.5 9.78173 5.84315 11.1249 7.5 11.1249V10.1249C6.39543 10.1249 5.5 9.22945 5.5 8.12488H4.5ZM7.5 11.1249C9.15685 11.1249 10.5 9.78173 10.5 8.12488H9.5C9.5 9.22945 8.60457 10.1249 7.5 10.1249V11.1249ZM10.5 8.12488C10.5 6.46802 9.15685 5.12488 7.5 5.12488V6.12488C8.60457 6.12488 9.5 7.02031 9.5 8.12488H10.5ZM7.5 5.12488C5.84315 5.12488 4.5 6.46802 4.5 8.12488H5.5C5.5 7.02031 6.39543 6.12488 7.5 6.12488V5.12488Z" fill="currentColor"></path>
                                    <path d="M10.625 5C10.625 5.34518 10.9048 5.625 11.25 5.625C11.5952 5.625 11.875 5.34518 11.875 5C11.875 4.65482 11.5952 4.375 11.25 4.375C10.9048 4.375 10.625 4.65482 10.625 5Z" fill="currentColor"></path>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_222_1256">
                                    <rect width="15" height="15" fill="currentColor"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                </a>
                            </div>
                            <div class="profile__author--content">
                                <h3 class="profile__author--title">{{Auth::user()->name}}</h3>
                                {{-- <span class="profile__author--subtitle">Ui/Ux Designer</span> --}}
                            </div>
                        </div>
                        <div class="profile__info d-flex">
                            <ul class="profile__info--wrapper">
                                <li class="profile__info--list">
                                    <h3 class="profile__info--title">EMAIL</h3>
                                    <a class="profile__info__text" href="#">{{Auth::user()->email}}</a>
                                </li>
                                <li class="profile__info--list">
                                    <h3 class="profile__info--title">PHONE</h3>
                                    <a class="profile__info__text" href="tel:+1234567898"> {{Auth::user()->phone}}</a>
                                </li>
                            </ul>
                            <ul class="profile__info--wrapper">
                                <li class="profile__info--list">
                                    <h3 class="profile__info--title">BIRTHDAY</h3>
                                    <span class="profile__info__text">20 August</span>
                                </li>
                                <li class="profile__info--list">
                                    <h3 class="profile__info--title">LOCATION</h3>
                                    <span class="profile__info__text">{{Auth::user()->location}}</span>
                                </li>
                            </ul>
                        </div>
                       
                    </div>
                   
                </div>
            </div>
            <!-- dashboard container .\ -->
        
        
        
          
        </main>

    </div>
</div>
        
       

@endsection 
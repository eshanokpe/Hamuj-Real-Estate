<div>
    <div class="container py-5 mt-50">
        @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-md-8">
                <h3 class="mb-4">Shopping Cart</h3>
                <p class="mb-4"> {{ $itemCount }} {{ $itemCount == 1 ? 'course' : 'courses' }} in Cart</p>
                @if(session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item['image'])
                                                    <img src="{{ Storage::url($item['image']) }}" 
                                                        alt="{{ $item['name'] }}" 
                                                        class="img-thumbnail me-3 rounded-3" 
                                                        style="width: 218px; height: 176px; object-fit: cover; ">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center me-3 rounded-2"
                                                        style="width: 218px; height: 176px;">
                                                        <i class="fas fa-book text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0 fw-medium" >{{ $item['name'] }}</h6>
                                                    <!-- Course Description -->
                                                    <p class="course-description mb-1" style="font-weight: 300; font-size: 14px; color: #6c757d;">
                                                        {{ Str::limit($item['short_description'], 130) }}
                                                    </p>
                                                        <!-- Rating -->
                                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                                        <div class="me-2" style="color: #FCD53F;">
                                                            @php
                                                                $avgRating = $item['reviews_avg_rating'] ?? 0;
                                                                $fullStars = floor($avgRating);
                                                                $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                                            @endphp
                                                            
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $fullStars)
                                                                    <i class="fas fa-star fa-xs me-0" aria-hidden="true"></i>
                                                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                                    <i class="fas fa-star-half-alt fa-xs me-0" aria-hidden="true"></i>
                                                                @else
                                                                    <i class="far fa-star fa-xs me-0" aria-hidden="true"></i>
                                                                @endif
                                                            @endfor
                                                            
                                                            <small class="text-muted " style="font-size: 12px">
                                                                ({{ number_format($avgRating, 1) }})
                                                            </small>
                                                        </div>
                                                        <p class="fw-medium">${{ number_format($item['price'], 2) }}</p>
                                                    </div>
                                                    {{-- @if($item['slug'])
                                                        <small class="text-muted">
                                                            <a href="{{ route('learner.courses.show', $item['slug']) }}" 
                                                            class="text-decoration-none">
                                                                View Course
                                                            </a>
                                                        </small>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td>${{ number_format($item['price'], 2) }}</td> --}}
                                        
                                        <td>
                                            <a href="javascript:void(0)"
                                            wire:click="removeFromCart({{ $item['id'] }})"
                                            wire:loading.attr="aria-disabled"
                                            class="text-danger "
                                            style="cursor: pointer; text-decoration: underline;">
                                                
                                                <span wire:loading.remove wire:target="removeFromCart({{ $item['id'] }})">
                                                    Remove
                                                </span>

                                                <span wire:loading wire:target="removeFromCart({{ $item['id'] }})">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
                                            </a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <button wire:click="clearCart" 
                                        wire:confirm="Are you sure you want to clear your cart?"
                                        class="btn btn-outline-secondary me-2  rounded-0">
                                    Clear Cart
                                </button>
                                <a href="{{ route('learner.dashboard') }}" class="btn btn-outline-primary rounded-0">
                                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            @if(count($cartItems) > 0)
            <!-- Cart Summary -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($subTotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax:</span>
                            <span>$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span class="fw-semibold fs-4 ">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                        <div class=" m-4">
                        <div>
                            <a href="{{ route('learner.checkout') }}" class="theme-btn style-one btn-lg w-100 rounded-0 text-white">
                                Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @endif
            
        </div>
        @else
         <div class="text-center py-5">
            <img src="{{ asset('assets/images/empty-cart.png') }}" 
                 alt="Empty Cart" 
                 class="mb-4" 
                 style="width: 150px; height: 150px;">
            <h4 class="text-muted text-uppercase">Your cart is empty. Let's add some courses!</h4>
            <p class="text-muted mb-4">Browse our <span><a href="{{ route('learner.dashboard') }}" style="text-decoration: underline" class="text-primary">courses</a></span> Page to check How we can help you learn.</p>
            <a href="{{ route('learner.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-book me-2"></i> Browse Courses
            </a>
        </div>
        @endif
       
    </div>
</div>
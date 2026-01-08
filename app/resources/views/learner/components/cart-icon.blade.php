{{-- resources/views/components/cart-icon.blade.php --}}
@props(['count' => 0])

<div class="position-relative d-inline-block">
    <i class="far fa-shopping-cart fa-lg"></i>
    
    @if($count > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $count }}
            <span class="visually-hidden">items in cart</span>
        </span>
    @endif
</div>
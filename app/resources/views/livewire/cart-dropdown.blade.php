<div class="dropdown-menu dropdown-menu-end cart-menu" aria-labelledby="cartDropdown" wire:ignore.self>
    <div class="cart-header">
        <h6 class="mb-0">Shopping Cart</h6>
        <span class="text-muted small">{{ $count }} {{ Str::plural('item', $count) }}</span>
    </div>
    
    <div class="cart-body" style="max-height: 300px; overflow-y: auto;">
        @if(count($items) > 0)
            @foreach($items as $item)
                <div class="cart-item d-flex align-items-start py-2 border-bottom">
                    <div class="cart-item-image flex-shrink-0 me-3">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}" 
                                 alt="{{ $item['name'] }}" 
                                 class="img-fluid rounded" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-graduation-cap text-muted"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="cart-item-details flex-grow-1">
                        <h6 class="mb-1" style="font-size: 14px;">
                            <a href="{{ route('learner.courses.show', $item['slug']) }}" 
                               class="text-decoration-none text-dark">
                                {{ Str::limit($item['name'], 30) }}
                            </a>
                        </h6>
                        <small class="text-muted">Quantity: {{ $item['quantity'] }}</small>
                        <p class="mb-0 fw-semibold " style="color: #0A1F44">${{ number_format($item['total'], 2) }}</p>
                    </div>
                    
                    <div class="cart-item-remove flex-shrink-0">
                        <button wire:click="removeItem({{ $item['id'] }})" 
                                wire:loading.attr="disabled"
                                class="btn btn-sm btn-link text-danger p-0"
                                title="Remove item">
                            <i class="far fa-times"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4">
                <i class="far fa-shopping-cart fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">Your cart is empty</p>
            </div>
        @endif
    </div>
    
    @if(count($items) > 0)
        <div class="cart-footer border-top pt-3">
            <div class="cart-total d-flex justify-content-between mb-3">
                <span class="fw-bold">Total:</span>
                <span class="fw-bold" style="color: #0A1F44">${{ number_format($total, 2) }}</span>
            </div>
            <div class="cart-actions">
                <a href="{{ route('learner.cart.index') }}" class="theme-btn style-two rounded-3 w-100 px-0 py-2 me-3 mb-2">
                    <i class="far fa-eye me-1"></i> View Cart
                </a>
                <a href="{{ route('learner.cart.index') }}" class="theme-btn style-one rounded-3 w-100 px-0 py-2 me-3 mb-2">
                    <i class="far fa-credit-card me-1"></i> Checkout
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Initialize Bootstrap dropdown when Livewire loads
    document.addEventListener('livewire:load', function() {
        // Initialize dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    });

    // Prevent Livewire from interfering with dropdown clicks
    document.addEventListener('click', function(e) {
        // If clicking inside the cart dropdown
        if (e.target.closest('.cart-dropdown') || e.target.closest('.cart-menu')) {
            e.stopPropagation();
        }
        
        // If clicking a remove button, prevent default
        if (e.target.closest('[wire\\:click*="removeItem"]')) {
            e.preventDefault();
            e.stopPropagation();
        }
    });
</script>
@endpush
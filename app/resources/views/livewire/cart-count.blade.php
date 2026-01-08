{{-- resources/views/livewire/cart-count.blade.php --}}
<span wire:poll.visible.5s="updateCart" class="cart-count badge bg-success">
    {{ $count }}
</span>
  
@push('styles') 

@endpush
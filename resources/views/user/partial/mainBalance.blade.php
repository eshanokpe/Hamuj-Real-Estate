<div class="row">
    <div class="col-lg-12">
        <div class="swiper-slide">
            <div class="currency__card">
                <h4 class="currency__card--title">
                   Main Balance
                </h4> 
                @if(Auth::user()->hide_balance)
                    *****
                @else
                    <span class="currency__card--amount">{{ $wallet->currency}} {{ number_format($wallet->balance, 2) }}</span>
                @endif

                <br>
            </div>
        </div>
    </div>
</div>
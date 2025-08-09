@extends('layouts.dashboard')

@section('content')

<div class="page__body--wrapper" id="dashbody__page--body__wrapper">
   
    <main class="main__content_wrapper">
        <form action="{{ route('user.transfer.initiate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="amount">Amount (in NGN)</label>
                <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount in NGN" required min="1">
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="account_number">Recipient Account number</label>
                <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Enter recipient account number" required>
                @error('account_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="reason">Reason for Transfer (Optional)</label>
                <textarea id="reason" name="reason" class="form-control" placeholder="Enter reason for transfer (optional)"></textarea>
                @error('reason')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Initiate Transfer</button>
        </form>
    </main>
</div>

@endsection 
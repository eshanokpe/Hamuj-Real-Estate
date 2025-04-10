<form action="{{ url('/home/wallets') }}" method="POST">
    @csrf
    <div>
        <label for="walletReference">Wallet Reference</label>
        <input type="text" id="walletReference" name="walletReference" required>
    </div>


    <button type="submit">Create Wallet</button>
</form>

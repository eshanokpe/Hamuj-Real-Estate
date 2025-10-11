// RevolutPayButton.jsx
import React, { useState, useEffect, useRef } from "react";
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from "react-router-dom";
// import RevolutCheckout from "@revolut/checkout";
// import RevolutCheckout from "https://unpkg.com/@revolut/checkout/esm";
import axios from "axios";
import RevolutPayButton from "../payment/RevolutPayButton";

const TopUpWallet = ({ initialCurrency = 'GBP' }) => { 
  const [amount, setAmount] = useState('10.00'); // Default to min amount, as string for input
  const [currency, setCurrency] = useState(initialCurrency); // Use prop for initial currency
  const [currencySymbol, setCurrencySymbol] = useState('£'); // State for currency symbol

  // Effect to update internal currency state if initialCurrency prop changes
  useEffect(() => {
    setCurrency(initialCurrency);
  }, [initialCurrency]);

  // Effect to update currency symbol when currency state changes
  useEffect(() => {
    if (currency === 'GBP') {
      setCurrencySymbol('£');
    } else if (currency === 'USD') {
      setCurrencySymbol('$');
    } else {
      // Fallback or handle other currencies
      setCurrencySymbol(currency); // Display currency code if no symbol defined
    }
  }, [currency]);

  const handleAmountChange = (e) => {
    setAmount(e.target.value);
  };

  const numericAmount = parseFloat(amount);
  const amountInCents = !isNaN(numericAmount) && numericAmount >= 10
                        ? Math.round(numericAmount * 100)
                        : 0; 
  console.log("Amount :", amount); // Debugging log
  console.log("Amount in cents:", amountInCents); 
  console.log("currency in cents:", currency); 
  console.log("currencySymbol in cents:", currencySymbol); 
  return (
    <div>
         <p>Top Up Wallet</p>
        <div className="modal-content">
            <div className="modal-header">
                <h3 id="modalTitle">Top Up Account</h3>
                {/* Consider replacing with React onClick handler if closeModal is a React managed function */}
                <button className="close-modal" onClick={() => console.log('Close modal clicked (implement me)')}>&times;</button>
            </div>
            <form id="topUpForm">
                {/* Hidden input for currency. Its value is controlled by React state. */}
                <input type="hidden" id="currencyType" name="currency" value={currency} readOnly />
                <div className="amount-input">
                    <span className="currency-symbol" id="modalCurrencySymbol">{currencySymbol}</span>
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        placeholder="Enter amount"
                        min="10"
                        step="0.01"
                        required
                        value={amount}
                        onChange={handleAmountChange}
                    />
                </div>
                {/* The minAmount text can also be made dynamic based on currencySymbol if needed */}
                <p className="min-amount">Minimum top-up amount: <span id="minAmount">{currencySymbol}10.00</span></p>
                <div style={{ marginTop: "1rem" }}>
                {amountInCents >= (10 * 100) ? ( // Only render/enable if amount is valid (e.g., >= 10 GBP)
                    <RevolutPayButton amountInCents={amountInCents} currency={currency} />
                ) : (
                    <p style={{ color: 'red' }}>Please enter an amount of £10.00 or more.</p>
                )}
                </div>
            </form>
        </div> 
    </div>
  );
};

export default TopUpWallet;



// Initialize React app only once
const propertiesElement = document.getElementById('topUpRevolutModal');
if (propertiesElement && !propertiesElement._reactRoot) {
    const root = ReactDOM.createRoot(propertiesElement); 
    // Initial render. For dynamic updates from Blade, you'd use a separate mounting script
    // (like topUpModalMount.js discussed previously) that can re-render with new props.
    root.render(
        <React.StrictMode>
            <BrowserRouter> 
                <TopUpWallet initialCurrency="GBP" />
            </BrowserRouter>
        </React.StrictMode>
    );
    propertiesElement._reactRoot = true;
}
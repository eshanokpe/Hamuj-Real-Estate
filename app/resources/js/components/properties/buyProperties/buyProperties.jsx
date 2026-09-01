import React, { useEffect, useState, useRef } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import { BrowserRouter, Routes, Route, useParams, useNavigate } from 'react-router-dom';
import RevolutCheckout from '@revolut/checkout';

// Payment Success Component
const PaymentSuccess = () => {
    return (
        <div className="container py-5 text-center">
            <div className="alert alert-success">
                <h2>Payment Successful!</h2>
                <p>Your transaction has been completed successfully.</p>
                <a href="/user/dashboard" className="btn btn-primary">Return to Dashboard</a>
            </div>
        </div> 
    );
};

// Helper function to parse numeric strings with commas
const parseNumericString = (value) => {
    if (value === null || value === undefined) return 0;
    if (typeof value === 'number') return value;
    if (typeof value === 'string') {
        const cleanedValue = value.replace(/,/g, '');
        const parsed = parseFloat(cleanedValue);
        return isNaN(parsed) ? 0 : parsed;
    }
    return 0;
};

// Main Payment Component
const BuyProperties = () => {
    const navigate = useNavigate();
    const { slug } = useParams();
    
    // State management
    const [inputAmount, setInputAmount] = useState('');
    const [calculatedLandSize, setCalculatedLandSize] = useState(0);
    const [totalROI, settotalROI] = useState(0);
    const [applyCommission, setApplyCommission] = useState(false);
    const [property, setProperty] = useState(null);
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [remainingSize, setRemainingSize] = useState(0);
    const [showPaymentModal, setShowPaymentModal] = useState(false);
    const [paymentMethod, setPaymentMethod] = useState(null);
    const [transactionPin, setTransactionPin] = useState('');
    const [paymentProcessing, setPaymentProcessing] = useState(false);
    const [amountError, setAmountError] = useState('');
    const [paymentSuccess, setPaymentSuccess] = useState(false);
    const revolutCheckoutRef = useRef(null);

    const MINIMUM_AMOUNT = 1000;

    // Fetch property details
    useEffect(() => {
        if (!slug) {
            setError("No property identifier provided in the URL.");
            setLoading(false);
            return;
        }

        const fetchProperty = async () => {
            try {
                const response = await axios.get(`/user/properties-details/${slug}`);
                if (!response.data.property) {
                    throw new Error('Property data not found in response');
                }
                
                setUser(response.data.user);
                setProperty(response.data.property);
                
                const availableSize = parseNumericString(response.data.property.available_size);
                setRemainingSize(availableSize);
            } catch (err) {
                console.error('Error fetching property:', err);
                setError(err.response?.data?.message || err.message || 'Failed to fetch property details.');
            } finally {
                setLoading(false);
            }
        };

        fetchProperty();
    }, [slug]);   

    // Calculate land size and total price based on input amount
    useEffect(() => {
        if (!property) return;

        const pricePerSqm = property.valuation_summary?.current_value_sum || property.price;
        const amount = parseFloat(inputAmount) || 0;

        // Validate minimum amount for error display
        if (amount > 0 && amount < MINIMUM_AMOUNT) {
            setAmountError(`Minimum amount is ${formatCurrency(MINIMUM_AMOUNT)}`);
        } else {
            setAmountError('');
        }

        if (amount <= 0) {
            setCalculatedLandSize(0);
            settotalROI(0);
            setRemainingSize(parseNumericString(property.available_size));
            return;
        }

        // 1. Calculate Land Size — isolated so a missing/invalid pricePerSqm
        //    only zeroes the land size, not the total price below.
        let landSize = 0;
        if (pricePerSqm && pricePerSqm > 0) {
            landSize = amount / pricePerSqm;
            if (isNaN(landSize) || !isFinite(landSize)) {
                landSize = 0;
            }
        }
        setCalculatedLandSize(landSize);

        // 2. Calculate ROI Amount
        // Ensure percentage_increase is a valid number
        const rawPercentage = property.percentage_increase;
        const roiPercentage = typeof rawPercentage === 'string' ? parseFloat(rawPercentage.replace('%', '')) : parseFloat(rawPercentage);
        const safeRoiPercentage = isNaN(roiPercentage) ? 0 : roiPercentage;
        
        const roiAmount = amount * (safeRoiPercentage / 100);
        
        // 3. Calculate Final Total: Input Amount + ROI Amount
        let finalTotal = amount + roiAmount; 
        
        // 4. Deduct commission if applied
        if (applyCommission && user?.commission_balance) {
            finalTotal = Math.max(finalTotal - user.commission_balance, 0);
        }
        
        settotalROI(finalTotal);
        
        // Update remaining size
        const currentAvailableSize = parseNumericString(property.available_size);
        const newRemainingSize = Math.max(currentAvailableSize - landSize, 0);
        setRemainingSize(newRemainingSize);

    }, [inputAmount, applyCommission, property, user]);

    // Amount handlers
    const handleAmountChange = (e) => {
        const value = e.target.value;
        if (value === '' || /^\d*\.?\d*$/.test(value)) {
            setInputAmount(value);
        }
    };

    const handleInputFocus = (e) => {
        if (e.target.value === '0') {
            setInputAmount('');
        }
    };

    const handleInputBlur = (e) => {
        const amount = parseFloat(inputAmount) || 0;
        if (inputAmount === '') {
            setInputAmount('0');
        } else if (amount > 0 && amount < MINIMUM_AMOUNT) {
            setAmountError(`Minimum amount is ${formatCurrency(MINIMUM_AMOUNT)}`);
        } else {
            setAmountError('');
        }
    };

    // Format currency
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN',
            minimumFractionDigits: 2
        }).format(amount || 0);
    };

    // Format land size
    const formatLandSize = (size) => {
        if (isNaN(size) || !isFinite(size)) return '0.0000 SQM';
        return `${Math.max(0, size).toFixed(4)} SQM`;
    };

    const getDisplayRemainingSize = () => {
        return parseNumericString(remainingSize).toFixed(4);
    };

    const getAvailableSize = () => {
        if (!property) return 0;
        return parseNumericString(property.available_size);
    };
 
    // Payment handlers
    const handleMakePayment = (e) => {
        e.preventDefault();
        const amount = parseFloat(totalROI) || 0;
        const availableSize = getAvailableSize();

        if (amount < MINIMUM_AMOUNT) {
            alert(`Minimum amount required is ${formatCurrency(MINIMUM_AMOUNT)}`);
            return;
        }

        if (calculatedLandSize > availableSize) {
            alert(`The calculated land size exceeds the available size.`);
            return;
        }

        if (isNaN(totalROI) || !isFinite(totalROI) || totalROI <= 0) {
            alert('Unable to calculate a valid total price. Please re-enter the amount.');
            return;
        }

        setPaymentMethod(null);
        setTransactionPin('');
        setPaymentSuccess(false);
        setShowPaymentModal(true);
    };
    const handlePaymentMethodSelect = (method) => {
        setPaymentMethod(method);
    };

    const initializeRevolutPayment = async (publicId) => {
        try {
            const revolutCheckout = await RevolutCheckout(publicId, {
                mode: process.env.REACT_APP_REVOLUT_MODE || 'sandbox',
                onSuccess: () => {
                    setPaymentSuccess(true);
                    setShowPaymentModal(true);
                },
                onError: (error) => {
                    console.error('Payment error:', error);
                    alert('Payment failed. Please try again.');
                },
                onCancel: () => console.log('Payment cancelled')
            });
            revolutCheckoutRef.current = revolutCheckout;
            revolutCheckout.show();
        } catch (err) {
            console.error('Error initializing Revolut payment:', err);
            alert('Failed to initialize payment gateway.');
        }
    };

    const handleConfirmPayment = async (e) => {
        e.preventDefault();
        const amount = parseFloat(inputAmount) || 0;
        
        if (amount < MINIMUM_AMOUNT) {
            alert(`Minimum amount required is ${formatCurrency(MINIMUM_AMOUNT)}`);
            return;
        }
        
        if (!transactionPin || transactionPin.length !== 4 || !/^\d{4}$/.test(transactionPin)) {
            alert('Please enter a valid 4-digit PIN.');
            return;
        }

        setPaymentProcessing(true);
 
        try { 
            const response = await axios.post('/user/payment/initiate', {
                remaining_size: parseNumericString(remainingSize),
                property_slug: property.slug,
                quantity: calculatedLandSize,
                totalROI: totalROI, // This now includes Input + ROI
                total_price: amount, 
                commission_applied_amount: applyCommission ? user.commission_balance : 0,
                transaction_pin: transactionPin,
                commission_check: applyCommission ? 1 : 0,
                payment_method: paymentMethod,
            }); 
            
            if (response.data.success) {
                if (paymentMethod === 'card' && response.data.public_id) {
                    // Close our modal and let the Revolut widget take over;
                    // its onSuccess callback (above) reopens our modal in
                    // the success view.
                    setShowPaymentModal(false);
                    await initializeRevolutPayment(response.data.public_id);
                } else {
                    // Wallet payments: switch the same modal into its
                    // success view instead of closing it, so the user can
                    // see confirmation and choose to go to the dashboard.
                    setTransactionPin('');
                    setPaymentSuccess(true);
                }
            } else {
                throw new Error(response.data.message || 'Payment failed');
            }
        } catch (err) {
            console.error('Payment error:', err);
            alert(err.response?.data?.message || err.message || 'Payment failed');
            setShowPaymentModal(false);
        } finally {
            setPaymentProcessing(false);
        }
    };

    if (loading) return <div className="text-center py-5">Loading property details...</div>;
    if (error) return <div className="alert alert-danger">{error}</div>;
    if (!property) return <div className="alert alert-warning">No property found</div>;

    const pricePerSqm = property.valuation_summary?.current_value_sum || property.price;
    const amount = parseFloat(inputAmount) || 0;
    
    // Recalculate ROI for display consistency
    const rawPercentage = property.percentage_increase;
    const roiPercentage = typeof rawPercentage === 'string' ? parseFloat(rawPercentage.replace('%', '')) : parseFloat(rawPercentage);
    const safeRoiPercentage = isNaN(roiPercentage) ? 0 : roiPercentage;
    const roiAmount = amount * (safeRoiPercentage / 100);

    const isAmountValid = amount >= MINIMUM_AMOUNT;
    const availableSize = getAvailableSize();

    return (
        <div className="dashboard__page--wrapper">
            <div className="page__body--wrapper" id="dashbody__page--body__wrapper">
                <main className="main__content_wrapper">
                    <div className="dashboard__container dashboard__reviews--container">
                        <div className="reviews__heading mb-30">
                            <h2 className="reviews__heading--title">My Property</h2>
                            <p className="reviews__heading--desc">We are glad to see you again!</p>
                        </div>

                        <div className="properties__wrapper">
                            {/* Mobile Card View */}
                            <div className="mobile-property-card d-block d-md-none">
                                <div className="property-card">
                                    <div className="property-header">
                                        <div className="property-image">
                                            <img
                                                src={property.property_images ? (property.property_images.startsWith('http') ? property.property_images : `/${property.property_images}`) : '/images/placeholder-property.jpg'}
                                                alt={property.name}
                                                onError={(e) => { e.target.src = '/images/placeholder-property.jpg'; }}
                                            />
                                        </div>
                                        <div className="property-info">
                                            <h3>{property.name}</h3>
                                            <div className="property-price">{formatCurrency(pricePerSqm)} per/sqm</div>
                                        </div>
                                    </div>
                                    
                                    <div className="property-details">
                                        <div className="detail-item">
                                            <span className="label">Actual Land Size:</span>
                                            <span className="value">{property.size} SQM</span>
                                        </div>
                                        <div className="detail-item">
                                            <span className="label">Available Size:</span>
                                            <span className="value">{getDisplayRemainingSize()} SQM</span>
                                        </div>
                                    </div>

                                    <div className="amount-section">
                                        <label className="form-label">Enter Amount (₦)</label>
                                        <input 
                                            type="number" 
                                            value={inputAmount}
                                            onChange={handleAmountChange}
                                            onFocus={handleInputFocus}
                                            onBlur={handleInputBlur}
                                            className={`form-control ${amountError ? 'is-invalid' : ''}`}
                                            placeholder={`Minimum ${formatCurrency(MINIMUM_AMOUNT)}`}
                                            min={MINIMUM_AMOUNT}
                                            step="100"
                                        />
                                        {amountError && <div className="text-danger small mt-1">{amountError}</div>}
                                        <div className="text-muted small mt-1">Minimum amount: {formatCurrency(MINIMUM_AMOUNT)}</div>
                                    </div>

                                    <div className="calculation-results">
                                        <div className="result-item">
                                            <span className="label">Calculated Land Size:</span>
                                            <span className="value highlight">{formatLandSize(calculatedLandSize)}</span>
                                        </div>
                                        <div className="result-item">
                                            <span className="label">Total to Pay:</span>
                                            <span className="value highlight">{formatCurrency(totalROI)}</span>
                                        </div>
                                        
                                        {amount > 0 && safeRoiPercentage > 0 && (
                                            <div className="result-item">
                                                <span className="label">Projected ROI:</span>
                                                <span className="value text-success">{formatCurrency(roiAmount)} ({safeRoiPercentage}%)</span>
                                            </div>
                                        )}

                                        {applyCommission && user?.commission_balance && (
                                            <div className="commission-applied text-success small">
                                                Commission applied: -{formatCurrency(user.commission_balance)}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {/* Desktop Table View */}
                            <div className="properties__table table-responsive d-none d-md-block">
                                <table className="properties__table--wrapper cart__table">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Enter Amount (₦)</th>
                                            <th>Total to Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div className="properties__author d-flex align-items-center">
                                                    <div className="properties__author--thumb">
                                                        <img
                                                            src={property.property_images ? (property.property_images.startsWith('http') ? property.property_images : `/${property.property_images}`) : '/images/placeholder-property.jpg'}
                                                            alt={property.name}
                                                            style={{ width: '64px', height: '64px', objectFit: 'cover' }}
                                                            onError={(e) => { e.target.src = '/images/placeholder-property.jpg'; }}
                                                        />
                                                    </div>
                                                    <div className="reviews__author--text">
                                                        <h3 className="reviews__author--title">{property.name}</h3>
                                                        {property.valuation_summary ? (
                                                            <>
                                                                <span className="properties__author--price">{formatCurrency(property.valuation_summary.current_value_sum)} per/sqm</span>
                                                                <p className="properties__author--price text-decoration-line-through text-muted">{formatCurrency(property.valuation_summary.initial_value_sum)} per/sqm</p>
                                                                <p className="reviews__author--title">{property.valuation_summary.percentage_value}%</p>
                                                            </>
                                                        ) : (
                                                            <p className="">ROI: {property.percentage_increase}%</p>
                                                        )}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="d-flex flex-column gap-2">
                                                    <input 
                                                        type="number" 
                                                        value={inputAmount}
                                                        onChange={handleAmountChange}
                                                        onFocus={handleInputFocus}
                                                        onBlur={handleInputBlur}
                                                        className={`${amountError ? 'is-invalid' : ''}`}
                                                        placeholder={`Minimum ${formatCurrency(MINIMUM_AMOUNT)}`}
                                                        min={MINIMUM_AMOUNT}
                                                        step="100"
                                                    />
                                                    {amountError && <div className="text-danger small">{amountError}</div>}
                                                    <div className="text-muted small">Minimum amount: {formatCurrency(MINIMUM_AMOUNT)}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="d-flex flex-column gap-1">
                                                    <span className="total-price" style={{ color: '#47008E', fontWeight: 'bold' }}>
                                                        {formatCurrency(totalROI)}
                                                    </span>
                                                    
                                                    {amount > 0 && safeRoiPercentage > 0 && (
                                                        <div className="text-success small">
                                                            Projected ROI: {formatCurrency(roiAmount)} ({safeRoiPercentage}%)
                                                        </div>
                                                    )}

                                                    {applyCommission && user?.commission_balance && (
                                                        <div className="text-success small mt-1">
                                                            Commission applied: -{formatCurrency(user.commission_balance)}
                                                        </div>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div className="form-check mt-3">
                            <input
                                className="form-check-input"
                                type="checkbox"
                                id="applyCommission"
                                checked={applyCommission}
                                onChange={(e) => setApplyCommission(e.target.checked)}
                                disabled={!user?.commission_balance}
                            />
                            <label className="form-check-label" htmlFor="applyCommission">
                                Apply commission balance ({formatCurrency(user?.commission_balance || 0)})
                            </label>
                        </div>

                        <div className="cart__footer d-flex justify-content-between align-items-center mt-4">
                            <a href="/user/buy" className="solid__btn" style={{ backgroundColor: '#CC9933' }}>View Properties</a>
                            <div>
                                <button 
                                    className="solid__btn" 
                                    onClick={handleMakePayment}
                                    // disabled={!isAmountValid || calculatedLandSize <= 0 || calculatedLandSize > availableSize || amountError}
                                >
                                    Make Payment
                                </button>
                            </div>
                        </div>

                        {/* Payment Modal */}
                        {showPaymentModal && (
                            <div className="modal show" style={{ display: 'block', backgroundColor: 'rgba(0,0,0,0.5)' }}>
                                <div className="modal-dialog modal-dialog-centered">
                                    <div className="modal-content">
                                        <div className="modal-header">
                                            <h4 className="">Select Payment Method</h4>
                                            <button type="button" className="btn-close" onClick={() => { setShowPaymentModal(false); setPaymentMethod(null); setPaymentSuccess(false); setTransactionPin(''); }}></button>
                                        </div>
                                        <div className="modal-body">
                                            {paymentSuccess ? (
                                                <div className="text-center py-3">
                                                    <div className="mb-3" style={{ fontSize: '2.5rem', color: '#28a745' }}>&#10003;</div>
                                                    <h5 className="mb-2">Payment Successful!</h5>
                                                    <p className="text-muted mb-4">Your property purchase has been completed successfully.</p>
                                                    <button
                                                        type="button"
                                                        className="solid__btn w-100"
                                                        onClick={() => { window.location.href = '/user/dashboard'; }}
                                                    >
                                                        Go to Dashboard
                                                    </button>
                                                </div>
                                            ) : !paymentMethod ? (
                                                <div className="d-flex flex-column gap-3">
                                                    <button className="solid__btn add__property--btn w-100" onClick={() => handlePaymentMethodSelect('wallet')}>Pay with Wallet</button>
                                                </div>
                                            ) : (
                                                <div>
                                                    <div className="form-group mt-3">
                                                        <label htmlFor="transaction_pin" className="form-label">Enter 4-digit Transaction PIN</label>
                                                        <input
                                                            type="password"
                                                            style={{padding: '10px 10px'}}
                                                            className="form-control"
                                                            id="transaction_pin"
                                                            maxLength="4"
                                                            inputMode="numeric"
                                                            pattern="\d{4}"
                                                            placeholder="****"
                                                            value={transactionPin}
                                                            onChange={(e) => setTransactionPin(e.target.value)}
                                                            required
                                                        />
                                                    </div>
                                                    <div className="d-flex justify-content-between mt-3">
                                                        <button type="button" style={{backgroundColor:'white', color:'black', border: '1px solid gray'}} className="solid__btn" onClick={() => { setPaymentMethod(null); setTransactionPin(''); }}>Back</button>
                                                        <button type="button" className="solid__btn " onClick={handleConfirmPayment} disabled={paymentProcessing}>
                                                            {paymentProcessing ? 'Processing...' : 'Confirm Payment'}
                                                        </button>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>

                    <style jsx>{`
                        .mobile-property-card { background: white; border-radius: 12px; padding: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 1rem; }
                        .property-header { display: flex; align-items: center; margin-bottom: 1rem; }
                        .property-image img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 1rem; }
                        .property-info h3 { margin: 0 0 0.5rem 0; font-size: 1.2rem; color: #333; }
                        .property-price { color: #47008E; font-weight: bold; font-size: 0.9rem; }
                        .property-details { margin-bottom: 1rem; }
                        .detail-item { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f0f0f0; }
                        .detail-item .label { color: #666; font-weight: 500; }
                        .detail-item .value { color: #333; font-weight: 600; }
                        .amount-section { margin-bottom: 1rem; }
                        .amount-section .form-control { padding: 0.75rem; font-size: 16px; border: 2px solid #e0e0e0; border-radius: 8px; }
                        .calculation-results { background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-top: 1rem; }
                        .result-item { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; }
                        .result-item .label { color: #666; font-weight: 500; }
                        .result-item .value { font-weight: 600; }
                        .result-item .value.highlight { color: #47008E; font-size: 1.1rem; }
                        .commission-applied { text-align: center; margin-top: 0.5rem; padding: 0.25rem; background: #d4edda; border-radius: 4px; }
                        @media (max-width: 480px) {
                            .property-header { flex-direction: column; text-align: center; }
                            .property-image img { margin-right: 0; margin-bottom: 0.5rem; }
                            .cart__footer { flex-direction: column; gap: 1rem; }
                            .cart__footer .solid__btn { width: 100%; text-align: center; }
                        }
                    `}</style>
                </main>
            </div>
        </div>
    );
};

const IndexPage = () => {
    return (
        <div style={{ padding: '2rem', textAlign: 'center' }}>
            <h2>Buy Properties</h2>
            <p>Please include a property slug in the URL.</p>
        </div>
    );
};

const App = () => (
    <BrowserRouter basename="/user/cart">
        <Routes>
            <Route index element={<IndexPage />} />
            <Route path=":slug" element={<BuyProperties />} />
            <Route path="success" element={<PaymentSuccess />} />
        </Routes>
    </BrowserRouter>
);

const rootEl = document.getElementById('buyProperties');
if (rootEl) {
    const root = ReactDOM.createRoot(rootEl);
    root.render(<App />);
}

export { PaymentSuccess, IndexPage, App, BuyProperties };
export default BuyProperties;

if (import.meta.hot) {
    import.meta.hot.accept();
}
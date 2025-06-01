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

// Main Payment Component
const BuyProperties = () => {
    const navigate = useNavigate();
    const { slug } = useParams();
    let url = window.location.origin
    
    // State management
    const [quantity, setQuantity] = useState(0);
    const [totalPrice, setTotalPrice] = useState(0);
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
    const revolutCheckoutRef = useRef(null);

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
                setRemainingSize(response.data.property.available_size);
            } catch (err) {
                console.error('Error fetching property:', err);
                setError(err.response?.data?.message || err.message || 'Failed to fetch property details.');
            } finally {
                setLoading(false);
            }
        };

        fetchProperty();
    }, [slug]);

    // Calculate total price and remaining size
    useEffect(() => {
        if (!property) return;
        
        const pricePerSqm = property.valuationSummary?.current_value_sum || property.price;
        const calculatedTotal = pricePerSqm * quantity;
        let finalTotal = calculatedTotal;
        
        if (applyCommission && user?.commission_balance) {
            finalTotal = Math.max(calculatedTotal - user.commission_balance, 0);
        }
        
        setTotalPrice(finalTotal);
        setRemainingSize(Math.max(property.available_size - quantity, 0));
    }, [quantity, applyCommission, property, user]);

    // Quantity handlers
    const handleIncrement = () => {
        if (quantity < property?.available_size) {
            setQuantity(prev => prev + 1);
        } else {
            alert(`You cannot exceed the available size of ${property?.available_size} per/sqm.`);
        }
    };

    const handleDecrement = () => {
        if (quantity > 0) {
            setQuantity(prev => prev - 1);
        }
    };

    const handleQuantityChange = (e) => {
        const value = parseInt(e.target.value) || 0;
        if (value < 0) {
            setQuantity(0);
        } else if (property && value > property.available_size) {
            alert(`You cannot exceed the available size of ${property.available_size} per/sqm.`);
            setQuantity(property.available_size);
        } else {
            setQuantity(value);
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

    // Payment handlers
    const handleMakePayment = (e) => {
        e.preventDefault();
        if (quantity <= 0) { 
            alert('Please select a quantity greater than 0 to proceed.');
            return;
        }
        setShowPaymentModal(true);
    };

    const handlePaymentMethodSelect = (method) => {
        setPaymentMethod(method);
    };

    const initializeRevolutPayment = async (publicId) => {
        try {
            // RevolutCheckout("pk_Gjk5dYEZjkHeJqgrzfMeSYhy2deEQkD0r1zhrGLGAKuurOyV", "sandbox").then((instance) => {
            // // work with instance
            // })
            const revolutCheckout = await RevolutCheckout(publicId, {
                mode: process.env.REACT_APP_REVOLUT_MODE || 'sandbox',
                onSuccess: () => {
                    navigate('/user/cart/buy/success');
                },
                onError: (error) => {
                    console.error('Payment error:', error);
                    alert('Payment failed. Please try again.');
                },
                onCancel: () => {
                    console.log('Payment was cancelled by user');
                }
            });

            revolutCheckoutRef.current = revolutCheckout;
            revolutCheckout.show();
        } catch (err) {
            console.error('Error initializing Revolut payment:', err);
            alert('Failed to initialize payment gateway. Please try again.');
        }
    };

    const handleConfirmPayment = async (e) => {
        e.preventDefault();
        
        if (!transactionPin || transactionPin.length !== 4 || !/^\d{4}$/.test(transactionPin)) {
            alert('Please enter a valid 4-digit PIN.');
            return;
        }

        setPaymentProcessing(true);

        try {
            const response = await axios.post('/user/payment/initiate', {
                remaining_size: remainingSize,
                property_slug: property.slug,
                quantity,
                total_price: totalPrice,
                commission_applied_amount: applyCommission ? user.commission_balance : 0,
                transaction_pin: transactionPin,
                commission_check: applyCommission ? 1 : 0,
                payment_method: paymentMethod,
            });

            if (response.data.success) {
                if (paymentMethod === 'wallet') {
                    navigate('/user/cart/buy/success');
                } else if (paymentMethod === 'card' && response.data.public_id) {
                    await initializeRevolutPayment(response.data.public_id);
                }
            } else {
                throw new Error(response.data.message || 'Payment failed');
            }
        } catch (err) {
            console.error('Payment error:', err);
            alert(err.response?.data?.message || err.message || 'Payment failed');
        } finally {
            setPaymentProcessing(false);
            setShowPaymentModal(false);
        }
    };

    // Loading and error states
    if (loading) return <div className="text-center py-5">Loading property details...</div>;
    if (error) return <div className="alert alert-danger">{error}</div>;
    if (!property) return <div className="alert alert-warning">No property found</div>;

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
                            <div className="properties__table table-responsive">
                                <table className="properties__table--wrapper cart__table">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Price</th>
                                            <th>Actual Land Size</th>
                                            <th>Available Land Size</th>
                                            <th>Select Land Size</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div className="properties__author d-flex align-items-center">
                                                    <div className="properties__author--thumb">
                                                        <img
                                                            src={
                                                                property.property_images
                                                                    ? (property.property_images.startsWith('http') || property.property_images.startsWith('/'))
                                                                        ? property.property_images
                                                                        : `/${property.property_images.replace(/^\/+/, '')}`
                                                                    : '/images/placeholder-property.jpg'
                                                            }
                                                            alt={property.name}
                                                            style={{ width: '64px', height: '64px', objectFit: 'cover' }}
                                                            onError={(e) => {
                                                                e.target.src = '/images/placeholder-property.jpg';
                                                                e.target.onerror = null;
                                                            }}
                                                        />
                                                    </div>
                                                    <div className="reviews__author--text">
                                                        <h3 className="reviews__author--title">{property.name}</h3>
                                                        {property.valuation_summary ? (
                                                            <>
                                                                <span className="properties__author--price">
                                                                    {formatCurrency(property.valuation_summary.current_value_sum)} per/sqm
                                                                </span>
                                                                <p className="properties__author--price text-decoration-line-through text-muted">
                                                                    {formatCurrency(property.valuation_summary.initial_value_sum)} per/sqm
                                                                </p>
                                                                <p className="reviews__author--title">{property.valuation_summary.percentage_value}%</p>
                                                            </>
                                                        ) : (
                                                            <span className="properties__author--price">
                                                                {formatCurrency(property.price)} per/sqm
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span className="item-price">
                                                    {formatCurrency(property.valuationSummary?.current_value_sum || property.price)} per/sqm
                                                </span>
                                            </td>
                                            <td><span>{property.size} SQM</span></td>
                                            <td className="available-size">
                                                {remainingSize} SQM
                                            </td>
                                            <td>
                                                <div className="d-flex align-items-center">
                                                    <button 
                                                        className="btn btn-outline-secondary btn-sm decrement-btn" 
                                                        style={{ padding: '5px 10px', background: '#47008E', color: '#fff', fontSize: '18px' }}
                                                        onClick={handleDecrement}
                                                    >
                                                        -
                                                    </button>
                                                    <input 
                                                        type="number" 
                                                        value={quantity}
                                                        onChange={handleQuantityChange}
                                                        className="quantity-input text-center mx-2" 
                                                        style={{ width: '50px' }} 
                                                        min="0"
                                                    />
                                                    <button 
                                                        className="btn btn-outline-secondary btn-sm increment-btn" 
                                                        style={{ padding: '5px 10px', background: '#47008E', color: '#fff', fontSize: '18px' }}
                                                        onClick={handleIncrement}
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <span className="total-price" style={{ color: '#47008E' }}>
                                                    {formatCurrency(totalPrice)}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div className="cart__footer d-flex justify-content-between align-items-center mt-4">
                            <a href="/user/buy" className="solid__btn" style={{ backgroundColor: '#CC9933' }}>
                                View Properties
                            </a>
                            <div>
                                <button 
                                    className="solid__btn" 
                                    onClick={handleMakePayment}
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
                                            <h5 className="modal-title">Select Payment Method</h5>
                                            <button 
                                                type="button" 
                                                className="btn-close" 
                                                onClick={() => {
                                                    setShowPaymentModal(false);
                                                    setPaymentMethod(null);
                                                }}
                                            ></button>
                                        </div>
                                        <div className="modal-body">
                                            {!paymentMethod ? (
                                                <div className="d-flex flex-column gap-3">
                                                    {/* <button 
                                                        className="solid__btn" style="background-color:rgb(0, 24, 142)"
                                                        onClick={() => handlePaymentMethodSelect('card')}
                                                    >
                                                        Pay with Card
                                                    </button> */}
                                                    <button 
                                                        className="solid__btn" style="background-color: grey"
                                                        onClick={() => handlePaymentMethodSelect('wallet')}
                                                    >
                                                        Pay with Wallet
                                                    </button>
                                                </div>
                                            ) : (
                                                <div>
                                                    <div className="form-group mt-3">
                                                        <label htmlFor="transaction_pin" className="form-label">
                                                            Enter 4-digit Transaction PIN
                                                        </label>
                                                        <input
                                                            type="password"
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
                                                        <button 
                                                            type="button" 
                                                            className="btn btn-outline-secondary"
                                                            onClick={() => {
                                                                setPaymentMethod(null);
                                                                setTransactionPin('');
                                                            }}
                                                        >
                                                            Back
                                                        </button>
                                                        <button 
                                                            type="button" 
                                                            className="btn btn-primary"
                                                            onClick={handleConfirmPayment}
                                                            disabled={paymentProcessing}
                                                        >
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
                </main>
            </div>
        </div>
    );
};

// Index Page Component
const IndexPage = () => {
    return (
        <div style={{ padding: '2rem', textAlign: 'center' }}>
            <h2>Buy Properties</h2>
            <p>Please include a property slug in the URL (e.g. `/user/cart/buy/my-slug`).</p>
        </div>
    );
};

// Main App Component
const App = () => (
    <BrowserRouter basename="/user/cart">
        <Routes>
            <Route index element={<IndexPage />} />
            <Route path=":slug" element={<BuyProperties />} />
            <Route path="success" element={<PaymentSuccess />} />
        </Routes>
    </BrowserRouter>
);  

// Mount to DOM
const rootEl = document.getElementById('buyProperties');
if (rootEl) {
    const root = ReactDOM.createRoot(rootEl);
    root.render(<App />);
}
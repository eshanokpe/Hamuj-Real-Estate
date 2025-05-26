import React, { useState, useEffect, useCallback } from 'react';
import axios from 'axios'; 
import ReactDOM from 'react-dom/client';
import { useParams, useNavigate, BrowserRouter } from 'react-router-dom';

function Properties() {
    const { slug } = useParams();
    const navigate = useNavigate();
    const [user, setUser] = useState(null);
    const [properties, setProperties] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const fetchProperties = useCallback(async () => {
        setLoading(true);
        try {
            const response = await axios.get('/api/properties');
            setUser(response.data.user);
            setProperties(response.data.properties.data);
        } catch (err) {
            console.error('Fetch error:', err);
            setError(err.response?.data?.message || err.message);
        } finally {
            setLoading(false);
        }
    }, []);

    useEffect(() => {
        const controller = new AbortController();
        fetchProperties();

        return () => controller.abort();
    }, [fetchProperties]);

    const handleLink =(slug)=>{ 
        console.log(`Clicked on course with id ${slug}`);
        window.location.href=`/user/cart/buy/${slug}`;
    }
    const handleLinkOfferPrice =(id)=>{
        window.location.href=`/user/offer-price/${id}`;
    }

    const handleLinkProperties =(id) =>{
        window.location.href=`/properties/view/${id}`;
    }

    if (loading) return (
        <div className="text-center py-5">
            <div className="spinner-border text-primary" role="status">
                <span className="visually-hidden">Loading...</span>
            </div>
        </div>
    );

    if (error) return (
        <div className="alert alert-danger mx-auto my-4" style={{ maxWidth: '600px' }}>
            Error: {error}
        </div>
    );

    if (!properties.length) return (
        <div className="alert alert-warning mx-auto my-4" style={{ maxWidth: '600px' }}>
            No properties found
        </div>
    );

    return (
        <div className="dashboard__page--wrapper">
            <div className="page__body--wrapper" id="dashbody__page--body__wrapper">
                <main className="main__content_wrapper">
                    <div className="dashboard__container dashboard__reviews--container">
                        <div className="reviews__heading mb-30">
                            <h2 className="reviews__heading--title">Available Properties</h2>
                            <p className="reviews__heading--desc">Browse our exclusive listings</p>
                        </div>

                        <div className="properties__wrapper">
                            <div className="properties__table table-responsive">
                                <table className="properties__table--wrapper cart__table">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Price</th>
                                            <th>Size</th>
                                            <th>Available</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {properties.map(property => (
                                            <tr key={property.id}>
                                                <td>
                                                    <div className="properties__author d-flex align-items-center">
                                                        <div className="properties__author--thumb">
                                                            <img
                                                                src={
                                                                    property.property_images
                                                                        ? (property.property_images.startsWith('http') || property.property_images.startsWith('/'))
                                                                            ? property.property_images
                                                                            : `/${property.property_images.replace(/^\/+/, '')}`
                                                                        : '/images/placeholder-property.jpg' // Default placeholder if path is null/empty
                                                                }
                                                                alt={property.name}
                                                                style={{width: '64px', height: '64px', objectFit: 'cover'}}
                                                                onError={(e) => {
                                                                    e.target.src = '/images/placeholder-property.jpg';
                                                                    e.target.onerror = null;
                                                                }}
                                                            />
                                                        </div>
                                                        <div className="reviews__author--text">
                                                            <h3 className="reviews__author--title">{property.name}</h3>
                                                            <p className="reviews__author--subtitle">{property.location}</p>
                                                            {property.valuation_summary ? (
                                                                <>
                                                                    <span className="properties__author--price">
                                                                        ₦{parseFloat(property.valuation_summary.current_value_sum).toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} per/sqm
                                                                    </span>
                                                                    <p className="properties__author--price text-decoration-line-through text-muted">
                                                                        ₦{parseFloat(property.valuation_summary.initial_value_sum).toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} per/sqm
                                                                    </p>
                                                                    <p className="reviews__author--title">{property.valuation_summary.percentage_value}%</p>
                                                                </>
                                                            ) : (
                                                                <>
                                                                    <span className="properties__author--price">
                                                                        ₦{parseFloat(property.price).toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} per/sqm
                                                                    </span>
                                                                    {/* If property.percentage_increase is available from API when valuation_summary is null, display it here */}
                                                                </>
                                                            )}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    ₦{parseFloat(property.price).toLocaleString('en-NG', {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    })} per/sqm
                                                </td>
                                                <td>{property.size} SQM</td>
                                                <td>{property.available_size} SQM</td>
                                                <td>
                                                    {property.status === 'sold out' && (
                                                        <span 
                                                            className="status__btn" 
                                                            style={{ color: '#fff', backgroundColor: '#47008E' }}
                                                        >
                                                            <a onClick={()=>handleLinkOfferPrice(property.id)} 
                                                                style={{ color: '#fff', textDecoration: 'none' }}
                                                            >
                                                                Offer Price
                                                            </a>
                                                        </span>
                                                    )}
                                                    {property.status === 'available' && (
                                                        <span 
                                                            className="sales__report--status pending2 cursor-pointer" 
                                                            style={{ backgroundColor: '#008000', color: '#fff',  }}
                                                        >
                                                            <a onClick={()=>handleLink(property.slug)} 
                                                                to={`/user/cart/${property.slug}`} 
                                                                style={{ color: '#fff', textDecoration: 'none' }}
                                                            >
                                                                Buy
                                                            </a>
                                                        </span>
                                                    )}
                                                    {/* You might want a default case or to handle other statuses here */}
                                                 </td>
                                                <td>
                                                    <span className="sales__report--status pending2">
                                                        <a onClick={()=>handleLinkProperties(property.id)}>View</a>
                                                    </span>
                                                </td> 
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    );
}

// Initialize React app only once
const propertiesElement = document.getElementById('properties');
if (propertiesElement && !propertiesElement._reactRoot) {
    const root = ReactDOM.createRoot(propertiesElement);
    root.render(
        <React.StrictMode>
            <BrowserRouter>
                <Properties />
            </BrowserRouter>
        </React.StrictMode>
    );
    propertiesElement._reactRoot = true;
}
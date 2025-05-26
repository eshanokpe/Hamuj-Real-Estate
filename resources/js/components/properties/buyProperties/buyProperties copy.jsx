import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';
import {
    BrowserRouter,
    Routes,
    Route,
    useParams,
} from 'react-router-dom';

const BuyProperties = () => {
    let url = window.location.origin
    const { slug } = useParams();
    const [property, setProperty] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        if (!slug) {
            console.warn("Slug is undefined. Cannot fetch property.");
            setLoading(false);
            setError("No property identifier provided in the URL.");
            return;
        }

        const fetchProperty = async () => {
            setLoading(true);
            setError(null);
            try {
                const response = await axios.get(`${url}/user/properties-details/${slug}`);
                setProperty(response.data.property || response.data);
            } catch (err) {
                console.error('Error fetching property:', err);
                setError(err.response?.data?.message || err.message || 'Failed to fetch property details.');
                setProperty(null);
            } finally {
                setLoading(false);
            }
        };

        fetchProperty();
    }, [slug]);

    if (loading) return <p>Loading property details for "{slug}"...</p>;
    if (error) return <p>Error: {error}</p>;
    if (!property) return <p>No property found for "{slug}".</p>;

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
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Price</th>
                                            <th>Size</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                </table>
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
                                </tbody>

                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    );
};

const IndexPage = () => (
    <div style={{ padding: '2rem', textAlign: 'center' }}>
        <h2>Buy Properties</h2>
        <p>Please include a property slug in the URL (e.g. `/user/cart/buy/my-slug`).</p>
    </div>
);

const App = () => (
    <BrowserRouter basename="/user/cart/buy">
        <Routes>
            <Route index element={<IndexPage />} />
            <Route path=":slug" element={<BuyProperties />} />
        </Routes>
    </BrowserRouter>
);

// Mount to DOM
const rootEl = document.getElementById('buyProperties');
if (rootEl && !rootEl._reactRoot) {
    const root = ReactDOM.createRoot(rootEl);
    root.render(<App />);
    rootEl._reactRoot = true;
}

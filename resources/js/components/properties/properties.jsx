// RevolutPayButton.jsx
import React, { useEffect, useRef } from "react";
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from "react-router-dom";
import RevolutCheckout from "@revolut/checkout";
// import RevolutCheckout from "https://unpkg.com/@revolut/checkout/esm";
import axios from "axios";
import RevolutPayButton from "../payment/RevolutPayButton";

const Properties = () => {
  

  return (
    <div>
         <div className="dashboard__page--wrapper">
            <div className="page__body--wrapper" id="dashbody__page--body__wrapper">
                <main className="main__content_wrapper">
                    <div className="App">
                        <RevolutPayButton />
                    </div>
                </main>
            </div>
        </div>

    </div>
  );
};

export default Properties;



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
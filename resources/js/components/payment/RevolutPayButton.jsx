import React, { useEffect, useRef } from "react";
import RevolutCheckout from "https://unpkg.com/@revolut/checkout/esm";
import axios from "axios";

const RevolutPayButton = ({ amountInCents, currency }) => {
  const buttonRef = useRef(null);
  const url = window.location.origin;

  useEffect(() => {
    const initRevolut = async () => {
      try {
        // Fetch public token from your backend
        const axiosResponse = await axios.get(`${url}/user/config`); 
        const serverData = axiosResponse.data;
        const publicToken = serverData.revolutPublicKey;

        const { revolutPay } = await RevolutCheckout.payments({
          locale: "en",
          mode: "sandbox",
          publicToken: publicToken, 
        });
        console.log('amountInCents:', amountInCents);
        console.log('currency:', currency);

        const paymentOptions = {
          currency: currency, // Use the prop passed from parent
          totalAmount: amountInCents, // Use the prop passed from parent
          mobileRedirectUrls: {
            success: `${url}/user/success`,
            failure: `${url}/failure`,
            cancel: `${url}/cancel`,
          },
          webRedirectUrls: {
            success: `${url}/user/success`,
            failure: `${url}/failure`,
            cancel: `${url}/cancel`,
          },
          
          createOrder: async () => {
            const response = await axios.post(`${url}/user/api/orders`, {
              amount: amountInCents,
              currency: currency,
              name: "Wallet Top-Up",
            }, {
              headers: {
                "Content-Type": "application/json"
              }
            });
            console.log("Order created:", response.data);

            const order = await response.data;
             // Get both IDs from response
            const publicId = response.data.revolutPublicOrderId;
            const orderId = response.data.orderId;
            // Add orderId to success URL as query parameter
            // paymentOptions.webRedirectUrls.success = `${url}/user/success?_rp_oid=${publicId}&order_id=${orderId}`;
            // paymentOptions.mobileRedirectUrls.success = `${url}/user/success?_rp_oid=${publicId}&order_id=${orderId}`;
            
            return { publicId: publicId, orderId: orderId };
            // return { publicId: order.revolutPublicOrderId };
              // orderId: response.data.orderId, z
           
          },
        };

        // Mount Revolut Pay button
        revolutPay.mount(buttonRef.current, paymentOptions);

        // Handle payment events
        revolutPay.on("payment", (event) => {
          switch (event.type) {
            case "cancel":
              console.warn("Payment canceled:", event.dropOffState);
              break;
            case "success":
              console.log("Payment event:", event);
              window.location.href = `${url}/user/success&order_id=${event.orderId}`;
             
              // window.location.href = `${url}/user/success/?_rp_oid=${event}&order_id=${event.orderId}`;
              break;
            case "error":
              console.error("Payment error:", event.error);
              break;
            default:
              console.log("Unhandled event:", event);
          }
        });
      } catch (error) {
        console.error("Failed to load Revolut Pay:", error);
      }
    };

    // Only initialize if we have valid amount and currency
    if (amountInCents > 0 && currency) {
      initRevolut();
    }

    // Cleanup function
    return () => {
      if (buttonRef.current && buttonRef.current._revolutPay) {
        buttonRef.current._revolutPay.unmount();
      }
    };
  }, [amountInCents, currency, url]);

  return <div ref={buttonRef} />;
};

export default RevolutPayButton;

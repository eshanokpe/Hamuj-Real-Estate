import React, { useEffect, useRef } from "react";
// import RevolutCheckout from "@revolut/checkout";
import RevolutCheckout from "https://unpkg.com/@revolut/checkout/esm";
import axios from "axios";


const RevolutPayButton = () => {
  const buttonRef = useRef(null);
  const url = window.location.origin;

  useEffect(() => {
    const initRevolut = async () => {
      try {
        // Fetch public token from your backend
        const axiosResponse = await axios.get(`${url}/user/config`); 
        console.log("Full Axios response from /user/config:", axiosResponse);

        const serverData = axiosResponse.data;
        const publicToken = serverData.revolutPublicKey;
        console.log("(from serverData.revolutPublicKey):", publicToken);

        const { revolutPay } = await RevolutCheckout.payments({
          locale: "en", // Optional, default is "auto"
          mode: "sandbox", // Use "prod" for production
        //   publicToken: 'pk_Gjk5dYEZjkHeJqgrzfMeSYhy2deEQkD0r1zhrGLGAKuurOyV', // Replace with your actual public token
          publicToken: publicToken, 
        });

        const paymentOptions = {
          currency: "GBP", // e.g. "GBP"
          totalAmount: 1000, // e.g. $10.00 in cents
          mobileRedirectUrls: {
            success: `${url}/success`,
            failure: `${url}/failure`,
            cancel: `${url}/cancel`,
          },
          webRedirectUrls: {
            success: `${url}/success`,
            failure: `${url}/failure`,
            cancel: `${url}/cancel`,
          },

          redirectUrls: {
            success: `${url}/user/success`,
            failure: `${url}/failure`,
            cancel: `${url}/cancel`,
          },

          createOrder: async () => {
            const response = await axios.post(`${url}/user/api/orders`, {
              amount: 1000,
              currency: "GBP",
              name: "Demo Product",
            },{
                headers: {
                    "Content-Type": "application/json"
                }
            });
            console.log("Order created:", response.data);
            // alert("Order created:", response.data);


            return { publicId: response.data.revolutPublicOrderId };
          },
        };

        // Mount Revolut Pay button
        revolutPay.mount(buttonRef.current, paymentOptions);

        // Handle Revolut payment events
        revolutPay.on("payment", (event) => {
          switch (event.type) {
            case "cancel":
              if (event.dropOffState === "payment_summary") {
                console.warn("Payment was canceled at summary stage.");
              } else {
                console.warn("Payment was canceled.");
              }
              break;

            case "success":
              console.log("Payment successful!");
              // You can trigger your success flow here
              break;

            case "error":
              console.error("Payment error:", event.error);
              // Handle error scenario here
              break;

            default:
              console.log("Unhandled event:", event);
          }
        });
      } catch (error) {
        console.error("Failed to load Revolut Pay:", error);
      }
    };

    initRevolut();
  }, []);

  return (
    <div>
      <h2>Pay with Revolut</h2>
      <div ref={buttonRef} />
    </div>
  );
};

export default RevolutPayButton;

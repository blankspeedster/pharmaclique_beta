import { captureUrl } from "./environment.js";

export const order = (amount) => {
  const payload = {
    intent: "CAPTURE",
    purchase_units: [
      {
        amount: {
          currency_code: "PHP",
          value: amount,
        },
        description: "Payment for Product A",
        soft_descriptor: "Payment for Product A",
      },
    ],
    application_context: {
      return_url: captureUrl,
    },
  };

  axios
    .post("https://api.sandbox.paypal.com/v2/checkout/orders", payload)
    .then((response) => {
      
        // checkout link
      const checkoutLink = response.data.links[1].href;

      // capture payment link
      const captureLink = response.data.links[3].href;

      window.localStorage.setItem("paypal_capture_link", captureLink);

      window.open(
        checkoutLink,
        "_blank",
        "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=500,width=500,height=600"
      );
    });
};

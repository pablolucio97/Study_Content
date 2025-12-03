# Steps to implementing Stripe on a NextJS project

1. Create the product on Stripe dashboard and save its id to be used hereafter in the checkout session.
2. Save the environment  variables for your products_id, Stripe secret key and Stripe Publishable Key (this one can be used on front-end).	
3. Install the  Stripe’s CLI  and log into it. Add a new development mode web hook pointing to your application and route. Example: `stripe listen --forward-to http://localhost:3000/api/stripe/webhook
4. Copy the web hook secret generated from step 3 and add it as environment variable.
5. Install the Stripes libs stripe (for back-end) and @stripe/stripe-js (for client).
6. Create a folder named lib inside the src folder, and a file named `stripe.ts` inside the `lib folder. This file must return a new Stripe instance passing your secret key.
7. Inside app/api folder, create a new folder named as “stripe”, and inside it a new folder named “create-checkout”, and a file named “route.ts”. This file must return an asynchronous POST  function to creating a new checkout on Stripe passing your products and costumer data returning the session data.
8. Create a useStripe hook instancing stripe client containing the Stripe methods you need to handle in your application, like createCheckout and so on.
9. Inside the stripe folder, create a folder named “webhook”, and file named “ “route.ts””. This file must exports an asynchronous POST function listening to desired stripe events and doing what you need on your system.
10. In a isolated terminal, run the command `stripe listen --forward-to http://localhost:3000/api/stripe/webhook`, and test buying a product to see the events stripe will return. 

Observations:
- When reporting usage (meters), you use the Subscription Item ID, not the Price ID directly.
- Local stripe webhook must always  be listening to events if some action on your software depends on Stripe’s events.
- Card to use on test transactions on Stripe: 4242424242424242 12/34 567
- Pay attenttion on using the correct Stripe webhook environmant variable for local and production, otherwise the webhook event listener will fail.
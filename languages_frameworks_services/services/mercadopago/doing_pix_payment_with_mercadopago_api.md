# Integrating MercadoPago PIX Payments

This guide explains how to integrate PIX payments using MercadoPago in a Next.js application.

---

## 1. Create a MercadoPago Application

- Log into your [MercadoPago](https://www.mercadopago.com.br/) account.
- Go to **Your Apps** and create a **new application**.

---

## 2. Set Up Credentials

Collect all your application credentials and store them in a `.env` file:

```
MERCADO_PAGO_CLIENT_ID=your_client_id
MERCADO_PAGO_CLIENT_SECRET=your_client_secret
MERCADO_PAGO_TEST_PUBLIC_KEY=your_test_public_key
MERCADO_PAGO_TEST_ACCESS_TOKEN=your_test_access_token
MERCADO_PAGO_PROD_PUBLIC_KEY=your_prod_public_key
MERCADO_PAGO_PROD_ACCESS_TOKEN=your_prod_access_token
```

---

## 3. Create a Payment API Route

Create a file in your API routes (e.g., `pages/api/payments-pix.ts`) and paste the following:

`import { NextApiRequest, NextApiResponse } from "next"`  
`import MercadoPago from "mercadopago"`

`interface PaymentDataProps {`  
&nbsp;&nbsp;`transaction_amount: number;`  
&nbsp;&nbsp;`description: string;`  
&nbsp;&nbsp;`payment_method_id: "pix";`  
&nbsp;&nbsp;`payer: {`  
&nbsp;&nbsp;&nbsp;&nbsp;`email: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;`first_name: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;`last_name: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;`identification: { type: string; number: string };`  
&nbsp;&nbsp;&nbsp;&nbsp;`address: {`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`zip_code: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`street_name: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`street_number: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`neighborhood: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`city: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`federal_unit: string;`  
&nbsp;&nbsp;&nbsp;&nbsp;`};`  
&nbsp;&nbsp;`};`  
`}`

`export default async function (req: NextApiRequest, res: NextApiResponse) {`  
&nbsp;&nbsp;`if (req.method === "POST") {`  
&nbsp;&nbsp;&nbsp;&nbsp;`MercadoPago.configurations.setAccessToken(process.env.MERCADO_PAGO_TEST_ACCESS_TOKEN);`  
&nbsp;&nbsp;&nbsp;&nbsp;`try {`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`const { transaction_amount, description, payer }: PaymentDataProps = req.body;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`let paymentResponse = { qrCode: "", paymentLink: "" };`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`await MercadoPago.payment.create({`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`transaction_amount,`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`description,`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`payment_method_id: "pix",`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`payer,`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`installments: 0,`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`}).then((res) => {`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`paymentResponse.qrCode = res.body.point_of_interaction.transaction_data.qr_code_base64;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`paymentResponse.paymentLink = res.body.point_of_interaction.transaction_data.qr_code;`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`});`  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`return res.status(201).send(paymentResponse);`  
&nbsp;&nbsp;&nbsp;&nbsp;} catch (error) {  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`console.log(error);`  
&nbsp;&nbsp;&nbsp;&nbsp;}  
&nbsp;&nbsp;} else {  
&nbsp;&nbsp;&nbsp;&nbsp;`res.send("METHOD NOT ALLOWED");`  
&nbsp;&nbsp;}  
`}`

---

## 4. Call the API Route in Your App

Make a POST request to generate the QR Code and update state:

```
import api from '../services/api'

async function handlePayWithPix() {
  setLoading(true)

  const timer = setTimeout(() => {
    setLoading(false)
    handleOpenPixModal()
  }, 2000)

  const paymentData = {
    transaction_amount: 5.50,
    description: 'Plano Master',
    payer: {
      email: 'test@test.com',
      first_name: 'Test',
      last_name: 'User',
      identification: {
        type: 'CPF',
        number: '19119119100'
      },
      address: {
        zip_code: '06233200',
        street_name: 'Av. das Nações Unidas',
        street_number: '3003',
        neighborhood: 'Bonfim',
        city: 'Osasco',
        federal_unit: 'SP'
      }
    }
  }

  await api.post('/payments-pix', paymentData)
    .then(res => updatePayment(res.data.qrCode, res.data.paymentLink))

  return () => clearTimeout(timer)
}

async function updatePayment(qrCode: string, paymentLink: string) {
  setQrCode(qrCode)
  setPaymentLink(paymentLink)
}
```

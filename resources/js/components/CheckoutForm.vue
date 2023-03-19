<template>
    <div class="payment-form">
        <div class="card">
            <div>
                <form class="payment-form" @submit.prevent="submitPayment">
                    <div class="form-group">
                        <label for="card-element">Card Information</label>
                        <div id="card-element"></div>
                    </div>

                    <div class="form-group">
                        <label>
                            Name on card
                            <input type="text" v-model="billingDetails.name">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Email address
                            <input type="email" v-model="billingDetails.email">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            Billing address
                            <input type="text" v-model="billingDetails.address">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            City
                            <input type="text" v-model="billingDetails.city">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            State
                            <input type="text" v-model="billingDetails.state">
                        </label>
                    </div>
                    <div class="form-group">

                        <label>
                            Postal code
                            <input type="text" v-model="billingDetails.postalCode">
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Country
                            <input type="text" v-model="billingDetails.country">
                        </label>
                    </div>
                    <div>
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" v-model="billingDetails.amount">
                    </div>
                    <div>
                        <label for="currency">Currency:</label>
                        <select id="currency" v-model="currency">
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                        </select>
                    </div>
                    <button type="submit">Pay</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';

export default {
    name: "CheckoutForm",
    data() {
        return {
            stripe: null,
            cardElement: null,
            billingDetails: {
                name: '',
                email: '',
                address: '',
                city: '',
                state: '',
                postalCode: '',
                country: '',
            },
            currency: 'eur',
        };
    },
    async mounted() {
        this.stripe = await loadStripe('pk_test_51MWf28KfQxRkIXlXqkN0uipSjX7SdJ0gA4bwe23NJAfTwnwfVTNMLt0H3qzCV9oI3q240IFoxusnwKAbzDlLT0q100a6qWZDQg');

        console.log('stripe', this.stripe);

        this.cardElement = this.stripe.elements().create('card');
        this.cardElement.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        this.cardElement.addEventListener("change", (event) => {
            if (event.error) {
                this.paymentError = event.error.message;
            } else {
                this.paymentError = "";
            }
        });
    },

    methods: {
        async submitPayment() {
            const { token, error } = await this.stripe.createToken(this.cardElement, this.billingDetails);

            if (error) {
                console.error(error);
                return;
            }

            const response = await fetch('/api/process-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    token: token.id,
                    amount: 1000,
                    currency: this.currency,
                    billingDetails: this.billingDetails,
                }),
            });

            if (response.ok) {
                console.log('Payment processed successfully');
            } else {
                console.error('Error processing payment');
            }
        },
    },
}
</script>

<style scoped>
    .payment-form {
        max-width: 500px;
        margin: auto;
        display: flex;
        flex-direction: column;
    }

    .form-control {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input {
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 8px;
        font-size: 16px;
        width: 100%;
    }

    button[type="submit"] {
        background-color: #6772e5;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 12px;
        font-size: 16px;
        cursor: pointer;
    }
</style>



<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <div>
                <label for="name">Full Name:</label>
                <input type="text" id="name" v-model="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" v-model="line1" required>
            </div>
            <div>
                <label for="city">City:</label>
                <input type="text" id="city" v-model="city" required>
            </div>
            <div>
                <label for="country">Country:</label>
                <input type="text" id="country" v-model="country" required>
            </div>
            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element" ref="cardElement"></div>
                <div id="card-errors" role="alert"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';

export default {
    data() {
        return {
            name: '',
            email: '',
            line1: '',
            city: '',
            country: '',
            stripe: null,
            cardElement: null,
            clientSecret: '',
        }
    },

    async mounted() {
        // Load Stripe.js
        const stripe = await loadStripe('pk_test_51MWf28KfQxRkIXlXqkN0uipSjX7SdJ0gA4bwe23NJAfTwnwfVTNMLt0H3qzCV9oI3q240IFoxusnwKAbzDlLT0q100a6qWZDQg')
        this.stripe = stripe

        // Create a Stripe Element
        this.cardElement = this.stripe.elements().create('card');
        this.cardElement.mount(this.$refs.cardElement);
    },

    methods: {
        async handleSubmit() {
            // Retrieve the payment method ID from Stripe Element
            const { paymentMethod } = await this.stripe.createPaymentMethod({
                type: 'card',
                card: this.cardElement,
            });


            // Make a request to your Laravel backend to retrieve the client secret
            const response = await fetch('/api/payment-intents', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                    amount: 1000, // Change this to the amount you want to charge in cents,
                    name: this.name,
                    email: this.email,
                    line1: this.line1,
                    city: this.city,
                    country: this.country,
                }),
            });

            const { client_secret } = await response.json();
            this.clientSecret = client_secret;

            // Confirm the payment with Stripe using the client secret
            const { paymentIntent } = await this.stripe.confirmCardPayment(this.clientSecret, {
                payment_method: paymentMethod.id,
            });

            alert('Payment successfully')
            console.log({paymentIntent});
        },
    },
}
</script>

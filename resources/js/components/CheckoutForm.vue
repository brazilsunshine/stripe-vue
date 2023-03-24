<template>
    <div class="container d-flex justify-content mt-5">
        <div>
            <stripe-checkout
                ref="checkoutRef"
                :pk="publishableKey"
                :sessionId="sessionId"
            />
            <button
                @click="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
                One time purchase
            </button>
        </div>
    </div>
</template>

<script>
import { StripeCheckout } from '@vue-stripe/vue-stripe';

export default {
    name: "CheckoutForm",
    components: {
        StripeCheckout,
    },
    data() {
        return {
            publishableKey: 'pk_test_51MWf28KfQxRkIXlXqkN0uipSjX7SdJ0gA4bwe23NJAfTwnwfVTNMLt0H3qzCV9oI3q240IFoxusnwKAbzDlLT0q100a6qWZDQg',
            sessionId: null,
        };
    },
    mounted() {
        console.log('component mounted');
        this.getSession();
    },
    methods: {
        async getSession () {
           await axios.get('/getSession')
            .then(response => {
                console.log('get-session', response);
                if (response.data.success)
                {
                    this.sessionId = response.data.checkout.id
                }
             })
            .catch(error => {
                console.log('get-session', error);
            });
        },
        submit () {
            // You will be redirected to Stripe's secure checkout page
            this.$refs.checkoutRef.redirectToCheckout();
        },

    },
}
</script>

<style scoped>

</style>


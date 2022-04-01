<template>
    <div class="card bg-white">
        <div v-show="orders.length">
            <ul v-for="order in orders">
                <li>
                    {{ order.code }}
                </li>
            </ul>
        </div>
        <div v-show="! orders.length" class="text-center text-neutral-400">No data provided.</div>
    </div>
</template>

<script>
export default {
    async mounted () {
        this.orders = await axios.get(this.listingRoute)
            .then(res => res.data)
            .then(res => res.data)
            .then(res => {
                this.isCompleted = true;
                return res;
            });
    },

    data() {
        return {
            isCompleted: false,
            orders: []
        }
    },

    methods: {
        concat (orders) {
            this.orders = this.orders.concat(orders);
        }
    },

    props: {
        listingRoute: { type: String, required: true }
    }
}
</script>

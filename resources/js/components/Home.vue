<template>
    <div class="my-40 mx-auto w-4/12">
        <add-order @add="pushOrdersToList" :add-route="addRoute" :csrf-token="csrfToken"></add-order>
        <list-order ref="list" :listing-route="listingRoute"></list-order>
    </div>
</template>

<script>

import List from "./orders/List";

export default {
    mounted() {
        console.log('Component mounted.')
    },

    components: {
        'list': List
    },

    methods: {
        pushOrdersToList(orders) {
            this.$refs.list.concat(orders);
        },
    },

    props: {
        listingRoute: { type: String, required: true },
        addRoute: { type: String, required: true },
        csrfToken: { type: String, required: true },
    }
}
</script>

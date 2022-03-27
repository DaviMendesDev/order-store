<template>
    <div class="my-40 mx-auto w-4/12">
        <add-order :add-route="addRoute" :csrf-token="csrfToken"></add-order>
        <list-order :listing-route="listingRoute"></list-order>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },

    props: {
        listingRoute: { type: String, required: true },
        addRoute: { type: String, required: true },
        csrfToken: { type: String, required: true },
    }
}
</script>

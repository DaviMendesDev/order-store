<template>
    <li>
        <div class="py-6 hover:bg-neutral-100 cursor-pointer" @click="order.visible = ! order.visible">
            <div class="text-neutral-500 text-sm relative mx-4 select-none">
                <span class="text-md mr-4">order code: </span>
                {{ order.code }}
                <span class="d-inline-block absolute right-0">
                    <font-awesome-icon :icon="'fa-solid ' + (order.visible ? 'fa-chevron-up' : 'fa-chevron-down')"></font-awesome-icon>
                </span>
            </div>
        </div>
        <div v-if="order.visible" class="bg-neutral-100">
            <div class="bg-yellow-50 mx-6 border-x-1 px-4 divide-y divide-neutral-300">
                <div v-for="product in order.products" class="py-2">
                    <span class="text-sm mr-2 text-neutral-300">article code:</span>
                    {{ product.article_code }}

                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },

    props: ['order'],
}
</script>

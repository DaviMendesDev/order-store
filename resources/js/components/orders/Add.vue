<template>
    <div class="card bg-white">
        <div>
            <form :action="addRoute" @submit.prevent="saveNewOrder">
                <input type="hidden" :value="csrfToken">
                <div class="relative h-8 mb-4 mx-2">
                    <button @click="addOrder"
                            class="inline-block rounded absolute right-0 top-0 text-white bg-neutral-300 px-3 font-bold shadow hover:shadow-xl w-10"
                            type="button"
                    >+</button>
                </div>
                <div :class="'max-h-80 overflow-y-auto custom-scroller ' + (orders.length ? 'divide-y divide-neutral-300' : '')">
                    <div></div>
                    <div v-for="(order, index) in orders" :key="'index-' + index">
                        <div class="relative py-4">
                            <div class="h-8">
                                <button @click="removeOrderItem(index)"
                                        class="inline-block rounded absolute right-0 text-white bg-red-400 px-3 w-10 font-bold shadow hover:shadow-xl mx-2"
                                        type="button"
                                >-</button>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="label-input-group">
                                    <label :for="'code-' + index">Article code</label>
                                    <input :id="'code-' + index" type="text" v-model="order.article_code" class="input numbers-only" v-mask="'#####'" placeholder="Ex.: 12345">
                                </div>

                                <div class="label-input-group">
                                    <label :for="'name-' + index">Article name</label>
                                    <input :id="'name-' + index" type="text" v-model="order.article_name" class="input" placeholder="Ex.: Any Name">
                                </div>
                            </div>

                            <div class="label-input-group">
                                <label :for="'unitPrice-' + index">Unit price</label>
                                <money :id="'unitPrice-' + index" type="text" class="input" v-model="order.unit_price" v-bind="moneyFormat"  placeholder="Ex.: R$ 80,99"></money>
                            </div>

                            <div class="label-input-group">
                                <label :for="'quantity-' + index">Quantity</label>
                                <input :id="'quantity-' + index" type="text" v-model="order.quantity" class="input" v-maska="{ mask: '#*' }" placeholder="Ex.: 3">
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>
                <button class="text-center block w-full ">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script>
import { Money } from 'v-money'

export default {
    components: {
        Money
    },

    data () {
        return {
            orders: [],
            moneyFormat: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
        }
    },

    methods: {
        saveNewOrder () {
            axios.post(this.addRoute, {
                orders: this.orders,
                _token: this.csrfToken
            });
        },

        removeOrderItem (index) {
            this.orders.splice(index, 1);
        },

        addOrder () {
            this.orders.push({
                article_code: null,
                article_name: null,
                unit_price: null,
                quantity: null,
            });
        },
    },

    props: {
        addRoute: { type: String, required: true },
        csrfToken: { type: String, required: true },
    },
}
</script>

<style scoped>

</style>

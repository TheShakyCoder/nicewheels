<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Purchases
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-left">Reference</th>
                            <th>Tokens Bought</th>
                            <th>Tokens Remaining</th>
                            <th>Purchase Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions">
                                <td>{{ transaction.created_at }}</td>
                                <td>{{ transaction.reference }}</td>
                                <td class="text-center">{{ transaction.tokens }}</td>
                                <td class="text-center">{{ transaction.remaining }}</td>
                                <td class="text-center">{{ amount(transaction.amount) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            transactions: {
                type: Object,
                default: null
            }
        },
        methods: {
            amount (val) {
                var formatter = new Intl.NumberFormat('en-GB', {
                    style: 'currency',
                    currency: 'GBP',
                    maximumFractionDigits: 0
                });
                return formatter.format(val)
            }
        }
    }
</script>

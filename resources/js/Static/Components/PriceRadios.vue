<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <RadioGroup v-model="selected">
        <RadioGroupLabel class="sr-only">
            Tokens
        </RadioGroupLabel>
        <div class="space-y-4">
            <RadioGroupOption as="template" v-for="plan in plans" :key="plan.name" :value="plan" v-slot="{ active, checked }">
                <div class="flex justify-between" :class="[active ? 'ring-1 ring-offset-2 ring-indigo-500' : '', 'relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between focus:outline-none']">
                    <div class="flex items-center">
                        <div class="text-sm">
                            <RadioGroupLabel as="p" class="text-lg font-medium text-gray-900">
                                {{ plan.name }}
                            </RadioGroupLabel>
                            <RadioGroupDescription as="div" class="text-gray-500">
                                <p class="sm:inline">
                                    {{ plan.tokens }} Tokens / {{ plan.each }} each
                                </p>
                            </RadioGroupDescription>
                        </div>
                    </div>
                    <RadioGroupDescription as="div" class="mt-2 flex text-3xl sm:mt-0 sm:block sm:ml-4 sm:text-right">
                        <div class="font-bold text-cyan-700">£{{ plan.price }}</div>
                        <div class="ml-1 text-gray-500 sm:ml-0"></div>
                    </RadioGroupDescription>
                    <div :class="[checked ? 'border-indigo-500' : 'border-transparent', 'absolute -inset-px rounded-lg border-2 pointer-events-none']" aria-hidden="true" />
                </div>
            </RadioGroupOption>
        </div>
    </RadioGroup>
</template>

<script>
import { ref } from 'vue'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'

const plans = [
    { name: 'Starter', tokens: '5', each: '20p', price: '1' },
    { name: 'Value', tokens: '20', each: '10p', price: '2' },
    { name: 'Refill', tokens: '50', each: '6p', price: '3' }
]

export default {
    components: {
        RadioGroup,
        RadioGroupDescription,
        RadioGroupLabel,
        RadioGroupOption,
    },
    setup() {
        const selected = ref(plans[0])

        return {
            plans,
            selected,
        }
    },
    watch: {
        selected (n, o) {
            console.log(n)
            this.$emit('price', n)
        }
    }
}
</script>

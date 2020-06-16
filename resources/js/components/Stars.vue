<template>
    <div :class="classes">
        <i
            v-for="index in 5"
            :key="index"
            class="stars__star icon icon-star"
            :class="{ 'star--is-active': index <= value }"
            @click="$emit('input', index)"
        ></i>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Number,
            default: 0,
            validator: value => value >= 0 && value <= 5,
        },

        readonly: { type: Boolean, default: true },
    },

    computed: {
        classes() {
            const { value } = this
            let [unit, decimal] = value.toFixed(1).split('.').map(Number)

            if (decimal >= 7) {
                decimal = 0
                ++unit
            }

            const stars = unit + (decimal > 0 ? '-half' : '')

            return [
                'stars',
                `stars--${stars}`,
                this.readonly && 'stars--is-readonly',
            ]
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.stars__star {
    color: color('gray', 50);
    font-size: 1.5rem;
    cursor: pointer;

    .stars:not(.stars--is-readonly) & {
        &::before {
            transition: transform 0.2s ease-out;
        }
        &:hover::before {
            transform: scale(1.5) !important;
        }
    }
}

.stars--is-readonly .stars__star {
    font-size: 1.25rem;
    cursor: inherit;
}

.star--is-active {
    color: color('primary');
}
</style>

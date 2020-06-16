<template>
    <div class="time-line">
        <div
            class="time-line__step"
            :class="{ 'step--is-active': index <= steps[now] }"
            v-for="(value, key, index) in steps"
            :key="index"
        >
            <span class="step__dot">
                {{ value + 1 }}
            </span>

            <p class="step__label">{{ lang(key) }}</p>
        </div>

        <span class="time-line__line" data-line></span>
        <span class="time-line__shadow"></span>
    </div>
</template>

<script>
const STEPS = {
    creation: 0,
    review: 1,
    checkout: 2,
    class: 3,
}

const SPANISH = {
    creation: 'Crea tu propuesta',
    review: 'Revisa tu propuesta',
    checkout: 'Pago',
    class: 'Ver clase',
}

export default {
    props: {
        now: String,
        default: 'creation',
        validator: value => Object.keys(STEPS).includes(value),
    },

    mounted() {
        const steps = STEPS
        const last = Object.keys(steps).pop()
        const max = steps[last]
        const now = steps[this.now]

        const percent = (now / max) * 100

        const line = this.$el.querySelector('[data-line]')
        line.style.width = percent + '%'
    },

    computed: {
        steps: () => STEPS,
    },

    methods: {
        lang: key => SPANISH[key],
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

$gray: tint(color('gray', 50), 60%);

.time-line {
    position: relative;
    display: flex;
    justify-content: space-between;
    margin-bottom: 3.5rem;
}

.time-line__line,
.time-line__shadow {
    $thickness: 5px;

    position: absolute;
    height: $thickness;
    top: calc(50% - #{$thickness / 2});
    left: 0;
}

.time-line__shadow {
    width: 100%;
    background: $gray;
    z-index: -2;
}

.time-line__line {
    background: color('primary');
    z-index: -1;
}

.time-line__step {
    position: relative;
}

.step__dot {
    $size: 45px;

    @include size($size);

    display: block;
    margin: 0 auto;
    border-radius: 50%;
    background: color('white');
    border: 2px solid $gray;
    color: color('gray', 200);
    font-size: 1.2rem;
    font-weight: get('bold', $font-weights);
    text-align: center;
    line-height: $size;

    .step--is-active & {
        color: color('primary');
        border-color: color('primary');
    }
}

.step__label {
    position: absolute;
    bottom: -1.5rem;
    left: 50%;

    text-align: center;
    white-space: nowrap;
    color: color('gray');

    transform: translateX(-50%);

    .step--is-active & {
        color: color('primary');
        font-weight: get('bold', $font-weights);
    }
}
</style>

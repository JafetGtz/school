<template>
    <div class="scores row">
        <div
            v-for="(value, key, index) in scores"
            :key="index"
            class="col-xs-6 col-sm-4 scores__item"
        >
            <span class="item__value">{{ value }} </span>
            <p class="item__label">{{ key }}</p>
        </div>
    </div>
</template>

<script>
export default {
    // functional: true,

    props: {
        scores: {
            type: Object,
            required: true,
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.scores {
    justify-content: center;
}

.scores__item {
    text-align: center;
    padding: 0.5rem 0;

    $border-style: 1px solid color('gray', 50);

    &:first-child {
        border-right: $border-style;
    }

    @include breakpoint('sm') {
        padding-left: 2rem;
        padding-right: 2rem;

        border-right: $border-style;
        &:last-child {
            border: 0;
        }
    }
}

.item__value {
    font-size: 2rem;
    font-weight: get('bold', $font-weights);

    @include breakpoint('sm') {
        font-size: 2.5rem;
    }
}
</style>

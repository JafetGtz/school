<template>
    <div v-show="$data._isVisible">
        <div class="modal">
            <div class="modal__container">
                <button class="modal__x" @click="doClose">
                    <i class="icon icon-x"></i>
                </button>

                <div class="modal__body row">
                    <figure class="modal__image image">
                        <img :src="teacher.avatar" />
                    </figure>

                    <div class="modal__content">
                        <h2 class="modal__title">
                            {{ teacher.first_name }} {{ teacher.last_name }}
                        </h2>
                        <Stars :value="teacher.stars" />
                    </div>
                </div>

                <Scores
                    class="margin-top--two"
                    :scores="teacher.scores || {}"
                />

                <Button
                    class="modal__button"
                    @click="$emit('click', $event)"
                    block
                    >Contratar</Button
                >
            </div>
        </div>

        <span class="overlay" @click="doClose"></span>
    </div>
</template>

<script>
export default {
    props: {
        teacher: {
            required: true,
            type: Object,
        },

        isVisible: Boolean,
    },

    data: ({ isVisible }) => ({ _isVisible: isVisible }),

    watch: {
        isVisible(value) {
            value ? this.doShow() : this.doClose()
        },
    },

    methods: {
        doShow() {
            this.$data._isVisible = true
            document.body.style.overflowY = 'hidden'
            this.$emit('show')
        },

        doClose() {
            this.$data._isVisible = false
            document.body.style.overflowY = 'auto'
            this.$emit('close')
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.modal,
.overlay {
    @include position(fixed, 0, 0);
    @include size(100vw, 100vh);
}

.modal {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    z-index: get('modal', $z-layers);
    pointer-events: none;
    overflow: auto;
}

.modal__container {
    max-width: 90vw;
    position: relative;
    border-radius: 10px;
    background: color('white');
    pointer-events: all;
    padding: 2rem 1rem 1rem;

    @include breakpoint('sm') {
        padding: 2rem 2.5rem;
    }
}

.modal__x {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.75rem;
    color: color('gray', 400);
}

.modal__body {
    display: flex;
    flex-flow: column;
    justify-content: center;
    align-items: center;

    @include breakpoint('sm') {
        flex-flow: row;
        justify-content: flex-start;
        align-items: flex-start;
    }
}

.modal__content {
    text-align: center;
    @include breakpoint('sm') {
        text-align: left;
    }
}

.modal__image {
    @include size(180px);

    border-radius: 10px;
    margin-right: 2rem;
    margin-bottom: 0.75rem;
    background: color('gray', 50);

    @include breakpoint('md') {
        @include size(220px);
    }
}

.modal__title {
    margin-bottom: 0;
}

.modal__button {
    margin-top: 2rem;
}

.overlay {
    background: color('black', 500, 0.5);
    z-index: get('overlay', $z-layers);
}
</style>

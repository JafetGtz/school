<template>
    <div class="file" :class="[`file--is-${type}`]">
        <div class="file__container">
            <div>
                <i class="file__icon icon" :class="`icon-file-${type}`"></i>
            </div>

            <p class="file__name">
                {{ file.name }}
            </p>

            <div class="file__controls">
                <span class="file__size"> {{ formatSize(file.size) }} </span>

                <i
                    v-if="!readonly"
                    class="icon icon-x"
                    @click="$emit('remove')"
                    title="Remover"
                ></i>

                <a
                    v-else
                    :href="file.path"
                    :download="file.name"
                    target="_blank"
                    rel="noopener noreferrer"
                    title="Descargar"
                >
                    <i class="icon icon-download"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            type: [File, Object],
            required: true,
        },

        readonly: Boolean,
    },

    methods: {
        formatSize(bytes) {
            let unit = 'KB'
            let formatted = bytes / 1024

            if (formatted >= 700) {
                formatted /= 1024
                unit = 'MB'
            }

            return formatted.toFixed(1) + unit
        },
    },

    computed: {
        type() {
            const { type } = this.file

            if (type.includes('image')) return 'image'
            if (type.includes('pdf')) return 'pdf'
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.file:not(:last-child) {
    border-bottom: 1px solid color('gray', 100);
}

.file__container {
    padding: 0.75rem;
}

.file__container,
.file__controls {
    display: flex;
    align-items: center;
}

.file__icon {
    font-size: 2rem !important;

    .file--is-image & {
        color: color('orange');
    }

    .file--is-pdf & {
        color: color('red');
    }
}

.file__name {
    @include ellipsis;

    max-width: 100%;
    padding: 0 0.75rem;
    flex-grow: 1;
}

.file__size {
    color: color('gray', 300);
    padding: 0 1rem;
    margin-right: 0.5rem;
    border-right: 1px solid color('gray', 100);
}

.file__controls .icon {
    font-size: get('large', $font-sizes);
    cursor: pointer;
}

.icon-x {
    color: color('red');
}
</style>

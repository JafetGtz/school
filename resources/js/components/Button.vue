<script>
export default {
    functional: true,

    props: {
        color: {
            type: String,
            default: 'primary',
        },
        type: {
            type: String,
            validator: value => ['button', 'submit', 'reset'].includes(value),
            default: 'button',
        },
        to: [String, Object],
        href: String,
        outline: Boolean,
        rounded: Boolean,
        flat: Boolean,
        loading: Boolean,
        disabled: Boolean,
        block: Boolean,
    },

    render(h, { props, children, data }) {
        const classes = {
            button: true,
            [`button--${props.color}`]: true,
            'button--disabled': props.disabled,
            'button--rounded': props.rounded,
            'button--loading': props.loading,
            'button--outline': props.outline,
            'button--flat': props.flat,
            'button--block': props.block,
        }

        const tagname = props.href ? 'a' : 'button'
        return h(
            tagname,
            {
                ...data,
                class: classes,
                attrs: {
                    type: tagname === 'button' && props.type,
                    disabled: props.disabled || props.loading,
                    href: props.href,
                },
            },
            [
                props.loading && h('span', { class: 'button__loader' }),
                ...children,
            ]
        )
    },
}
</script>

<style lang="scss">
@import '~@/sass/_globals.scss';

.button {
    position: relative;
    display: inline-block;
    border: $button-border-width solid color('gray');
    border-radius: $button-border-radius;
    padding: $button-padding;
    height: $button-height;
    vertical-align: middle;

    text-align: center;
    line-height: $button-height;
    text-transform: uppercase;
    font-family: $button-font-family;
    font-size: $button-font-size;
    font-weight: $button-font-weight;

    overflow: hidden;
    cursor: pointer;
    -webkit-appearance: none;
    -webkit-tap-highlight-color: transparent;
    -webkit-user-select: none;

    & + & {
        margin-left: get('halve', $spacers);
    }
}

.button--rounded {
    border-radius: 50px;
    padding: 0 25px;
}

.button--loading {
    color: transparent !important;
    cursor: wait;
}

.button__loader {
    $size: $button-height / 2;

    @include position(
        absolute,
        calc(50% - #{$size / 2}),
        calc(50% - #{$size / 2})
    );
    @include size($size);

    border-radius: 50%;
    background: transparent;
    border: color('black') 3px solid;
    border-top-color: transparent !important;
    animation: spin 0.9s linear infinite;
    pointer-events: none;

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
}

.button--block {
    display: block;
    width: 100%;
}

.button--disabled {
    background: color('gray') !important;
    border-color: color('gray') !important;
    pointer-events: none;
    cursor: default;
}

@mixin button-variant($background) {
    $hover-background: tint($background, 10%);
    $color: yiq($background);

    color: $color;
    background-color: $background;
    border-color: $background;

    .button__loader {
        border-color: $color;
    }
}

@mixin button-outline-variant($color) {
    color: $color;
    background: transparent;
    border-color: $color;

    .button__loader {
        border-color: $color;
    }
}

@mixin button-flat-variant($color) {
    color: $color;
    border-color: transparent;
    background: transparent;

    .button__loader {
        border-color: $color;
    }
}

@each $color, $value in $palette {
    .button--#{$color} {
        @include button-variant($value);
    }
    .button--outline.button--#{$color} {
        @include button-outline-variant($value);
    }
    .button--#{$color}.button--flat {
        @include button-flat-variant($value);
    }
}
</style>

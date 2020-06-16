<template>
    <div :class="classes">
        <label class="checkbox__container">
            <input
                type="checkbox"
                :value="value"
                :disabled="isDisabled"
                :checked="isChecked"
                v-bind="$attrs"
                v-on="listeners"
                data-test="checkbox"
            />
            <span class="checkbox__box" />
            <span class="checkbox__label" data-test="label">{{ label }}</span>
        </label>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,

    model: { prop: 'model' },

    props: {
        label: String,
        value: [String, Number, Boolean],
        model: {
            validator: value =>
                value === null ||
                typeof value === 'boolean' ||
                Array.isArray(value),
        },
        checked: Boolean,
        disabled: Boolean,
    },

    data: self => ({ shouldBeChecked: self.checked }),

    watch: {
        checked(value, old) {
            if (value !== old) this.shouldBeChecked = value
        },
    },

    methods: {
        handleChange() {
            let value = this.innerValue

            if (this.shouldBeChecked) this.shouldBeChecked = false

            if (this.value) {
                if (!Array.isArray(value)) value = []
                if (this.isChecked) value.splice(value.indexOf(this.value), 1)
                else value.push(this.value)
                this.$emit('change', this.isChecked ? null : this.value)
            } else {
                value = !value
                this.$emit('change', value)
            }

            if (this.CheckboxGroup) this.CheckboxGroup.handleChange(value)
            else this.$emit('input', value)
        },
    },

    computed: {
        classes() {
            return {
                checkbox: true,
                'checkbox--is-checked': this.isChecked,
                'checkbox--is-disabled': this.isDisabled,
            }
        },

        listeners() {
            return {
                ...this.$listeners,
                change: this.handleChange,
                input: () => {},
            }
        },

        innerValue() {
            return this.model === undefined
                ? this.CheckboxGroup && this.CheckboxGroup.value
                : this.model
        },

        isChecked() {
            const value = this.innerValue
            let isChecked

            // If not v-model given return `checked` attr value
            if (value === undefined) return this.checked

            if (typeof value === 'boolean') isChecked = value
            else if (Array.isArray(value))
                isChecked = value.includes(this.value)
            else isChecked = !!value

            if (this.shouldBeChecked) {
                if (!isChecked) this.handleChange()
                return true
            }

            return isChecked
        },

        isDisabled() {
            return this.CheckboxGroup
                ? this.CheckboxGroup.disabled || this.disabled
                : this.disabled
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.checkbox {
    margin-bottom: 15px;
    display: block;
}

input {
    @include hide-visually;
}

.checkbox__container {
    display: inline-flex;
    align-items: center;
    cursor: pointer;

    &:hover,
    &:active,
    &:focus {
        .checkbox__box {
            border-color: $checkbox-box-checked-border-color;
        }
    }
}

.checkbox__label {
    text-transform: uppercase;
    color: $checkbox-label-color;
    font-size: $checkbox-label-font-size;
    font-weight: $checkbox-label-font-weight;
}

// Box
.checkbox__box {
    @include size($checkbox-box-size);

    position: relative;
    border: $checkbox-box-border-width solid $checkbox-box-border-color;
    border-radius: $checkbox-box-border-radius;
    margin-right: 8px;
    flex-shrink: 0;
    transition-property: background border-color;
    transition-duration: 0.2s;
}

// Checked Styles
.checkbox--is-checked {
    .checkbox__box {
        border-color: $checkbox-box-checked-border-color;

        &::before {
            @include size($checkbox-box-size * 0.65);
            background: color('primary');
        }
    }
}

// Disabled Styles
.checkbox--is-disabled .checkbox__box {
    border-color: $checkbox-box-border-color !important;
    background: tint($checkbox-box-border-color, 50%) !important;

    &::before {
        transform: scale(0);
    }
}

// Checkmark
.checkbox__box::before {
    @include pseudo;
    @include centered;
    @include size(0);

    border-radius: $checkbox-box-border-radius / 2;
    transition-property: width, height;
    transition-duration: 0.2s;
}
</style>

<template>
    <div :class="classes">
        <label class="radio__container">
            <input
                type="radio"
                :value="value"
                :disabled="isDisabled"
                :checked="isChecked"
                @change="handleChange"
                data-test="radio"
            />
            <span class="radio__circle" />
            <span v-text="label" data-test="label" class="radio__label" />
        </label>
    </div>
</template>

<script>
 export default {
     model: { prop: 'model' },

     props: {
         label: String,
         value: {
             type: [String, Number],
             required: true,
         },

         model: {
             validator: value =>
                 value === null ||
			       typeof value === 'string' ||
			       typeof value === 'number',
         },
         checked: Boolean,
         disabled: Boolean,
     },

     methods: {
         handleChange() {
             this.$emit('change', this.value)
             this.$emit('input', this.value)
	     this.$emit('cambiarC', this.value)
         },
     },

     computed: {
         classes() {
             return {
                 radio: true,
                 'radio--checked': this.isChecked,
                 'radio--disabled': this.isDisabled,
             }
         },

         isChecked() {
             const value = this.model

             return !value
                  ? this.checked && this.handleChange()
                  : value === this.value
         },

         isDisabled() {
             return this.disabled
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .radio {
     margin-bottom: 15px;
     display: block;
 }

 input {
     @include hide-visually;
 }

 .radio__container {
     display: inline-flex;
     align-items: center;
     cursor: pointer;

     &:hover,
     &:active,
     &:focus {
         .radio__circle {
             border-color: $radio-circle-checked-border-color;
         }
     }
 }

 .radio__label {
     text-transform: uppercase;
     color: $radio-label-color;
     font-size: $radio-label-font-size;
     font-weight: $radio-label-font-weight;
 }

 .radio__circle {
     @include size($radio-circle-size);

     position: relative;
     border: $radio-circle-border-width solid $radio-circle-border-color;
     border-radius: 50%;
     margin-right: 8px;
     flex-shrink: 0; // prevent shrink
     transition: border-color 0.2s;
 }

 // Knob
 $offset: calc(50% - #{$radio-knob-size / 2});

 .radio__circle::before {
     @include pseudo;
     @include position(absolute, $offset, $offset);
     @include size($radio-knob-size);

     background: $radio-knob-background;
     border-radius: 50%;
     transform: scale(0);
     transition: transform 0.2s;
 }

 // Checked Styles
 .radio--checked .radio__circle {
     border-color: $radio-circle-checked-border-color;

     &::before {
         transform: scale(1);
     }
 }

 // Disabled Styles
 .radio--disabled .radio__circle {
     border-color: $radio-circle-border-color !important;
     background: tint($radio-circle-border-color, 50%) !important;

     &::before {
         background: $radio-circle-border-color !important;
     }
 }
</style>

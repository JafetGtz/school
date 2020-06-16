<template>
    <div :class="classes" :style="{ width }">
        <div class="select__container">
            <Input
                :value="selected.label"
                class="select__input"
                v-bind="$attrs"
                readonly
                :placeholder="placeholder"
                :disabled="disabled"
                @click.stop="doToggle"
		@change="cambio()"
            />

            <i class="select__arrow icon icon-down"></i>

            <ul
                v-click-away="() => (isActive = false)"
                v-show="isActive"
                class="select__options"
            >
                <template v-if="normalizedOptions.length">
                    <li
                        v-for="(option, index) in normalizedOptions"
                        :key="index"
                        class="select__option"
                        @click="handleOptionClick(option)"
                        :class="{
                            'select__option--is-selected': checkIfSelected(
                                option
                            ),
                        }"
                    >
                        {{ option.label }}
                    </li>
                </template>
                <template v-else>
                    <li class="options__placeholder">
                        No hay opciones disponibles
                    </li>
                </template>
            </ul>
        </div>
    </div>
</template>

<script>
 import clickAway from '../directives/click-away'

 export default {
     directives: { clickAway },

     props: {
         options: { type: Array, required: true },
         value: null,
         width: { type: String, default: '100%' },
         placeholder: { type: String, default: 'Seleccionar...' },
         disabled: Boolean,
     },

     data: () => ({
         selected: { value: null, label: null },
         isActive: false,
     }),

     created() {
         const value = (this.value && this.value.value) || this.value
         const options = this.normalizedOptions

         const option = options.find(opt => opt.value === value)

         if (option) this.selected = option
     },

     watch: {
         selected(option) {
             const { value } = this
             this.$emit(
                 'input',
                 typeof (
                     typeof value === 'number' ||
                     value === null ||
                     value === undefined
                 )
                 ? option.value
                 : option
             )
         },
     },

     computed: {
         classes() {
             return {
                 select: true,
                 'select--is-active': this.isActive,
             }
         },

         normalizedOptions() {
             return this.options.map(option =>
                 typeof option === 'string'
                 ? { label: option, value: option }
                 : option
             )
         },
     },

     methods: {
	 cambio(){
	     this.$emit('evento',this.value)
	 },
         doToggle() {
             if (this.disabled) {
                 this.isActive = false
                 return
             }

             this.isActive = !this.isActive
         },

         checkIfSelected(option) {
             return this.selected.value === option.value
         },

         handleOptionClick(option) {
             this.isActive = false
             if (!this.checkIfSelected(option)) this.selected = option
         },
     },
 }
</script>

<style lang="scss">
 @import '~@/sass/_globals.scss';

 .select__container {
     position: relative;
 }

 .select__arrow {
     @include position(absolute, null, null, 10px, 10px);

     font-size: $select-arrow-size;
     color: $select-arrow-color;
     transition: transform 0.2s ease-out;
     color: color('gray', 400);
     pointer-events: none;

     .select--is-active & {
         transform: rotateZ(180deg);
         color: color('primary');
     }
 }

 .select__options {
     @include position(absolute, 100%, 0);

     width: 100%;
     max-height: $select-options-max-height;
     background: color('white');
     border: 1px solid color('gray');
     margin-top: $select-options-margin-top;
     border-radius: $select-options-border-raduis;
     padding: $select-options-border-raduis 0;
     overflow: auto;
     z-index: get('pop-up', $z-layers);
 }

 .select__option {
     @include ellipsis;

     padding: 10px 10px;
     cursor: pointer;

     &:hover {
         background: $selected-option-hover-background;
     }

     &--is-selected {
         background: $select-option-selected-background !important;
         color: $select-option-selected-color;
     }
 }

 .options__placeholder {
     text-align: center;
     padding: 10px 0;
     color: $select-placeholder-color;
 }
</style>

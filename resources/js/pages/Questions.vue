<template>
    <div class="container">
	<div class="questions">
            <component
		:is="'step-' + step"
		v-bind="props"
		:loading="loading"
		:errors="errors"
		@submit="handleSubmit"
            ></component>
	</div>
    </div>
</template>

<script>
 import handleFormError from '../utils/handleFormError'

 export default {
     components: {
         'step-1': require('./_questions/1').default,
         'step-2': require('./_questions/2').default,
         'step-3': require('./_questions/3').default,
         'step-4': require('./_questions/4').default,
     },

     props: {
         step: {
             type: Number,
             required: true,
         },
         TOTAL_STEPS: {
             type: Number,
             required: true,
         },
         props: {
             type: Object,
             required: true,
         },
     },

     data: () => ({ loading: false, errors: new ErrorBag() }),

     methods: {
         async handleSubmit(data) {
             if (this.loading) return

             this.loading = true
             this.errors.clear()

             try {
                 const url = route('questions', this.step)
                 await this.$http.post(url, data)
                 window.location.href =
                     this.step < this.TOTAL_STEPS
                               ? route('questions', this.step + 1)
                               : route('dashboard.index')
             } catch (error) {
                 const validationErrors = handleFormError(error)
                 this.errors.set(validationErrors)
             } finally {
                 this.loading = false
             }
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .questions {
     margin: 0 auto;

     @include breakpoint('md') {
         width: 85%;
     }
     @include breakpoint('lg') {
         width: 80%;
     }
 }
</style>

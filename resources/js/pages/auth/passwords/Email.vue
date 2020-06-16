<template>
    <div class="formm margin-top--two">
	<form @submit.prevent="handleSubmit" class="row">
            <div class="col-md-5">
		<h1 class="text--center">Renovar contraseña</h1>

		<span v-if="isSuccess" role="alert" class="success"
                >¡Recordatorio de contraseña enviado!</span
						     >

		<Input
                    label="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                    autofocus
                    :error="errors.first('email')"
		/>

		<Button type="submit" :loading="loading" block
		>Enviar correo</Button
			      >
            </div>
	</form>
    </div>
</template>

<script>
 export default {
     props: {
         //
     },

     data: self => ({
         form: { email: '' },
         errors: new ErrorBag(),
         isSuccess: false,
         loading: false,
     }),

     methods: {
         async handleSubmit() {
             if (this.loading) return

             this.loading = true
             this.errors.clear()

             try {
                 const data = this.form
                 await this.$http.post(route('password.email'), data)
                 this.isSuccess = true
             } catch (error) {
                 console.error(error)
                 if (error.response) {
                     console.error(error.response)
                     const { errors } = error.response.data
                     this.errors.set(errors)
                 }
             } finally {
                 this.loading = false
             }
         },
     },
 }
</script>
<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .formm {
     position: absolute;
     width: 900px;
   
     z-index: 15;
 
     left: 50%;
     margin: -100px 0 0 -200px;

 }

</style>

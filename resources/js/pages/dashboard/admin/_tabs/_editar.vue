<template>
    <div class="">
	<form @submit.prevent="handleSubmit">
	    <h1 class="text--center">Editar perfil</h1>
	    <span v-show="error" class="edit__error" role="alert">
			<strong>{{ error }}</strong>
        </span>
	    <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.first_name"
			label="nombres"
			required
			autocomplete="name"
			autofocus

                    />
		</div>
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.last_name"
			label="apellidos"
			
			required
                    />
		</div>
            </div>
	    <!--  -->
	    <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.email"
			label="email"
			required
			autocomplete="email"
			autofocus/>
		</div>
		<div class="col-xs-12 col-sm-6">
		    <Input
			label="Contraseña actual"
			v-model="form.passworda"
			type="password"
			required
			autocomplete="contraseña"
			autofocus/>
		</div>
            </div>
	    <!--  -->

	    <div class="row">
		<div class="col-xs-12 col-sm-6">
		    <Input
			label="Nueva Contraseña"
			v-model="form.password1"
			type="password"
			required
			placeholder="6+ caracteres"
			autocomplete="contraseña"
			autofocus/>
		</div>
		<div class="col-xs-12 col-sm-6">
		    <Input
			type="password"
			      label="confirmar contraseña"
			      v-model="form.password"
			      placeholder="6+ caracteres"
			      required
			autocomplete="contraseña"
			      autofocus/>
		</div>
            </div>
	    <Button type="submit" :loading="loading">Guardar</Button>
	</form>
    </div>
</template>

<script>
 export default {
     props: ['usuario'],
     data: () => ({
         form: {
             password: null,

         },
         error: "",
         loading: false,
     }),
     created(){
	 const { usuario, form } = this
	 form.first_name = usuario.first_name;
	 form.last_name = usuario.last_name;
	 form.email = usuario.email;

     },
     methods: {
         async handleSubmit() {
             if (this.loading) return
	     try {
		 const data = { ...this.form }
		 const  id  = this.usuario.id;
		 const url = route('admin.editaAdmin',id)
		 await this.$http.put(url, data).then((res)=>{
		     if(res.data=="pass"){
			 window.location.href = route('dashboard.index')
		     }else{
			 this.error= res.data
		     }
		     console.log(res)
		 })

             } catch (error) {
                 console.error(error.response || error)
             } finally {
                 this.loading = false
             }
         },
     },
     
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
 .edit__error{
     padding: get('one', $spacers);
     margin-top: get('two', $spacers) * -1;
     margin-bottom: get('two', $spacers);
     border: 1px solid color('red');
     color: color('red');
     border-radius: 4px;
     display: block;
     text-align: center;
 }
 
</style>

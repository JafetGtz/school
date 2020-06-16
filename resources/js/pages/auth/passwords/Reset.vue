<template>
    <div class = "container">
        <form @submit.prevent="handleSubmit">
            <h1>Renovar contraseña</h1>
            <span v-show="error" class="edit__error" role="alert">
			<strong>{{ error }}</strong>
            </span>
            <Input  
                label="email"
                v-model="form.email"
                required
                autocomplete="email"
                autofocus
                :error="errors.first('email')"
            />

            <Input
                label="nueva contraseña"
                v-model="form.password"
                type="password"
                required
                autocomplete="new-password"
                :error="errors.first('password')"
            />

            <Input
                label="nueva contraseña"
                v-model="form.password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                :error="errors.first('password')"
            />

            <Button type="submit" :loading="loading">Cambiar contaseña</Button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        token: {
            type: String,
            required: true,
        },

        email: {
            type: String,
            required: true,
        },
    },

    data: self => ({
        form: {
            email: self.email || '',
            password: '',
            password_confirmation: '',
        },
        errors: new ErrorBag(),
        loading: false,
    }),

    methods: {
        async handleSubmit() {
            if (this.loading) return

            this.loading = true
            this.errors.clear()

            try {
                const data = this.form
                await this.$http.post(route('password.reseta'), data).then((res)=>{
		        if(res.data=="pass"){
                    window.location.href = route('dashboard.index')
                }else{
                    this.error= res.data
                }
                    console.log(res)
                })    
            } catch (error) {
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
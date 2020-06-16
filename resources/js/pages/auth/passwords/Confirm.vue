<template>
    <form @submit.prevent="handleSubmit" class="row justify-content-center">
        <div class="col-md-5">
            <h1>Confirma tu contraseña antes de continuar</h1>

            <Input
                label="contraseña"
                v-model="form.password"
                type="password"
                required
                autocomplete="current-password"
                autofocus
                :error="errors.first('password')"
            />

            <Button type="submit" :loading="loading" block>Confirmar</Button>
            <a
                :href="route('password.request')"
                class="link text--rigth text--small"
                >¿Olvidaste tu contraseña?</a
            >
        </div>
    </form>
</template>

<script>
export default {
    props: {
        //
    },

    data: self => ({
        form: { password: '' },
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
                await this.$http.post(route('password.confirm'), data)
                // window.location.href = route('dashboard.index')
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

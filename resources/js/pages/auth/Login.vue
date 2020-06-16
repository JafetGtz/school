<template>
    <div class="login container">
        <form class="login__form" @submit.prevent="handleSubmit">
            <h1 class="text--center margin-bottom--three">Iniciar sesión</h1>

            <span v-show="error" class="login__error" role="alert">
                <strong>{{ error }}</strong>
            </span>

            <Input
                label="Email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                autofocus
            />

            <Input
                label="Contraseña"
                v-model="form.password"
                type="password"
                required
                autocomplete="current-password"
            />

            <Checkbox
                :value="false"
                v-model="form.remenber"
                class="padding-top--quarter margin-bottom--halve"
                label="Recordarme"
            />

            <p class="text--right text--small margin-bottom--halve">
                <a class="link" :href="route('password.request')"
                    >¿Olvidaste tu contraseña?</a
                >
            </p>

            <Button type="submit" block :loading="loading">
                <span>Iniciar</span>
            </Button>

            <p class="text--center margin-top--two">
                <span>¿Aún no eres miembro? </span>
                <a class="link" :href="route('register')">Registrate</a>
            </p>
        </form>
    </div>
</template>

<script>
export default {
    data: () => ({
        form: {
            email: null,
            password: null,
            remember: false,
        },
        error: null,
        loading: false,
    }),

    methods: {
        async handleSubmit() {
            if (this.loading) return

            try {
                this.loading = true
                const response = await this.$http.post('login', this.form)
                window.location.href = route('dashboard.index')
            } catch (error) {
                console.error(error.response || error)

                if (error.response) {
                    const { data } = error.response
                    if (data.errors) {
                        this.error =
                            data.errors.email[0] ||
                            data.errors.password[0] ||
                            data.message
                    }
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

.login__form {
    width: 420px;
    max-width: 100%;
    margin: 0 auto;
}

.login__error {
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

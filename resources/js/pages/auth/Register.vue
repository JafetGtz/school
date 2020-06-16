<template>
    <div class="registe container">
        <form class="register__form" @submit.prevent="handleSubmit">
            <header class="text--center margin-bottom--two">
                <h1 class="margin-bottom--quarter">
                    {{
                        !type
                            ? 'Unete a nuestra plataforma'
                            : type === 'teacher'
                            ? 'Registrate como tutor'
                            : 'Registrate como estudiante'
                    }}
                </h1>
                <p>
                    <span>¿Ya eres miembro?</span>
                    <a class="link" :href="route('login')">Iniciar sesión</a>
                </p>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <Input
                        v-model="form.first_name"
                        label="nombres"
                        required
                        autocomplete="name"
                        autofocus
                        :error="errors.first('first_name')"
                    />
                </div>
                <div class="col-xs-12 col-sm-6">
                    <Input
                        v-model="form.last_name"
                        label="apellidos"
                        :error="errors.first('last_name')"
                        required
                    />
                </div>
            </div>

            <Input
                v-model="form.email"
                label="email"
                type="email"
                autocomplete="email"
                :error="errors.first('email')"
                required
            />
            <Input
                v-model="form.password"
                label="contraseña"
                placeholder="6+ caracteres"
                type="password"
                autocomplete="new-password"
                :error="errors.first('password')"
                required
            />

            <Button
                class="margin-top--two"
                type="submit"
                block
                :loading="loading"
                >registrarse</Button
            >

            <div class="margin-top--one">
                <p for="terms" class="text--small">
                    <span>Al registrarte aceptas los</span>
                    <a class="link" :href="route('terms')" target="_blank"
                        >Términos y Condiciones</a
                    >
                    <span>y las</span>
                    <a
                        class="link"
                        :href="route('privacy-policy')"
                        target="_blank"
                        >Políticas de Privacidad</a
                    >
                </p>
            </div>
        </form>
    </div>
</template>

<script>
import handleFormError from '../../utils/handleFormError'

export default {
    data() {
        return {
            form: {
                first_name: null,
                last_name: null,
                email: null,
                password: null,
                accepTerms: false,
            },
            type: null,
            loading: false,
            error: null,
            errors: new ErrorBag(),
        }
    },

    created() {
        const uri = window.location.search.substring(1)
        const params = new URLSearchParams(uri)
        const query = params.get('type')

        this.type = /student|teacher/.test(query) ? query : null
    },

    methods: {
        async handleSubmit() {
            if (this.loading) return

            try {
                this.loading = true

                const { type, form } = this
                await this.$http.post('register', { ...form, type })

                window.location.href = type
                    ? route('dashboard.index')
                    : route('choose-account-type')
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

.register__form {
    width: 490px;
    max-width: 100%;
    margin: 0 auto;
}
</style>

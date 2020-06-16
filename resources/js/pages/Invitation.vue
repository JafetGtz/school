<template>
    <div class="container">
        <header class="text--center margin-bottom--three">
            <h1 class="margin-bottom--zero">
                Invitación para enseñar en linea
            </h1>
            <h3 class="text--light">
                Muestra tus habilidades desarrollando ejercicios
            </h3>
        </header>

        <div class="container">
            <div class="margin-bottom--two">
                <span class="budget"
                    >{{ APP_CURRENCY_SYMBOL }} {{ asigment.budget-3 }}</span
                >
                <div class="time">
                    <i class="icon icon-calendar"></i>
                    <span>{{ asigment.formated_date }}</span>
                </div>
            </div>

            <div class="margin-top--two">
                <h5 class="margin-bottom--halve">Detalles</h5>
                <p class="">{{ asigment.details }}</p>
            </div>

            <div class="margin-top--two">
                <File
                    v-for="(file, index) in asigment.files"
                    :key="index"
                    :file="file"
                    readonly
                />
            </div>

            <div class="margin-top--three">
                <Button @click="handleAnswer(1)" :loading="loading" block
                    >Estoy interesado</Button
                >

                <Button
                    class="margin-top--one"
                    color="gray"
                    flat
                    block
                    @click="handleAnswer(0)"
                    :loading="loading"
                    >Descartar</Button
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['asigment', 'invitation'],

    data: () => ({ loading: false }),

    methods: {
        async handleAnswer(answer) {
            if (this.loading) return

            if (
                !answer &&
                !confirm('¿Seguro de que deseas descartar esta invitación?')
            ) {
                return
            }

            this.loading = true

            try {
                const { id } = this.invitation
                const url = route('invitation.update', { id, answer })
                await this.$http.put(url)

                window.location.href = route('dashboard.index')
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

.time {
    font-size: 1.5rem;
}

.budget {
    font-size: 2.85rem;
}
</style>

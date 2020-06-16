<template>
    <form @submit.prevent="handleSubmit">
        <header class="margin-bottom--two">
            <h1 class="margin-bottom--zero">Tu horario</h1>
            <p>Establece tus horas disponibles para dar clases online.</p>
        </header>

        <span v-for="(key, index) in errors.keys" :key="index" role="alert">
            {{ errors.first(key) }}
        </span>

        <Schedule v-model="form.schedule" />

        <div class="margin-top--two">
            <Button :href="route('questions', 2)" flat>Atras</Button>
            <Button type="submit" :loading="loading">Siguiente</Button>
        </div>
    </form>
</template>

<script>
export default {
    props: {
        old: Object,
        loading: Boolean,
        errors: ErrorBag,
    },

    data: ({ old }) => ({ form: { schedule: old['schedule'] || {} } }),

    methods: {
        handleSubmit() {
            const data = this.form
            this.$emit('submit', data)
        },
    },
}
</script>

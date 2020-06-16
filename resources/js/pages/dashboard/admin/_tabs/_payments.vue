<template>
    <div class="">
        <h1>Pagos pendientes</h1>

        <div v-show="success" class="success">
            El comprobante de depósito se ha registrado exitosamente.
        </div>

        <form v-if="shouldShowForm" class="form" @submit.prevent="handleSubmit">
            <h4>Registrar comprobante de depósito:</h4>
            <ul class="margin-bottom--one">
                <li>
                    <strong>Presupuesto de la instrucción:</strong>
                    {{ APP_CURRENCY_SYMBOL }}
                    {{ applyTax(selected.data.budget) }}
                </li>

                <li>
                    <strong>Fecha:</strong> {{ selected.data.formated_date }}
                </li>

                <li>
                    <strong>Docente:</strong>
                    {{ selected.data.teacher.full_name }}
                </li>
            </ul>

            <input type="file" @change="handleFileChange" />

            <span v-if="errors.has('file')" class="error" role="alert">
                {{ errors.first('file') }}
            </span>

            <div class="margin-top--two">
                <Button type="submit" :loading="loading">Registrar</Button>
            </div>
        </form>

        <div v-if="!mutableItems.length">
            <p>Por los momentos no hay pagos pendiente por hacer...</p>
        </div>

        <ul>
            <li
                :class="{
                    card: true,
                    'card--is-active': selected && selected.index === index,
                }"
                v-for="({
                    budget,
                    details,
                    formated_date,
                    level,
                    category,
                    teacher,
                },
                index) in mutableItems"
                :key="index"
                @click="handleClick(index)"
            >
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <h3 class="margin-bottom--one">
                            {{ APP_CURRENCY_SYMBOL }} {{ applyTax(budget) }}
                        </h3>

                        <p>
                            <i class="icon icon-calendar"></i>
                            {{ formated_date }}
                        </p>
                        <p>
                            <strong>Nivel:</strong>
                            {{ level.name }}
                        </p>
                        <p><strong>Categoria:</strong> {{ category.name }}</p>
                        <p class="">
                            <strong>Descripción:</strong> {{ details }}
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-6 text--center">
                        <figure class="card__avatar image">
                            <img :src="teacher.avatar" />
                        </figure>
                        <h3 class="margin-bottom--zero">
                            {{ teacher.full_name }}
                        </h3>
                        <Stars :value="teacher.stars" />
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['unpaidAsigments'],

    data: () => ({
        mutableItems: [],
        selected: null,
        form: { file: null },
        loading: false,
        success: false,
        errors: new ErrorBag(),
    }),

    watch: {
        success(boolean) {
            if (boolean === true) {
                setInterval(() => (this.success = false), 1000 * 3)
            }
        },
    },

    created() {
        this.mutableItems = [...this.unpaidAsigments]
    },

    computed: {
        shouldShowForm() {
            return !!this.selected
        },
    },

    methods: {
        handleClick(index) {
            this.selected = {
                index,
                data: this.mutableItems[index],
            }

            this.$el.parentElement.scrollTo({
                top: 0,
                behavior: 'smooth',
            })
        },

        handleFileChange({ target: { files } }) {
            this.form.file = files[0]
        },

        async handleSubmit() {
            if (this.loading) return

            this.loading = true
            this.errors.clear()

            const data = new FormData()
            const { file } = this.form
            data.append('file', file)

            try {
                const {
                    index,
                    data: { id },
                } = this.selected

                const url = route('asigment.deposit-voucher', id)
                await this.$http.post(url, data)

                this.mutableItems.splice(index, 1)
                this.selected = null
                this.success = true
            } catch (error) {
                console.error(error.response || error)

                if (error.response && error.response.data.errors)
                    this.errors.set(error.response.data.errors)
            } finally {
                this.loading = false
            }
        },

        applyTax(amount) {
            const subtotal = parseFloat(amount)
            const tax = parseFloat(APP_SERVICE_TAX)
            const total = subtotal + tax

            return total.toFixed(2)
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.form {
    padding: 2rem;
    border: 1px solid color('gray', 50);
    border-radius: 10px;
    margin-bottom: 2rem;
}

.card {
    padding: 2rem;
    border-bottom: 1px solid color('gray', 50);
    margin-bottom: 1rem;
    cursor: pointer;

    &:hover {
        background: color('gray', 50, 0.1);
    }

    &:last-child {
        border-bottom: 0;
    }
}

.card--is-active {
    border-radius: 10px;
    border-color: color('primary');
    box-shadow: 0 0 0 5px color('primary');
}

.card__avatar {
    @include size(120px);
    border-radius: 5px;
    margin: 0 auto;
    margin-top: 2rem;
}
</style>

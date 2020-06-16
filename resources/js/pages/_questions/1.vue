<template>
    <form class="questions" @submit.prevent="handleSubmit">
        <header class="margin-bottom--two">
            <h1 class="margin-bottom--quarter">Queremos conocerte</h1>
            <p>
                Antes de empezar, necesitamos saber algunas cosas sobre ti
            </p>
        </header>
        <div class="row margin-top--two">
            <div class="col-xs-12 col-sm-7 col-lg-5">
                <h6 class="margin--zero">Nacionalidad</h6>

                <Select
                    v-model="form.country"
                    :options="countries"
                    :error="errors.first('country')"
                    required
                />
            </div>

            <div class="col-xs-12 col-sm-7 col-lg-6">
                <h6 class="margin--zero">Fecha de nacimiento</h6>

                <div class="row">
                    <div class="col-xs-3">
                        <Input
                            v-model="form.birthday[0]"
                            type="number"
                            required
                            min="1"
                            max="31"
                            placeholder="DD"
                        />
                    </div>
                    <div class="col-xs-3">
                        <Input
                            v-model="form.birthday[1]"
                            type="number"
                            required
                            min="1"
                            max="12"
                            placeholder="MM"
                        />
                    </div>
                    <div class="col-xs-6">
                        <Input
                            type="number"
                            required
                            max="999999"
                            min="1950"
                            v-model="form.birthday[2]"
                            placeholder="AAAA"
                        />
                    </div>
                </div>

                <span v-if="errors.has('birthday')" class="error" role="alert">
                    {{ errors.first('birthday') }}
                </span>
            </div>
        </div>

        <h3 class="margin-top--three">
            ¿A que nivel de educación estas capacitado para enseñar?
        </h3>

        <span v-if="errors.has('levels')" class="error" role="alert">
            {{ errors.first('levels') }}
        </span>

        <Checkbox
            v-for="(level, index) in levels"
            v-model="form.levels"
            :key="index"
            :value="level.id"
            :label="level.name"
        />

        <h3 class="margin-top--three">
            ¿Cuales son tus especialidades?
        </h3>

        <span v-if="errors.has('categories')" class="error" role="alert">
            {{ errors.first('categories') }}
        </span>

        <div class="row">
            <Checkbox
                class="col-xs-12 col-sm-6"
                v-for="(category, index) in categories"
                v-model="form.categories"
                :key="index"
                :value="category.id"
                :label="category.name"
            />
        </div>

        <Button class="margin-top--two" type="submit" :loading="loading"
            >Siguiente</Button
        >
    </form>
</template>

<script>
export default {
    props: {
        old: { type: Object, required: true },
        countries: { type: Array, required: true },
        categories: { type: Array, required: true },
        levels: { type: Array, required: true },

        errors: ErrorBag,
        loading: Boolean,
    },

    data: ({ old }) => ({
        form: {
            country: old['country'] || '',
            birthday: ['', '', ''],
            levels: old['levels'] || [],
            categories: old['categories'] || [],
        },
    }),

    created() {
        if (Object.keys(this.old).length) {
            const { old, form } = this
            const birthday = new Date(old['birthday'])

            form.birthday = [
                birthday.getDate(),
                birthday.getMonth() + 1,
                birthday.getFullYear(),
            ]
        }
    },

    methods: {
        handleSubmit() {
            const data = { ...this.form }

            const { birthday } = data

            data.birthday = new Date(
                birthday[2], // Year
                birthday[1] - 1, // Month, wich is 0 based
                birthday[0] //Date
            )

            this.$emit('submit', data)
        },
    },
}
</script>

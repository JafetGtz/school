<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <header class="text--center margin-bottom--three">
                <h1 class="margin-bottom--zero">Tipo de cuenta</h1>
                <p>Elige el tipo de cuenta quieres crear.</p>
            </header>

            <div class="row">
                <div class="div col-sm-6">
                    <label class="tile">
                        <input
                            type="radio"
                            value="student"
                            v-model="form.type"
                        />
                        <div class="tile__box">
                            <h3 class="tile__title">Alumno</h3>
                            <p class="tile__text">
                                Sube tus ejercicios de matemáticas, física o
                                química, y te contactaremos con tutores
                                especializados para desarrollarlos.
                            </p>
                            <span class="tile__check">
                                <i class="icon icon-ok"></i>
                            </span>
                        </div>
                    </label>
                </div>

                <div class="div col-sm-6">
                    <label class="tile">
                        <input
                            type="radio"
                            value="teacher"
                            v-model="form.type"
                        />
                        <div class="tile__box">
                            <h3 class="tile__title">Tutor</h3>
                            <p class="tile__text">
                                Sé nuestro mejor tutor en matemáticas, física, y
                                química, se evaluará tu paciencia en la clase,
                                el escuchar al alumno, y el uso adecuado de las
                                tecnologías.
                            </p>
                            <span class="tile__check">
                                <i class="icon icon-ok"></i>
                            </span>
                        </div>
                    </label>
                </div>
            </div>
            <!--  -->

            <footer class="text--center margin-top--one">
                <Button type="submit" :loading="loading" :disabled="!form.type"
                    >Siguiente</Button
                >
            </footer>
        </form>
    </div>
</template>

<script>
import handleFormError from '../utils/handleFormError'

export default {
    data: () => ({
        form: { type: '' },
        loading: false,
    }),

    methods: {
        async handleSubmit() {
            if (this.loading) return

            this.loading = true

            try {
                const data = this.form
                const url = route('choose-account-type')
                await this.$http.post(url, data)

                const { type } = data
                window.location.href =
                    type === 'student'
                        ? route('dashboard.index')
                        : route('questions', 1)
            } catch (error) {
                handleFormError(error)
            } finally {
                this.loading = false
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.tile {
    display: block;
    width: 95%;
    margin: 0 auto;
    cursor: pointer;

    input {
        @include hide-visually;
    }
}

.tile__box {
    position: relative;
    background: color('white');
    box-shadow: 0 0 0 2px color('gray', 50);
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 10px;
    transition: background 0.05s linear;

    input:checked + & {
        box-shadow: 0 0 0 4px color('primary');
        border-width: 3px;
    }
}

.tile__check {
    $size: 50px;
    $halve: $size / 3;

    @include size($size);
    @include position(absolute, -$halve, false, false, -$halve);

    background: color('primary');
    border-radius: 50%;
    text-align: center;
    line-height: $size;
    color: color('white');
    font-size: 1.25rem;
    transform: scale(0);
    transition: transform 0.1s ease-out;

    input:checked + .tile__box & {
        transform: scale(1);
    }
}

.tile__title,
.tile__text {
    color: inherit !important;
}

.tile__title {
    text-transform: uppercase;
}

.tile__text {
    min-height: 100px;
}
</style>

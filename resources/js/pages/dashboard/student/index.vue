<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 margin-bottom--three">
                <div class="margin-bottom--two">
                    <h2 class="margin-bottom--zero">Tus propuestas</h2>
                    <p>Estas son las propuestas que has creado hasta ahora</p>
                </div>

                <ul>
                    <li
                        v-for="({
                            id,
                            invitations,
                            budget,
                            details,
                            formated_date,
                            formated_created_at,
                        },
                        index) in openAsigments"
                        :key="index"
                    >
                        <article class="card">
                            <a :href="route('asigment.index', id)">
                                <h4 class="card__title">
                                    {{ APP_CURRENCY_SYMBOL }} {{ budget }}
                                </h4>
                                <p class="card__text">{{ details }}</p>

                                <div class="card__footer">
                                    <div>
                                        <i class="icon icon-users"></i>
                                        <span>{{ invitations }}</span>
                                    </div>

                                    <div>
                                        <i class="icon icon-calendar"></i>
                                        <span>{{ formated_date }}</span>
                                    </div>
                                </div>

                                <span class="card__date">{{
                                    formated_created_at
                                }}</span>
                            </a>

                            <label
                                :for="'toggler-' + index"
                                class="card__toggler"
                            >
                                Mas opciones...
                            </label>

                            <input
                                class="card__checkbox"
                                type="checkbox"
                                :id="'toggler-' + index"
                            />

                            <div class="card__actions">
                                <Button
                                    rounded
                                    outline
                                    color="default"
                                    :loading="loading"
                                    @click="doEdit(id)"  
                                >
                                    <span>Editar</span>
                                    <i class="icon icon-pen"></i>
                                </Button>

                                <Button
                                    rounded
                                    outline
                                    color="red"
                                    :loading="loading"
                                    @click="doDiscart(id)"
                                >
                                    <span>Descartar</span>
                                    <i class="icon icon-x"></i>
                                </Button>
                            </div>
                        </article>
                    </li>
                </ul>

                <div class="go-to-create">
                    <a :href="route('asigment.create')">
                        <h3 class="go-to-create__title">
                            Crear nueva propuesta
                        </h3>

                        <button class="go-to-create__button">&plus;</button>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="text--right margin-bottom--two">
                    <h2 class="margin-bottom--zero">Clases programadas</h2>
                    <p>Aquí aparecerán todas las clases por tomar</p>
                </div>

                <ul>
                    <li
                        v-for="({
                            id,
                            details,
                            date,
                            teacher,
                            formated_created_at,
                        },
                        index) in scheduledClasses"
                        :key="index"
                        class="card card--right"
                    >
                        <a :href="route('room', id)">
                            <article>
                                <h4 class="card__title">
                                    {{ formatDistance(date) }}
                                </h4>
                                <p class="card__text">{{ details }}</p>

                                <footer class="card__footer">
                                    <div class="d-flex justify-content-end">
                                        <div class="margin-right--halve">
                                            <p>
                                                {{ teacher.full_name }}
                                            </p>
                                            <Stars :value="teacher.stars" />
                                        </div>

                                        <figure class="card__avatar image">
                                            <img :src="teacher.avatar" />
                                        </figure>
                                    </div>
                                </footer>
                            </article>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import formatDistance from 'date-fns/formatDistance'
import { es } from 'date-fns/locale'

export default {
    props: ['student', 'openAsigments', 'scheduledClasses'],

    data: () => ({
        loading: false,
    }),

    methods: {
        async doDiscart(id) {
            if (this.loading) return

            if (confirm('¿Seguro de que deseas descartar esta propuesta?')) {
                this.loading = true

                try {
                    const url = route('asigment.delete', id)
                    await this.$http.delete(url, id)
                    window.location.reload(true)
                } catch (error) {
                    console.log(error.response || error)
                } finally {
                    this.loading = false
                }
            }
        },

        async doEdit(id){
            if (this.loading) return
            window.location.href=route('asigment.edit',id)
        },

        formatDistance: date =>
            formatDistance(new Date(date), Date.now(), {
                locale: es,
                addSuffix: true,
            }),
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.card {
    position: relative;
    border: 1px solid color('gray', 100);
    border-radius: 10px;
    padding: 1.5rem 1.5rem;
    margin-bottom: 1rem;

    &--right {
        text-align: right;
    }
}

.card__date {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    color: color('gray');
}

.card__title {
    margin-bottom: 0.5rem;
}

.card__text {
    @include ellipsis;
}

.card__footer {
    padding-top: 1rem;

    .icon {
        font-size: 1.5rem;
        vertical-align: middle;
        color: color('primary');
    }
}

.card__toggler {
    display: block;
    text-align: center;
    color: color('primary');
    margin-top: 1rem;
    font-weight: get('bold', $font-weights);
    cursor: pointer;
}

.card__checkbox {
    @include hide-visually;
}

.card__actions {
    display: none;
    padding-top: 1rem;

    .card__checkbox:checked + & {
        display: block;
    }
}

.card__avatar {
    @include size(50px);
    border-radius: 50%;
}

.go-to-create {
    background: color('gray', 50, 0.25);
    border-radius: 10px;
    padding: 2rem 1rem;
    text-align: center;

    &__title {
        margin-bottom: 1rem;
        color: color('gray', 700);
        font-weight: get('regular', $font-weights);
    }

    &__button {
        $size: 50px;
        @include size($size);
        display: block;
        margin: 0 auto;
        background: color('primary');
        color: color('white');
        line-height: $size;
        font-size: 1.75rem;
        border-radius: 10px;
    }
}
</style>

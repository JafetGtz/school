<template>
    <div class="container">
        <TimeLine now="review" />

        <span v-if="isNew && shouldShowMessage" class="info" role="alert">
            Se han enviado invitaciones a todos los tutores disponibles
        </span>

        <template v-if="teachers.length">
            <h1 class="margin-bottom--three text--center">
                Tutores disponibles
            </h1>

            <div class="row justify-content-center">
                <div
                    v-for="(teacher, index) in teachers"
                    :key="index"
                    class="col-xs-6 col-sm-3 col-md-3 margin-bottom--three"
                >
                    <TeacherCard
                        :teacher="teacher"
                        @click.native="showModal(index)"
                    />
                </div>
            </div>
        </template>

        <div v-else class="placeholder">
            <div>
                <h1 class="margin-bottom--one text--light">
                    <div v-if="count == 0">
                        No hay tutores disponibles, modifique su propuesta
                    </div>
                    <div v-else>
                        {{count}} tutores han sido invitados
                    </div>
                </h1>
                <p>
                    Aquí se mostrará la relación de tutores que vayan aceptando
                    tu propuesta, paciencia por favor.
                </p>

                <button class="reloader" @click="refresh" title="Actualizar">
                    <i class="reloader__icon icon icon-cw"></i>
                    <p class="reloader__label">Actualizar</p>
                </button>
            </div>
        </div>

        <hr />
        
        <div class="container">
            <h2>Tu propuesta</h2>
            <table class="details">
                <tr>
                    <td>Materia:</td>
                    <td>{{ asigment.category.name }}</td>
                </tr>
                <tr>
                    <td>Nivel:</td>
                    <td>{{ asigment.level.name }}</td>
                </tr>
                <tr>
                    <td>Presupuesto:</td>
                    <td>{{ APP_CURRENCY_SYMBOL }} {{ asigment.budget }}</td>
                </tr>
                <tr>
                    <td>Fecha:</td>
                    <td>{{ asigment.formated_date }}</td>
                </tr>
                <tr>
                    <td>Detalles:</td>
                    <td>{{ asigment.details }}</td>
                </tr>
            </table>

            <h4 class="margin-top--one">Archivos</h4>

            <div>
                <File
                    v-for="(file, index) in asigment.files"
                    :key="index"
                    :file="file"
                    readonly
                />
            </div>
        </div>

        <TeacherModal
            :teacher="currentTeacher"
            :is-visible="isModalVisible"
            @click="handleModalClick"
            @close="isModalVisible = false"
        />

    </div>
</template>

<script>
export default {
    props: [
        'asigment', 
        'teachers', 
        'isNew',
        'count'
        ],

    data: () => ({
        currentTeacher: {},
        isModalVisible: false,
        shouldShowMessage: false,
    }),

    created() {
        if (Number.parseInt(this.isNew)) {
            this.shouldShowMessage = true
            setTimeout(
                () => (this.shouldShowMessage = false),
                3 * 1000 // 3s
            )
        }
    },

    methods: {
        async handleModalClick() {
            const teacher = this.currentTeacher
            const { id } = this.asigment
            window.location.href = route('checkout.index', {
                id,
                teacher_id: teacher.id,
            })
        },

        showModal(index) {
            this.currentTeacher = this.teachers[index]
            this.isModalVisible = true
        },

        refresh: () => window.location.reload(true),
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

hr {
    background: color('gray', 100);
    height: 1px;
    margin: get('two', $spacers);
}

.placeholder {
    height: 50vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.details {
    td:first-child {
        font-weight: get('bold', $font-weights);
        padding-right: get('one', $spacers);
    }
}

.reloader {
    margin-top: 2rem;
    text-align: center;

    &__icon {
        @include size(60px);

        margin: 0 auto;
        display: block;
        color: color('primary');
        background: color('primary');
        color: color('white');
        font-size: 1.75rem;
        line-height: 60px;
        border-radius: 50%;
        transition: background 0.1s ease-in;
    }

    &__icon .icon {
        margin-left: 5px !important;
    }

    &__label {
        margin-top: 0.5rem;
        color: color('gray', 500);
    }
}
</style>

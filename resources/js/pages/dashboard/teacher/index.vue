<template>
    <div class="container">
        <div v-if="status === 'inactive'" class="big-alert">
            <h3 class="margin-bottom--halve big-alert__title">
                <i class="big-alert__icon icon icon-alert"></i>
                <span>Tu cuenta esta inhabilitada</span>
            </h3>
            <p>
                Actualmente tu cuenta esta inhabilitada, esto significa que no
                recibirás notificaciones de nuevas propuestas creadas. <br />
                Cualquier consulta la puedes realizar a
                <a class="link" href="mailto:admin@mathias20.com"
                >admin@mathias20.com</a
				    >
            </p>
        </div>

        <div class="wrapper">
            <div>
                <figure class="picture image">
                    <img :src="avatar" />
                </figure>
            </div>

            <div>
                <h2 class="margin-bottom--zero">{{ full_name }}</h2>

                <Stars :value="stars" />

                <ul class="information margin-top--one text--gray">
                    <li>
                        <i class="icon icon-map"></i>
                        {{ address.line }}, {{ address.city }},
                        {{ address.state }}
                    </li>
                    <li>
                        <i class="icon icon-phone"></i>
                        <span>{{ phone }}</span>
                    </li>
                    <li>
                        <i class="icon icon-mail"></i>
                        <span>{{ email }}</span>
                    </li>

                    <li>
                        <i class="icon icon-gift"></i>
                        <span>{{ formatted_birthday }}</span>
                    </li>
                </ul>

                <div class="link padding-left--one padding-top--halve">
                    <a :href="route('dashboard.edit')">
                        <span>Editar</span>
                        <i class="icon icon-pen"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="margin-top--two">
            <h2 class="text--center margin-bottom--zero">Proximas clases</h2>
            <h4
                v-if="!scheduledClasses.length"
                class="text--center text--gray text--light"
            >
                No hay clases planificadas
            </h4>

            <div v-else class="row justify-content-center margin-top--two">
                <article
                    class="col-xs-12 col-sm-8 col-lg-6"
                    v-for="({ id, date, level, category, details },
			   index) in scheduledClasses"
                    :key="index"
                >
                    <a class="card" :href="route('room', id)">
                        <h4 class="text--uppercase">
                            {{ formatDistance(date) }}
                        </h4>

                        <table>
                            <tr>
                                <td>Nivel:</td>
                                <td>{{ level.name }}</td>
                            </tr>
                            <tr>
                                <td>Categoria:</td>
                                <td>{{ category.name }}</td>
                            </tr>
                            <tr>
                                <td>Detalles:</td>
                                <td>
                                    <p>{{ details }}</p>
                                </td>
                            </tr>
                        </table>
                    </a>
                </article>
            </div>
        </div>

        <div class="invitations margin-top--two">
            <h2 class="text--center margin-bottom--zero">
                Invitaciones pendientes
            </h2>
            <h4
                v-if="!invitations.length"
                class="text--center text--gray text--light"
            >
                Por los momentos no hay nada pendiente
            </h4>

            <div v-else class="row justify-content-center margin-top--two">
                <article
                    class="col-xs-12 col-sm-8 col-lg-6"
                    v-for="({
                           id,
                           asigment: { budget, level, category, details, date },
			   },
			   index) in invitations"
                    :key="index"
                >
                    <a class="card" :href="route('invitation.show', id)">
                        <span class="card__budget">
                            {{ APP_CURRENCY_SYMBOL }}
                            {{ budget-3 }}
                        </span>

                        <table>
                            <tr>
                                <td>Nivel:</td>
                                <td>{{ level.name }}</td>
                            </tr>
                            <tr>
                                <td>Categoria:</td>
                                <td>{{ category.name }}</td>
                            </tr>
                            <tr>
                                <td>Detalles:</td>
                                <td>
                                    <p>{{ details }}</p>
                                </td>
                            </tr>
                        </table>

                        <span class="card__date">
                            <i class="icon icon-calendar"></i>
                            {{ formatDistance(date) }}</span>
                    </a>
                </article>
            </div>
        </div>
	<h2 class="text--center margin-top--four">Clases finalizadas</h2>
	<table>
            <thead>
                <tr>
                    <th>Nivel</th>
                    <th>Categoria</th>
                    <th>Detalle</th>
                    <th>Pago</th>
		    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
		    
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="(classe, index) in classesFinish"
                    :key="index"
                    @click=""
                    :class="'is-' + classe.status"
                    v-if="teacher.address!== null">
                    <td>{{ classe.level.name }}</td>
                    <td>{{ classe.category.name }}</td>
                    <td class="showDetails">{{ classe.details }}</td>
                    <td v-if="classe.deposit_voucher">
			<a :href="`${classe.deposit_voucher.path}`" target="_blank" >Ver comprobante</a>
		    </td>
		    <td v-else>Sin comprobante</td>
		    <td></td>

                </tr>
            </tbody>
        </table>
        <div class="margin-top--two">
            <div class="margin-bottom--one text--center">
                <h2 class="margin-bottom--one">Tu horario</h2>
                <p>
                    Estas son las horas que tienes disponibles para dar classes,
                    puedes cambiarlas en cualquier momento.
                </p>

                <Button
                    class="margin-top--two"
                    @click="
                    canEditSchedule
                    ? saveSchedule()
                    : (canEditSchedule = true)
                    "
                    :outline="!canEditSchedule"
                    :loading="loading"
                >{{ canEditSchedule ? 'Guardar' : 'Editar' }}</Button
							     >

                <span v-if="success" class="success" role="alert"
                >Cambios guardados correctamente.</span
						 >
                <span v-if="error" class="error" role="alert">{{ error }}</span>
            </div>

            <Schedule v-model="editableSchedule" :readonly="!canEditSchedule" />
        </div>

        <div class="margin-top--three">
            <h2 class="text--center">Tus puntajes</h2>
            <Scores :scores="scores" />
        </div>
    </div>
</template>

<script>
 import formatDistance from 'date-fns/formatDistance'
 import { es } from 'date-fns/locale'
 export default {
     props: ['teacher', 'invitations', 'scheduledClasses','classesFinish'],
     data: ({ teacher }) => ({
         ...teacher,
         editableSchedule: null,
         canEditSchedule: false,
         loading: false,
         success: false,
         error: null,
     }),
     created() {
         const { schedule } = this
	 const {classesFinish} = this

         const timeToNumber = time => Number(time.slice(0, time.indexOf(':')))
         const grouped = schedule.reduce((array, row) => {
             const { day_of_week, start, end } = row
             array[day_of_week] = array[day_of_week] || []
             const range = [start, end].map(timeToNumber)
             array[day_of_week].push(range)
             return array
         }, {})
         this.editableSchedule = grouped
     },
     methods: {
         formatDistance: date =>
             formatDistance(new Date(date), Date.now(), {
                 locale: es,
                 addSuffix: true,
             }),
         async saveSchedule() {
             if (this.loading) return
             this.loading = true
             this.success = false
             this.error = null
             try {
                 const { id } = this
                 const url = route('teacher.schedule', id)
                 const data = { schedule: this.editableSchedule }
                 await this.$http.put(url, data)
                 this.success = true
                 this.canEditSchedule = false
                 setTimeout(() => (this.success = false), 3000)
             } catch (error) {
                 console.error(error.response || error)
                 this.error =
                     'Hubo un error al guardar los cambios, intentelo mas tarde.'
	     } finally {
		 this.loading = false
	     }
	 },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
 .big-alert {
     padding: 1.75rem;
     border: 1px solid color('red');
     margin-bottom: 2.5rem;
     border-radius: 5px;
 }
 .big-alert__title {
     color: color('red');
 }
 .wrapper {
     display: flex;
     flex-flow: column;
     @include breakpoint('sm') {
         flex-flow: row;
     }
 }
 .picture {
     @include size(216px);
     border-radius: 10px;
     margin-right: 1rem;
     margin-bottom: 0.5rem;
     @include breakpoint('sm') {
         @include size(255px);
     }
 }
 .information {
     .icon {
         font-size: 1.25rem;
     }
 }
 .card {
     position: relative;
     display: block;
     padding: 1.5rem;
     padding-top: 1rem;
     margin-bottom: 1rem;
     border: 1px solid color('gray', 100);
     border-radius: 10px;
     table {
         width: 100%;
     }
     table td:first-child {
         font-weight: get('bold', $font-weights);
         padding-right: 0.5rem;
     }
     table td:nth-child(2) p {
         @include ellipsis;
         max-width: 125px;
         @include breakpoint('sm') {
             max-width: 300px;
         }
     }
 }
 .card__budget {
     font-weight: get('regular', $font-weights);
     font-size: 2.25rem;
     margin-bottom: 2rem;
 }
 .card__date {
     position: absolute;
     top: 1.5rem;
     right: 1.5rem;
     color: color('gray', 400);
 }
 table {
     width: 100%;
 }
 thead {
     border-bottom: 2px solid color('gray', 50);
     th {
         font-weight: get('bold', $font-weights);
         padding: 0.5rem 0.5rem;
         text-align: left;
     }
 }
 tbody tr {
     position: relative;
     cursor: pointer;
     &:hover {
         background: color('gray', 50, 0.15);
     }
     td {
         position: relative;
         border-bottom: 1px solid color('gray', 50);
         padding: 0.75rem 0.5rem;
         vertical-align: middle;
     }
 }
 td:last-child:before {
     $size: 15px;
     content: '';
     position: absolute;
     top: 23px;
     right: 30px;
     background: transparent;
     @include size($size);
     border-radius: 50%;
     tr.is-finished & {
         background: color('yellow');
     }
     tr.is-paid & {
         background: color('green');
     }

 }
 .showDetails{
     width:100px;
 }
</style>

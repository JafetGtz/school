<template>
    <div class="">
        <h1>Tutores</h1>

        <article
            :class="['details', `details--is-${currentTeacher.status}`]"
            v-if="shouldShowDetails"
        >
            <button class="details__x" @click="hideDetails">
                <i class="icon icon-x"></i>
            </button>

            <div class="details__body">
                <figure class="details__avatar image">
                    <img :src="currentTeacher.avatar" />
                </figure>

                <div class="margin-left--one">
                    <h2 class="margin-bottom--zero">
                        {{ currentTeacher.full_name }}
                    </h2>
                    <Stars :value="currentTeacher.stars" />

                    <ul class="margin-top--one text--gray">
                        <li>
                            <i class="icon icon-map"></i>
                            {{ currentTeacher.address.line }},
                            {{ currentTeacher.address.city }},
                            {{ currentTeacher.address.state }}
                        </li>
                        <li>
                            <i class="icon icon-phone"></i>
                            <span>{{ currentTeacher.phone }}</span>
                        </li>
                        <li>
                            <i class="icon icon-mail"></i>
                            <span>{{ currentTeacher.email }}</span>
                        </li>

                        <li>
                            <i class="icon icon-gift"></i>
                            <span>{{ currentTeacher.formatted_birthday }}</span>
                        </li>

                        <li>
                            <i class = "icon icon-file-pdf"></i>
                            <span>
                                <a :href="'storage/'+`${currentTeacher.document}`" target="_blank" >DNI</a>   
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="details__panel">
                    <header>
                        <h4>Estado</h4>
                        <p></p>
                    </header>

                    <Radio
                        v-model="currentTeacher.status"
                        class="margin-bottom--halve"
                        value="active"
                        label="Activo"
                    />

                    <Radio
                        v-model="currentTeacher.status"
                        value="inactive"
                        label="Inactivo"
                    />
                </div>
            </div>
	    <br>
	    <label>Niveles: </label>
	    <a>{{currentTeacher.niveles}}</a>
	    <br>
	    <label>Especialidades: </label>
	    <a>{{currentTeacher.categorias}}</a>
	    <h4></h4>
	    <Scores class="margin-top--one" :scores="currentTeacher.scores" />
	    <div class="container">
		<div class="row">
		    <div class="col-md-6">
			<Button
			    class="margin-top--two"
			    @click="
			    showClasses=!showClasses
			    "
			    :outline="!showClasses"
			>{{ !showClasses ? 'Mostrar clases' : 'Ocultar clases' }}</Button
										 >
		    </div>
		    <div class="col-md-6">
			<Button
			    class="margin-top--two"
			    @click="
			    showSche=!showSche
			    "
			    :outline="!showSche"
			>{{ !showSche ? 'Mostrar disponibilidad' : 'Ocultar disponibilidad' }}</Button
											      >
		    </div>
		</div>
		<Schedule v-if="showSche" v-model="editableSchedule" :readonly="!canEditSchedule" />
		<!-- -------------------------------------------------- -->
		<div class="margin-top--two"  v-if="showClasses">
		    <h2 class="text--center margin-bottom--zero">Clases </h2>
		    <h4
			v-if="!currentTeacher.asigments.length"
			class="text--center text--gray text--light">
			No hay clases  
		    </h4>

		    <div v-else class="row justify-content-center margin-top--two">
			<article
			    class="col-xs-12 col-sm-8 col-lg-6"
			    v-for="({ id, date, details,budget,status,level_id },
				   index) in currentTeacher.asigments"
			    :key="index">
			    <div v-if="status!='canceled'">
				<a class="card">
				    <h4 class="text--uppercase">
					{{ budget }}
				    </h4>
				    <table>
					<tr>
					    <td>Nivel:</td>
					    <td>
						<p>{{ level_id }}</p>
					    </td>
					</tr>
					<tr>
					    <td>Detalles:</td>
					    <td>
						<p>{{ details }}</p>
					    </td>
					</tr>
					<tr>
					    <td>Estado:</td>
					    <td>
						<p>{{ status }}</p>
					    </td>
					</tr>
				    </table>
				</a>
			    </div>
			</article>
		    </div>
		</div>
		
		
	    </div>
        </article>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="(teacher, index) in teachers"
                    :key="index"
                    @click="showDetails(teacher)"
                    :class="'is-' + teacher.status"
                    v-if="teacher.address!== null">
                    <td>
                        <figure class="avatar image">
                            <img :src="teacher.avatar" />
                        </figure>
                    </td>
                    <td>{{ teacher.full_name }}</td>
                    <td>{{ teacher.email }}</td>
                    <td>{{ teacher.phone }}</td>
                    <td><Stars :value="teacher.starts" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
 export default {
     props: ['teachers'],
     data: () => ({
         currentTeacher: {},
	 editableSchedule: null,
         shouldShowDetails: false,
	 showSche:false,
	 showClasses:false,
     }),
     computed: {
         status: () => ({
             fresh: 'nuevo',
             active: 'activo',
             inactive: 'inactivo',
         }),
     },
     watch: {
         currentTeacher: {
             deep: true,
             handler(newValue, oldValue) {
                 if (newValue.id !== oldValue.id) return
                 const { id, status } = newValue
                 this.changeStatus(id, status)
             },
	 },
	 
     },
     methods: {
         showDetails(teacher) {
             this.currentTeacher = teacher
             this.shouldShowDetails = true
	     
	     Object.keys(teacher.asigments).forEach(function(key) {
		 if(teacher.asigments[key].status=='finished'){
		     teacher.asigments[key].status = 'Finalizada'
		 }else if(teacher.asigments[key].status=='waiting-for-class'){
		     teacher.asigments[key].status = 'Esperando clase'
		 }

		 if(teacher.asigments[key].level_id=='1'){
		     teacher.asigments[key].level_id = 'Primaria'
		 }else if(teacher.asigments[key].level_id=='2'){
		     teacher.asigments[key].level_id = 'Secundaria'
		 }else if(teacher.asigments[key].level_id=='3'){
		     teacher.asigments[key].level_id = 'Pre-Universidad'
		 }else if(teacher.asigments[key].level_id=='4'){
		     teacher.asigments[key].level_id = 'Universidad'
		 }
		 
	     })
	     teacher.niveles = ""
	     Object.keys(teacher.levels).forEach(function(key) {
		 teacher.niveles += teacher.levels[key].name+"/"
	     })
	     teacher.categorias = ""
	     Object.keys(teacher.categories).forEach(function(key) {
		 teacher.categorias += teacher.categories[key].name+"/"
	     })
	     console.log(teacher)
	     const { schedule } = teacher
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
	 hideDetails() {
	     this.currentTeacher = {}
	     this.shouldShowDetails = false
	 },
	 async changeStatus(teacherId, status) {
	     try {
		 const url = route('teacher.status', teacherId)
		 await this.$http.post(url, { status })
	     } catch (error) {
		 console.error(error.response || error)
	     }
	 },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
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
         max-width: 100px;

         @include breakpoint('sm') {
             max-width: 170px;
         }
     }
 }


 .card__date {
     position: absolute;
     top: 1.5rem;
     right: 1.5rem;
     color: color('gray', 400);
 }
 .avatar {
     @include size(40px);
     border-radius: 50%;
 }
 .details {
     position: relative;
     border: 1px solid color('gray', 50);
     border-radius: 10px;
     padding: 1rem;
     margin-bottom: 2rem;
 }
 .details__x {
     position: absolute;
     top: 1rem;
     right: 1rem;
     font-size: 1.75rem;
     color: color('gray');
 }
 .details__body {
     display: flex;
 }
 .details__panel {
     border-left: 1px solid color('gray', 50);
     margin-left: 2rem;
     padding-left: 2rem;
 }
 .details__avatar {
     @include size(190px);
     border-radius: 5px;
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
     tr.is-fresh & {
         background: color('yellow');
     }
     tr.is-active & {
         background: color('green');
     }
     tr.is-inactive & {
         background: color('red');
     }
 }
</style>

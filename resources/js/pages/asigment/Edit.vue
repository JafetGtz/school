<template>
    <div class="container">
	<form @submit.prevent="handleSubmit">

            <h1 class="text--center margin-bottom--three">Editar propuesta</h1>

            <div class="row">
		<div class="col-sm-4 margin-bottom--one">
                    <span
			v-if="errors.has('level_id')"
			class="text--red text--bold"
			role="alert"
                    >
			{{ errors.first('level_id') }}
                    </span>

                    <h4>Nivel</h4>

                    <Radio
			v-for="(level, index) in levels"
			:key="index"
			v-model="form.level_id"
			:value="level.id"
			:label="level.name"
			@cambiarC="cambiarValor"
                    />
		</div>

		<div class="col-sm-8">
                    <span
			v-if="errors.has('category_id')"
			class="text--red text--bold"
			role="alert"
                    >
			{{ errors.first('category_id') }}
                    </span>

                    <h4>Materia</h4>

                    <div class="row">
			<Radio
                            class="col-xs-6"
                            v-for="(category, index) in categories"
                            :key="index"
                            v-model="form.category_id"
                            :value="category.id"
                            :label="category.name"
			/>
                    </div>
		</div>
            </div>

            <div class="margin-top--two">
		<h4 class="margin-bottom--one">
                    ¿Cuando te gustaría tener la clase?
		</h4>

		<span v-if="errors.has('date')" class="error" role="alert">
                    {{ errors.first('date') }}
		</span>

		<div class="row">
                    <Input
			v-model="form.date"
			class="col-xs-6 col-md-3"
			label="Fecha"
			required
			type="date"
                    />

                    <Input
			v-model="form.time"
			class="col-xs-6 col-md-2"
			label="Hora"
			required
			type="time"
                    />
		</div>
            </div>

            <div class="margin-top--two">
		<h4 class="margin-bottom--halve">Adjuntar archivos</h4>
		<table class="margin-bottom--two">
                    <tr>
			<td class="padding-right--one">Número máximo:</td>
			<td>{{ files.length }}/{{ MAX_FILE_NUM }}</td>
                    </tr>
                    <tr>
			<td class="padding-right--one">Peso limite:</td>
			<td>{{ maxFileSize }}</td>
                    </tr>
                    <tr>
			<td class="padding-right--one">Formatos:</td>
			<td>{{ allowedFileExtensions.toUpperCase() }}</td>
                    </tr>
		</table>

		<span v-if="errors.has('files')" class="error" role="alert">{{
									    errors.first('files')
									    }}</span>

		<div class="row margin-top--one">
                    <div class="col-xs-12 col-md-6">
			<label class="box" for="files" ref="box">
                            <div class="box__container">
				<input
                                    class="box__input"
                                    id="files"
                                    type="file"
                                    multiple
                                    @change="handleFilesUpload"
                                    :accept="allowedFileExtensions"
				/>

				<i class="box__icon icon icon-upload"></i>

				<label for="files" class="box__label"
				><strong>Elige un archivo</strong> o arrastralo
                                    hasta aquí</label
					      >
                            </div>
			</label>
                    </div>
                    <div class="col-xs-12 col-md-6">
			<File
                            v-for="(file, index) in files"
                            :key="index"
                            :file="file"
                            @remove="removeFile(index)"
			/>
                    </div>
		</div>
            </div>

            <div class="margin-top--three">
		<h4 class="margin-bottom--zero">Detalles</h4>
		<p>
                    Por favor, especificar cuales son los ejercicios a desarrollar.
		</p>

		<Input
                    class="margin-top--one"
                    v-model="form.details"
                    :error="errors.first('details')"
                    textarea
                    rows="3"
                    
		/>
            </div>
	    <div class="col-xs-12 col-sm-7 col-lg-5">
		<h4 class="margin--zero">Horas de clase</h4>
		<p>
		    Indique la cantidad de horas de clase que necesita
		</p>
		<Select
                    v-model="form.country"
                    :options="['1','2','3','4']"
                    :error="errors.first('country')"
                    required
		    @evento="cambiarPresupuesto"
		/>

            </div>
            <footer class="col-xs-11 col-sm-6 margin-top--three">
		<h3>Presupuesto calculado</h3>

		<span class="error" v-if="errors.has('budget')" role="alet">
                    {{ errors.first('budget') }}
		</span>

		<div class="budget margin-top--one margin-bottom--three">
                    <span class="budget__currency">{{ APP_CURRENCY_SYMBOL }}</span>
                    <label
			class="budget__field"
			v-model="form.budget"
			type="number">{{form.budget}}</label>
		</div>

		<Button
                    class="margin-top--two"
                    type="submit"
                    :loading="loading"
                    block
		>Guardar</Button
			>
            </footer>
	</form>
    </div>
</template>

<script>
 import handleFormError from '../../utils/handleFormError'

 export default {
     props: [
         'valor',
         'levels',
         'categories',
         'ALLOWED_FILE_EXTENSIONS',
         'MAX_FILE_SIZE',
         'MAX_FILE_NUM',
         'assignment',
     ],

     data: () => ({
         form: {
             //level_id: undefined,
             category_id: undefined,
             details: null,
             date: null,
             time: null,
             budget: 3,
             category:1,
         },
         hours: 1,
         files: [],
         loading: false,
         errors: new ErrorBag(),
     }),

     created() {
         const { assignment, form, files } = this
         form.details= assignment.details
         form.budget = assignment.budget
         form.hours = assignment.hours.toString()
         form.category_id = assignment.category_id
         form.level_id = assignment.level_id

         
         // We can use the object like a string
         let [dat,tim] = assignment.date.split(' ')
         var time_split = tim.split(':')
         form.date = dat
         form.time = time_split[0]+':'+time_split[1] 
         console.log(time_split)
         assignment.files.forEach(function(file){
             files.push(file)
         });

         form.category = 3+(assignment.level_id);  
         form.budget = 3+form.category*(form.hours);
	 
     },

     mounted() {
         const { box, fileInput } = this.$refs

         box.ondragover = box.ondragenter = e => {
             e.preventDefault()
             e.stopPropagation()
         }

         box.ondrop = e => {
             e.preventDefault()
             this.addFiles(e.dataTransfer.files)
         }
     },

     computed: {
         allowedFileExtensions() {
             return this.ALLOWED_FILE_EXTENSIONS.map(key => '.' + key).join(', ')
         },

         maxFileSize() {
             const size = this.MAX_FILE_SIZE / 1024
             if (size < 700) return size + 'KB'
             else return size / 1024 + 'MB'
         },
     },

     methods: {
         async handleSubmit() {
             const {assignment,files} = this
             console.log(files)
             if (this.loading) return

             this.loading = true
             this.errors.clear()

             const { form } = this
             const data = new FormData()

             const date = new Date(form.date)
             const time = form.time
             const [hours, minutes] = time.split(':').map(Number)
             
             date.setDate(date.getDate() + 1)
             date.setHours(hours, minutes, 0, 0)
             date.setMinutes(date.getMinutes() - date.getTimezoneOffset())

             const today = new Date()
             today.setMinutes(today.getMinutes() - today.getTimezoneOffset())
             data.append('hours', this.form.hours)
             if (date < today) {
                 const errors = {
                     date: ['La fecha debe ser un día y hora en el futuro.'],
                 }

                 const validationErrors = handleFormError({
                     response: { data: { errors } },
                 })

                 this.errors.set(validationErrors)
                 this.loading = false
             }

             Object.keys(form).forEach(key => data.append(key, form[key]))
             data.set('date', date.toISOString())
             /* data.append('files', null) */
             files.forEach((file, index) =>
                 data.append(`files[${index}]`, file)
             )
             


             data.append('hours', this.form.hours)

             try {
                 const url = route('asigment.editStore',assignment.id)
                 const { data: id } = await this.$http.post(url, data)
                 window.location.href = route('dashboard.index')
             } catch (error) {
                 const validationErrors = handleFormError(error)
                 this.errors.set(validationErrors)
             } finally {
                 this.loading = false
             }
         },

         cambiarValor(val){
             this.form.category = 3+(val);  
             this.form.budget= 3+this.form.category*(this.form.hours);
         },
         
         // Change the value, with new parameters.
         cambiarPresupuesto(d){
             this.form.hours = d;
             this.form.budget= 3+(d)*(this.form.category);
         },
         
         handleFilesUpload(e) {
             console.log(e)
             console.log(e.target.files)
             this.addFiles(e.target.files)
             e.target.file = null
         },

         addFiles(files) {
             const diff = this.MAX_FILE_NUM - this.files.length

             if (diff < 0) return

             files = [].slice.call(files, 0, diff)

             files = files.filter(file => {
                 if (file.size > this.MAX_FILE_SIZE) return false

                 const { name } = file
                 const ext = name.slice(name.lastIndexOf('.') + 1)
                 return this.ALLOWED_FILE_EXTENSIONS.indexOf(ext) > -1
             })
             
             this.files.push(...files)
         },

         removeFile(index) {
             this.files.splice(index, 1)
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 form {
     margin: 0 auto;
 }

 form {
     @include breakpoint('md') {
         width: 85%;
     }
     @include breakpoint('lg') {
         width: 80%;
     }
 }

 .box {
     height: 270px;
     display: block;
     color: color('gray', 600);
     background: color('gray', 50, 0.1);
     border: 3px dashed color('gray', 100);
     padding: 10px;
     border-radius: 6px;
     cursor: pointer;
 }

 .box__input {
     @include hide-visually;
 }

 .box__container {
     display: flex;
     height: 100%;
     flex-flow: column;
     align-items: center;
     text-align: center;
     color: color('gray');
 }

 .box__icon {
     color: color('gray', 100);
     display: block;
     font-size: 6rem;
 }

 .box__label {
     cursor: pointer;
 }

 .budget {
     display: flex;
     font-size: get('large', $font-sizes) * 2.5;
     text-align: center;
     font-weight: get('bold', $font-weights);
     border-bottom: 1px solid color('gray', 300);
     color: color('black');
 }

 .budget__field {
     width: 100%;
     padding-left: 1rem;
     color: inherit;
     font-weight: inherit;
 }
</style>

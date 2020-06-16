<template>
    <div class="container">
	<form @submit.prevent="handleSubmit">
            <h1 class="text--center">Editar </h1>
	    <div id ="showErrors" ></div>
	    <label class="imageinput" :class="{ 'imageinput--is-filled': image }">
		<i class="icon icon-user"></i>
		<img v-show="image" :src="image" />
		<input
                    type="file"
                    @change="handleImage"
                    :accept="toAccepted(ALLOWED_PICTURE_EXTENSIONS)"
		/>
            </label>
	    <ul class="text--gray text--center">
		<li>Máximo: {{ maxSizeToKbs }}</li>
		<li>Formatos: {{ toList(ALLOWED_PICTURE_EXTENSIONS) }}</li>
		<li>Tamaño recomendado: 216px x 216px</li>
            </ul>
	    <span v-show="error" class="edit__error margin-top--two" role="alert">
		<strong>{{ error }}</strong>
	    </span>
	    <div class="margin-top--two">
		<h4 class="margin-bottom--halve">Identificación</h4>
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
                                    @change="handleFileChange"
                                    :accept="allowedFileExtensions"
				/>

				<i class="box__icon icon icon-upload"></i>

				<label for="files" class="box__label"
				><strong>Elige un archivo</strong> o arrastralo
                                    hasta aquí (Solo si desea cambiar su actual identifiación)</label>
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
	    <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.email"
			label="email"
			required
			autocomplete="email"
			autofocus/>
		</div>
		<div class="col-xs-12 col-sm-6">
		    <Input
			label="Contraseña actual"
			v-model="form.passworda"
			type="password"
			require
			autocomplete="contraseña"
			autofocus/>
		</div>
            </div>
	    <div class="row">
		<div class="col-xs-12 col-sm-6">
		    <Input
			label="Nueva Contraseña"
			v-model="form.password1"
			type="password"
			placeholder="6+ caracteres"
			autocomplete="contraseña"
			autofocus/>
		</div>
		<div class="col-xs-12 col-sm-6">
		    <Input
			type="password"
			label="confirmar contraseña"
			v-model="form.password"
			placeholder="6+ caracteres"
			autocomplete="contraseña"
			autofocus/>
		</div>
            </div>
            <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <div class="row">
			<Input
                            class="col-xs-6"
                            v-model="form.first_name"
                            :value="teacher.first_name"
                            label="Nombres"
                            :error="errors.first('first_name')"
			/>

			<Input
                            class="col-xs-6"
                            v-model="form.last_name"
                            label="Apellidos"
                            :error="errors.first('last_name')"
			/>
                    </div>
		</div>

		<div class="col-xs-12 col-sm-6">
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

            <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <h6 class="margin--zero">Nacionalidad</h6>

                    <Select
			v-model="form.country_id"
				 :options="countries"
			:error="errors.first('country')"
			required
                    />
		</div>

		<div class="col-xs-12 col-sm-6">
                    <!-- TODO: maybe add phone field here -->
		</div>
            </div>

            <div class="row">
		<h5 class="margin-top--two margin-bottom--zero col-xs-12">
                    Dirección
		</h5>
		<div class="col-xs-12 col-sm-6">
                    <Select
			v-model="form.address.country_id"
				 label="país"
				 :options="countries"
			:error="errors.first('address.country')"
                    ></Select>
		</div>
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.address.city"
				 label="cuidad"
				 :error="errors.first('address.city')"
                    />
		</div>
            </div>

            <Input
		v-model="form.address.line"
			 label="dirección"
			 :error="errors.first('address.line')"
		textarea
            />

            <div class="row">
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.address.zip_code"
				 label="código postal"
				 :error="errors.first('address.zip_code')"
			type="number"
                    />
		</div>
		<div class="col-xs-12 col-sm-6">
                    <Input
			v-model="form.address.state"
				 :error="errors.first('address.state')"
			label="estado/provincia"
                    />
		</div>
            </div>

            <h3 class="margin-top--three">
		Niveles de educación capacitado para enseñar
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

            <h3 class="margin-top--three">Tus especialidades</h3>

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

            <div class="margin-top--two">
		<h3 class="margin-bottom--zero">Cuenta bancaria</h3>
		<div class="row">
                    <div class="col-xs-12 col-sm-6">
			<Input
                            v-model="form.bank.entity"
                            class="bank-name-field"
                            label="Entidad financiera"
			/>
                    </div>
                    <div class="col-xs-12 col-sm-6">
			<Input
                            v-model="form.bank.account_number"
                            label="Número de cuenta bancaria"
			/>
                    </div>
		</div>
            </div>
	    <span v-if="errors.has('document')" class="error" role="alert">
		{{ errors.first('document') }}
            </span>
            <footer class="margin-top--three">
		<Button type="submit" :loading="loading">Guardar</Button>
            </footer>
	</form>
    </div>
</template>

<script>
 import handleFormError from '../../../utils/handleFormError'

 export default {
     props: ['teacher', 'levels', 'categories',
	     'countries','ALLOWED_PICTURE_EXTENSIONS',
	     'MAX_PICTURE_SIZE','ALLOWED_FILE_EXTENSIONS',
             'MAX_FILE_SIZE',
             'MAX_FILE_NUM',],

     data: () => ({

         form: {
             birthday: [],
             address: {},
             levels: [],
             categories: [],
             bank: {},
	     avatar:null,
	     document:null,
         },
	 files: [],
	 error:'',
	 image: null,
         loading: false,
         errors: new ErrorBag(),
     }),
     computed: {
	 allowedFileExtensions() {
             return this.ALLOWED_FILE_EXTENSIONS.map(key => '.' + key).join(', ')
         },
         maxSizeToKbs() {
             return this.MAX_PICTURE_SIZE / 1024 + 'KB'
         },
	 maxFileSize() {
             const size = this.MAX_FILE_SIZE / 1024
             if (size < 700) return size + 'KB'
             else return size / 1024 + 'MB'
         },
     },
     created() {
	 const { teacher, form,image,files } = this
         this.image = teacher.avatar;
	 form.first_name = teacher.first_name
         form.last_name = teacher.last_name
	 form.email = teacher.email
         const { bank } = teacher
         if (bank) {
             form.bank.entity = bank.entity
             form.bank.account_number = bank.account_number
         }

         const birthday = new Date(teacher.birthday)

         form.birthday = [
             birthday.getDate() + 1,
             birthday.getMonth() + 1,
             birthday.getFullYear(),
         ]

         form.country_id = teacher.country_id

         // Address
         const { address } = teacher
         form.address.country_id = address.country_id
         form.address.city = address.city
         form.address.line = address.line
         form.address.zip_code = address.zip_code
         form.address.state = address.state

         // Levels & Categories
         const { levels, categories } = teacher

         const mapper = ({ id }) => id
         form.levels = levels.map(mapper)
         form.categories = categories.map(mapper)
     },

     methods: {
	 toAccepted: arr => arr.map(key => '.' + key).join(','),
         toList: arr => arr.map(s => s.toUpperCase()).join(', '),
	 handleFileChange(e) {
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
	     this.form.document = this.files[0];
         },

         removeFile(index) {
             this.files.splice(index, 1)
         },
         async handleSubmit() {
             if (this.loading) return
             this.loading = true
             this.errors.clear()
             try {
                 const data = new FormData()
		 
                 data.append('bank.entity',(this.form.bank.entity || '').toUpperCase())
                 const birthday  = this.form.birthday
                 data.append('birthday',(
                     birthday[2]+"-"+
										     (birthday[1])+"-"+ // Month, wich is 0 based
                     birthday[0] //Date
                 ))
		 if(this.form.first_name){
		     data.append('first_name',this.form.first_name)
		 }
		 if(this.form.last_name){
		     data.append('last_name',this.form.last_name)
		 }
		 if(this.form.address.city){
		     data.append('address.city',this.form.address.city)
		 }
		 if(this.form.address.country_id){
		     data.append('address.country_id',this.form.address.country_id)
		 }
		 if(this.form.address.line){
		     data.append('address.line',this.form.address.line)
		 }
		 if(this.form.address.zip_code){
		     data.append('address.zip_code',this.form.address.zip_code)
		 }
		 if(this.form.address.state){
		     data.append('address.state',this.form.address.state)
		 }
		 if(this.form.levels[0]){
		     data.append('levels[]',this.form.levels)
		 }
		 if(this.form.categories[0]){
		     data.append('categories[]',this.form.categories)
		 }
		 if(this.form.country_id){
		     data.append('country_id',this.form.country_id)
		 }
		 if(this.form.password){
		     data.append('pass1',this.form.password)
		     data.append('pass2',this.form.password1)
		 }
		 data.append('email',this.form.email)
		 data.append('passa',this.form.passworda)
		 const {  avatar,document } = this.form
		 data.append('avatar', this.teacher.avatar)
		 data.append('filee', document)
		 const { id } = this.teacher
                 const url = route('teacher.update', id)
                 await this.$http.post(url, data).then((res)=>{
		     if(res.data=="pass"){
			 window.location.href = route('dashboard.index')
		     }else{
			 this.error= res.data
			 window.location.hash = '#showErrors';
		     }
		 })
	     } catch (error) {
		 const validationErrors = handleFormError(error)
		 this.errors.set(validationErrors)
	     } finally {
		 this.loading = false
	     }
	 },
	 handleImage({ target: { files } }) {
             this.error = null
             this.image = null

             const [image] = files

             if (!image) return

             if (image.size > this.MAX_PICTURE_SIZE) {
                 this.error = `La imagen no debe pesar mas de ${this.maxSizeToKbs}`
                 return
             }

             const reader = new FileReader()
             reader.onload = e => (this.image = e.target.result)
             reader.readAsDataURL(image)
	     this.teacher.avatar = image
             this.form.avatar = image
         },
	 
         
     },
 }
</script>
<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
 .box {
     height: 150px;
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
     font-size: 3rem;
 }

 .box__label {
     cursor: pointer;
 }
 .bank-name-field input {
     text-transform: uppercase !important;
 }
 .imageinput {
     @include size(200px);

     max-width: 100%;
     display: block;
     position: relative;
     margin: 30px auto;
     border-radius: 10px;
     border: 2px dashed color('gray', 100);
     cursor: pointer;

     input {
         @include hide-visually;
     }

     img {
         @include size(100%);
         @include position(absolute, 0, 0);

         object-fit: cover;
     }

     &--is-filled {
         border: 0;
         overflow: hidden;
     }

     .icon {
         @include centered;

         color: color('gray', 100);
         font-size: 10rem;
     }
     
 }
 .edit__error{
     padding: get('one', $spacers);
     margin-top: get('two', $spacers) * -1;
     margin-bottom: get('two', $spacers);
     border: 1px solid color('red');
     color: color('red');
     border-radius: 4px;
     display: block;
     text-align: center;
 }
</style>

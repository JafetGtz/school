<template>
    <form @submit.prevent="handleSubmit">
        <h1>Necesitamos un documento de identificación</h1>
        <p>
            Para asegurarnos que eres una persona real necesitamos que nos
            facilites algún tipo de documento de identidad de tu pertenencia, de
            esta forma podremos dar de alta tu nuevo perfil y podras empezar a
            trabajar en nuestra plataforma.
        </p>

        <div class="margin-top--three margin-bottom--three">
            <span v-if="errors.has('document')" class="error" role="alert">
                {{ errors.first('document') }}
            </span>

            <input
                type="file"
                @change="handleFileChange"
                :accept="toAccepted(ALLOWED_DOCUMENT_EXTENSIONS)"
            />
            <p class="margin-top--one">
                Formatos: {{ toList(ALLOWED_DOCUMENT_EXTENSIONS) }}
            </p>
        </div>

        <h1 class="text--center">Foto de perfil</h1>

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

        <span v-if="error" class="error text--center" role="alert">{{
								   error
								   }}</span>

        <footer class="margin-top--three">
            <Button class="margin--auto" type="submit" block :loading="loading"
            >Finalizar</Button
		      >
            <Button
                :href="route('questions', 3)"
                class="margin--zero"
                color="gray"
                flat
                block
            >Atras</Button
		  >
        </footer>
    </form>
</template>

<script>
 export default {
     props: {
         old: Object,
         ALLOWED_PICTURE_EXTENSIONS: Array,
         ALLOWED_DOCUMENT_EXTENSIONS: Array,
         MAX_PICTURE_SIZE: Number,
         loading: Boolean,
         errors: ErrorBag,
     },

     data: () => ({
         form: {
             document: null,
             avatar: null,
         },
         image: null,
         error: '',
     }),

     computed: {
         maxSizeToKbs() {
             return 100
         },
     },

     methods: {
         toAccepted: arr => arr.map(key => '.' + key).join(','),
         toList: arr => arr.map(s => s.toUpperCase()).join(', '),

         handleSubmit() {
             if (!this.form.avatar) {
                 this.error = 'Por favor elige una foto para tu perfil'
                 return
             }

             const data = new FormData()
             const { document, avatar } = this.form
             data.append('document', document)
             data.append('avatar', avatar)

             this.$emit('submit', data)
         },

         handleFileChange({ target: { files } }) {
             this.form.document = files[0]
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

             this.form.avatar = image
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

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

 footer {
     width: 280px !important;
     max-width: 100%;
     margin: 0 auto;
 }
</style>

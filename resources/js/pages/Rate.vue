<template>
    <div class="container">
	<form @submit.prevent="handleSubmit" class="text--center">
            <h1 class="margin-bottom--zero">Danos tu opinión</h1>
            <p>
		¿Que tal fue tu experiencia con
		<strong> {{ teacher.full_name }}</strong
						>? Danos tu puntuación según estos criterios
            </p>

            <figure class="margin-top--two margin-top--two image">
		<img :src="teacher.avatar" />
            </figure>

            <div class="row margin-top--three justify-content-center">
		<div
                    v-for="{ id, name } in criterias"
                    :key="id"
                    class="col-xs-12 col-sm-6 col-md-4 margin-bottom--two"
		>
                    <h5 class="margin-bottom--zero text--light">{{ name }}</h5>
                    <Stars
			v-model="form[id]"
			class="margin-top--halve"
			:readonly="false"
                    />
		</div>
            </div>

            <div v-if="error" class="error" role="alert">{{ error }}</div>

            <Button type="submit" class="margin-top--two" :loading="loading"
            >Continuar</Button
		      >
	</form>
    </div>
</template>

<script>
 export default {
     props: ['teacher', 'criterias'],

     data: () => ({
         form: {},
         loading: false,
         error: null,
     }),

     methods: {
         async handleSubmit() {
             if (this.loading) return

             this.loading = true
             this.error = null

             const { id } = this.teacher
             const url = route('rate.create', id)
             const data = { rates: [] }
             const rates = this.form
             const keys = Object.keys(rates)

             if (keys.length < this.criterias.length) {
                 this.error = 'Debes dar tu puntuación en todos los criterios.'
                 this.loading = false
                 return
             }
             keys.forEach(key => {
                 const rate = {
                     score: rates[key],
                     teacher_id: id,
                     criteria_id: Number(key),
                 }
                 data.rates.push(rate)
             })

             try {
                 await this.$http.post(url, data)
                 location.href = route('dashboard.index')
             } catch (error) {
                 console.error(error.response || error)
             } finally {
                 this.loading = false
             }
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .image {
     @include size(150px);
     border-radius: 10px;
     margin: 0 auto;
 }
</style>

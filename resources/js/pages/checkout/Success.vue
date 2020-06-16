<template>
    <div class="container">
	<div class="wrapper padding-top--three text--center">
            <TimeLine now="checkout" />

            <div class="check">
		<i class="icon icon-ok"></i>
            </div>

            <h1 class="margin-bottom--zero">
		Tu pago se ha ejecutado correctamente!
            </h1>
            <p>Ahora solo queda esperar a que sea el dia y la hora de tu clase</p>

            <Button
		class="margin-top--two"
		color="green"
		:href="route('asigment.index', asigment.id)"
            >Continuar</Button
		      >
	</div>
    </div>
</template>

<script>
 export default {
     props: ['asigment'],
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .check {
     @include size(115px);
     @include child-centered;

     margin: 0 auto;
     margin-bottom: 1rem;
     border-radius: 50%;
     color: color('green') !important;
     font-size: 3.5rem;
     border: 2px solid color('green');
 }
</style>

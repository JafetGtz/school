<template>
    <div class="container">
	<div class="wrapper">
            <TimeLine now="checkout" />

            <span v-if="error" class="error" role="alert">{{ error }}</span>

            <header>
		<h1 class="margin-bottom--one">Abonar pago por el servicio</h1>
            </header>

            <table>
		<tbody>
                    <tr>
			<td>Servicio de tutoría academica</td>
			<td>{{ APP_CURRENCY_SYMBOL }} {{ asigment.budget-3 }}</td>
                    </tr>
                    <tr>
			<td>Uso de la plataforma</td>
			<td>{{ APP_CURRENCY_SYMBOL }} {{ APP_SERVICE_TAX }}</td>
                    </tr>
		</tbody>

		<tfoot>
                    <tr>
			<td>TOTAL:</td>
			<td>{{ APP_CURRENCY_SYMBOL }} {{ total-3}}</td>
                    </tr>
		</tfoot>
            </table>

            <form
		method="post"
		:action="route('payment.create', asigment.id)"
		@submit="loading = true"
            >
		<input type="hidden" name="_token" :value="CSRF_TOKEN" />

		<button class="paypal-button" type="submit" :disabled="loading">
                    <i class="icon icon-paypal"></i>
                    <span>PayPal</span>
		</button>
            </form>
	</div>
    </div>
</template>

<script>
 export default {
     props: ['asigment', 'error'],

     data: () => ({ loading: false }),

     computed: {
         total() {
             const subtotal = this.asigment.budget
             const total = parseFloat(subtotal) + parseFloat(APP_SERVICE_TAX)
             return total.toFixed(2)
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .wrapper {
     text-align: center;
 }

 table {
     margin: 1.5rem auto 2rem;

     td {
         text-align: left;
         padding: 0.5rem 1rem;
     }

     tbody td {
         border-bottom: 1px solid color('gray');
     }

     tbody td:last-child,
     tfoot td {
         text-align: right;
     }

     tfoot td {
         font-size: 1.5rem;
         font-weight: get('bold', $font-weights);
     }
 }

 .paypal-button {
     background: #005ea6; // Paypal's blue
    color: color('white');
     padding: 1rem 3.5rem 1rem 3rem;
     border-radius: 5px;
     font-size: 1.1rem;

     .icon {
         font-size: 1.5rem;
         vertical-align: top;
         margin-right: 8px;
     }
 }
</style>

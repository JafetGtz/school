<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
	<!-- Facebook Pixel Code -->
	<script>
	 !function(f,b,e,v,n,t,s)
	 {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					     n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	     if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	     n.queue=[];t=b.createElement(e);t.async=!0;
	     t.src=v;s=b.getElementsByTagName(e)[0];
	     s.parentNode.insertBefore(t,s)}(window, document,'script',
					     'https://connect.facebook.net/en_US/fbevents.js');
	 fbq('init', '3267096236668974');
	 fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
		       src="https://www.facebook.com/tr?id=3267096236668974&ev=PageView&noscript=1"
		  /></noscript>
	<!-- End Facebook Pixel Code -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title ?? 'Inicio' }} | {{ config('app.name') }}</title>
	<link rel="icon" href="/storage/images/icono.gif">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="{{ mix('css/app.css') }}" rel="stylesheet">
	<script src="{{ mix('js/app.js') }}" defer></script>

	@routes
    </head>
    <body>
	<div id="app"
             data-page-name="{{ $name }}"
             data-layout="{{ $layout }}"
             data-route-data="{{ json_encode($data) }}"
             data-csrf-token="{{ csrf_token() }}"
             data-constants={{ json_encode([
			       'APP_NAME' => config('app.name'),
			       'APP_CURRENCY_CODE' => config('app.currency_code'),
			       'APP_CURRENCY_SYMBOL' => config('app.currency_symbol'),
			       'APP_SERVICE_TAX' => config('app.service_tax'),
			       ]) }}
	     data-auth="{{ json_encode(['user' => Auth::user() ?? null]) }}"
	></div>
    </body>
</html>

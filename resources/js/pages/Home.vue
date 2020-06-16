<template>
    <div>
	<div class="navBar">
	    <div class="container">
		<div class="row">
		    <div class="col-md-6">
			<p class="titulo">APRENDE CON NUESTROS TUTORES</p>
		    </div>
		    <div class="col-md-6 imgBanner">
			<figure class="segment__image">
			    <img src="/storage/images/teach.jpg" alt="" />
			</figure>
		    </div>
		</div>
	    </div>
	</div>
	<!-------------------------servicios--------------------------------------------->
	<div class="servicesV" id="services">
	    <div class="container">
		<h1 class="tituloServ">NUESTROS SERVICIOS</h1>
		<br>
		<div class="row">
		    <div class="col-md-6 card">
			<img src="/storage/images/student.png" alt="" />
			<h3>¿Eres estudiante?</h3>
			<p>
			    Sube tus ejercicios de matemáticas, física o química y te contactaremos
			    con tutores especializados para desarrollarlos.
			</p>
			<div class="margin-top--two">
			    <Button
				class="segment__button"
				:href="route('register', { type: 'student' })"
				outline>Registrate aquí</Button>
			    <br>
			    <br>
			    
			</div>
			<a class="link"
			   style="color:black;"
			   :href="route('login')">Iniciar sesión</a>

		    </div>
		    <div class="col-md-6 card">
			<img src="/storage/images/teaching.png" alt="" />
			<h4>¿Quieres enseñar?</h4>
			<p>
			    Sé nuestro mejor tutor en matemáticas, física y química, se evaluará
			    tu paciencia en clase, el escuchar al alumno. y el uso adecuado de
			    la tecnologia.
			</p>
			<div class="margin-top--two">
			    <Button
				class="segment__button"
				:href="route('register', { type: 'teacher' })"
				outline>Registrate aquí</Button>
			    <br>
			    <br>
			    <a class="link"
			       style="color:black;"
			       :href="route('login')">Iniciar sesión</a>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<!-------------------------Quienes somos--------------------------------------------->
	<div class="container" id="about">
	    <h1 class="tituloServ">¿Quienes somos?</h1>
	    <div class="cardT">
		<p>Somos una empresa que participa en la formación académica de los niños y jóvenes
		    con tutores de altos conocimientos de matemáticas, física  y quimica</p>
	    </div>
	</div>
	<!--------------------------- Contacto ------------------------------------------------------->
	<div class="container" id="contact">
	    <h1 class="tituloServ">Contactanos</h1>
	    <p style="text-align:center;"> No dudes en contactarnos si tienes alguna duda o si tienes
                algo que decirnos.</p>
	    <div class="row">
		<div class="col-md-6">
		    <img src="/storage/images/llave.png" class="contacta" alt="" />
		</div>
		<div class="col-md-6">
		    <ul class="contact__info">
			<li class="margin-top--three">
			    <i class="icon icon-phone"></i>
			    <a href="tel:+51-920279242">+51-920279242</a>
			</li>

			<li class="margin-top--two"> 
			    <i class="icon icon-mail"></i>
			    <a href="mailto:admin@mathias20.com">servicio@mathias20.com</a>
			</li>
		    </ul>
		</div>
	    </div>
	</div>
    </div>
    </div>
</template>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
 

 .navBar{
     margin-top:-55px;
     width:100%;
     height:91vh;
     background-image:linear-gradient(rgba(45, 71, 255, 0.6),rgba(45, 71, 255, 0.6)),url('/storage/images/1.png');
     background-repeat: no-repeat;
     background-size: cover;
     background-position: center;
 }
 .titulo{
     color:#fff;
     text-align: center;
     font-size:40px;
     font-weight:600;
     margin-top:195px;
 }
 .brainImg{
     width:95px;
     margin:20px;
     display: block;
     margin-left: auto;
     margin-right: auto;
 }
 .btnUnete{
     margin-left: auto;
     margin-right: auto;
     background-color:#fff;
     width:200px;
     padding:10px;
     display:block;
 }
 .imgBanner{
     margin-top:100px;
 }
 .btnUnete p{
     font-size:30px;
     font-weight:600;
     text-align:center;
     color:black;
 }
 .servicesV{
     margin-top:40px;
 }
 .tituloServ{
     text-align:center;

 }
 .tituloServ::before{
     content:'';
     background:#f9a825;
     height:5px;
     width:200px;
     margin-left:auto;
     margin-right:auto;
     display:block;
     transform:translateY(63px);
 }
 .tituloServ::after{
     content:'';
     background:#f9a825;
     height:10px;
     width:50px;
     margin-left:auto;
     margin-right:auto;
     margin-bottom:40px;
     display:block;
     transform:translateY(8px);
 }
 .segment__button{
     border:#f9a825 solid 2px !important;
     color:#424242 !important;
 }
 .contacta{
     width:200px;
     float: right;
 }

 .card{
     text-align:center;
     margin-bottom:40px;
     -webkit-box-shadow: -9px 10px 82px -22px rgba(51,51,44,0.48);
     -moz-box-shadow: -9px 10px 82px -22px rgba(51,51,44,0.48);
     box-shadow: -9px 10px 82px -22px rgba(51,51,44,0.48);
     padding:20px;
 }

 .cardT{
     margin-bottom:40px;
     -webkit-box-shadow: -6px 21px 89px -29px rgba(107,105,80,1);
     -moz-box-shadow: -6px 21px 89px -29px rgba(107,105,80,1);
     box-shadow: -6px 21px 89px -29px rgba(107,105,80,1);
     padding:20px;
 }

 .segment__image {
     width: 90%;
     max-width: 100%;
     height: auto;
     position: relative;
     margin: 0 auto;
     border-radius: 66% 34% 63% 37% / 60% 29% 71% 40%;
     margin-bottom: 1rem;
     overflow: hidden;

     img {
	 @include size(100%, auto);
	 @include max-size(100%);
     }

     @include breakpoint('sm') {
	 @include size(400px, 300px);
	 border-radius: 25% 75% 37% 63% / 46% 24% 76% 54%;

	 img {
	     @include size(auto, 100%);
	     @include max-size(100%);
	 }
     }
 }

 .contact {
     border-top: 1px solid color('gray', 50);
     padding-top: 2rem;
     margin-top: 2rem;
 }
 .contact__info {
     text-align: left;
     li {
     }
     .icon {
         vertical-align: middle;
         margin-right: 0.25rem;
         color: color('primary');
         font-size: 1.5rem;
     }
 }



 @media (max-width:858px){
     .tituloServ::before{
	 content:'';
	 background:#fff;
	 height:5px;
	 width:100px;
	 margin-left:auto;
	 margin-right:auto;
	 display:hidden;
	 transform:translateY(110px);
     }
     .tituloServ::after{
	 content:'';
	 background:#fff;
	 height:10px;
	 width:50px;
	 margin-left:auto;
	 margin-right:auto;
	 margin-bottom:40px;
	 display:hidden;
	 transform:translateY(8px);
     }
     
 }
</style>

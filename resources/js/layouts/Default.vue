<template>
    <div class="wrapper">

	<nav>
	    <input type="checkbox" id="check"></input>
	    <label for="check" class="checkbtn">
		<i class="icon icon-right"></i>
	    </label>
	    <label>
		<a :href="route('home')">
		    <img class="logo"
			 src="/storage/images/logo.gif"/>
		</a>
	    </label>
	    <ul>
		<template v-if="isLogged">
		    <li>
			<a class="navbar__wellcome">Hola, {{ user.first_name }}</a>
		    </li>
		    <li>
			<figure class="navbar__avatar image" >
			    <img :src="user.avatar"/>
			    <i class="icon icon-user"></i>
			</figure>
		    </li>
		    <li>
			<i class="navbar__logout icon icon-logout" @click="doLogout"
			   title="Salir">
			</i>
		    </li>
		</template>
		<template v-else>
		    <li><a @click="abaoutV">¿Quienes somos?</a></li>
		    <li><a @click="contactV">Contacto</a></li>
		    <li><a :href="route('login')">Estudiante</a></li>
		    <li><a :href="route('login')">Tutor</a></li>
		</template>
	    </ul>

	</nav>
        <!-- Main -->
        <main>
            <div class=""><!-- aca containers -->
                <slot></slot>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer"></footer>
    </div>
</template>

<script>
 export default {
     data: ({ $auth }) => ({
         user: $auth.user,
         isLogged: !!$auth.user,
     }),

     methods: {
         async doLogout() {
             await this.$http.post('logout')
             window.location.href = route('home')
         },
	 async abaoutV(){
	     window.location = "/#about"
	 },
	 async contactV(){
	     window.location = "/#contact"
	 },
         isCurrent: name => route().current() === route(name).name,
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';
 $navbar-heigth: 55px;
 .checkbtn{
     font-size:30px;
     color:#2196f3;
     float:right;
     margin-right:40px;
     cursor:pointer;
     display:none;
 }
 .logo{

     width:180px;
     margin-left:20px;
 }
 #check{
     display:none;
 }
 
 nav{
     position:sticky;
     z-index:10;
     top: 0;
     background-color:white;
     height: $navbar-heigth;
 }


 nav ul{
     float:right;
     margin-right:20px;
 }
 nav ul li{
     display:inline-block;
     line-height:50px;
     margin: 0px 5px 5px 5px;
 }
 nav ul li a{
     color:black;
     font-size:17px;
     padding:20px 13px;
 }
 a.active,li a:hover{
     background:#fff;
     color:black;
     transition:.5s;
 }
 
 .lista{
     text-decoration:none;
     list-style:none;
 }
 
 .wrapper {
     display: flex;
     min-height: 100vh;
     flex-direction: column;
 }

 main {
     padding-top: $navbar-heigth;
     padding-bottom: get('four', $spacers);
     flex-grow: 1;

     & > .container {
         margin-top: get('two', $spacers);
         @include breakpoint('md') {
	     margin-top: get('three', $spacers);
         }
     }
 }

 .navbar {
     @include size(100%, $navbar-heigth);
     @include position(fixed, 0, 0);

     background: color('white');
     border-bottom: 1px solid color('gray', 50);
     z-index: get('navbar', $z-layers);
 }

 .navbar__container {
     height: 100%;
     display: flex;
     justify-content: space-between;
     align-items: center;
 }

 .navbar__logo {
     img {
         height:$navbar-heigth;
         width: auto !important;
     }
 }


 .navbar__wellcome {
     white-space: nowrap;
 }

 .navbar__avatar {
     @include size(35px);
     position: relative;
     box-shadow: 0 0 0 1px color('gray', 600) inset;
     border-radius: 50%;

     margin-bottom:-10px;
     .icon {
         position: absolute;
         top: 0;
         left: -1px;
         font-size: 1.5rem;
         z-index: -1;
     }
 }

 .navbar__button {
     color: color('gray', 900);
     text-transform: uppercase;
     font-weight: get('regular', $font-weights);
     margin-right: 1.85rem;

     
 }

 .navbar__logout {
     font-size: 1.5rem;
     color: color('black', 100);
     cursor: pointer;
 }

 .footer {
     height: 120px;
     background: color('white');
     border-top: 1px solid color('gray', 50);
 }
 @media (max-width:858px){
     .checkbtn{
	 display:block;
     }
     a:hover,a.active{
	 color:blue;
     }
     #check:checked ~ ul{
	 left:0;
     }
     nav{
	 position:sticky;
	 z-index:10;
	 top: 0;
     }
     ul{
	 padding:10px;
	 position:fixed;
	 width:100%;
	 height:100vh;
	 background:#fff;
	 top:50px;
	 left:-100%;
	 text-align:center;
	 transition: all .5s;
	 z-index:10;
     }
     nav ul li a{
	 color:black;
	 font-size:20px;
     }
     nav ul li{
	 display:block;
     }
     
 }

</style>

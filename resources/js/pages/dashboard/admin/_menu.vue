<template>
    <class class="">
	<aside class="menu">
            <div class="menu__container">
		<header class="menu__header">
                    <h2 class="menu__title">{{ APP_NAME }}</h2>
		</header>

		<nav class="menu__nav">
                    <ul>
			<li
                            v-for="({ label, name, href }, index) in items"
                            :key="index"
			>
                            <a
				:class="{
                                    nav__item: true,
                                    'nav__item--is-active': name === activeItem,
				}"
				:href="href"
                            >{{ label }}</a
					>
			</li>
                    </ul>
		</nav>

		<footer class="menu__footer">
                    <button class="menu__logout" @click="doLogout">
			<i class="icon icon-logout"></i>
			<span>Salir</span>
                    </button>
		</footer>
            </div>
	</aside>
    </class>
</template>

<script>
 export default {
     props: {
         items: {
             type: Array,
             required: true,
         },

         activeItem: String,
     },

     methods: {
         async doLogout() {
             await this.$http.post('logout')
             window.location.href = route('home')
         },
     },
 }
</script>

<style lang="scss" scoped>
 @import '~@/sass/_globals.scss';

 .menu {
     width: 245px;
     padding: 2rem 0;
     border-right: 1px solid color('gray', 50);
 }

 .menu__container {
     height: 100%;
     display: flex;
     flex-flow: column;
 }

 .menu__header {
     padding: 0 1.25rem;
 }

 .menu__nav {
     flex-grow: 1;
 }

 .menu__footer {
     padding: 0 1.25rem;
 }

 .menu__logout {
     font-size: 1.15rem;
     color: color('red');

     .icon {
         font-size: 1.25rem;
     }
 }

 .menu__title {
     color: color('primary');
 }

 .nav__item {
     display: block;
     text-transform: uppercase;
     font-weight: get('bold', $font-weights);
     border: 0 solid transparent;
     border-left-width: 4px;
     padding: 1.25rem;
     cursor: pointer;

     &--is-active {
         border-color: color('primary');
         background: color('gray', 50, 0.15);
         color: color('primary');
         cursor: default;
     }
 }
</style>

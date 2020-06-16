<template>
    <div class="container">
        <TimeLine now="class" />

        <div class="wrapper">
            <div id="video-chat"></div>
            <div class="loading" v-if="isLoading">
                <div class="loading__container">
                    <p class="loading__label">Un momento...</p>

                    <div class="sk-chase">
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                        <div class="sk-chase-dot"></div>
                    </div>
                </div>
            </div>

            <div class="placeholder" v-if="!isLoading && !hasStarted">
                <div v-if="distanceInTime > 0" class="countdown">
                    <h3 class="countdown__label">La clase empezará en:</h3>
                    <h1 class="countdown__time">{{ distanceInWords }}</h1>
                </div>
                <div v-else class="call-to-action">
                    <div class="call-to-action__icon">
                        <i class="icon icon-desktop"></i>
                    </div>
                    <h2 class="call-to-action__label">
                        Ya ha llegado la hora de la clase!
                    </h2>
                    <Button
                        class="call-to-action__buttom"
                        rounded
                        @click="start"
                    >Empezar!</Button
			     >
                </div>
            </div>
        </div>
	<div class="recomendaciones">
	    <p>
		Recomendaciones:Instala Jitsi Meet en su equipo.
	    </p>
	</div>
        <div v-if="hasStarted" class="d-flex justify-content-center">
            <Button @click="terminate" outline color="red"
                >Terminar clase</Button
            >
        </div>

        <hr />

        <div v-if="teacher" class="margin-bottom--two">
            <div class="d-flex">
                <figure class="teacher__avatar image">
                    <img :src="teacher.avatar" />
                </figure>
                <div class="margin-left--halve">
                    <p class="teacher__name">{{ teacher.full_name }}</p>
                    <Stars :value="teacher.stars" />
                </div>
            </div>
        </div>

        <div>
            <h4 class="margin-bottom--zero">Detalles:</h4>
            <p>{{ asigment.details }}</p>

            <div class="margin-top--one">
                <File
                    v-for="(file, index) in asigment.files"
                    :key="index"
                    :file="file"
                    readonly
                />
            </div>
        </div>
    </div>
</template>

<script>
import formatDistance from 'date-fns/formatDistance'
import { es } from 'date-fns/locale'

export default {
    props: ['displayName', 'roomName', 'asigment', 'teacher'],

    data: () => ({
        distanceInWords: null,
        distanceInTime: true,
        isLoading: false,
        hasStarted: false,
    }),

    mounted() {
        const date = new Date(this.asigment.date)

        this.setDistance(date)
        setInterval(() => this.setDistance(date), 1000)
    },

    methods: {
        setDistance(date) {
            const now = Date.now()
            this.distanceInTime = Math.max(date - now, 0)
            this.distanceInWords = formatDistance(date, now, { locale: es })
        },

        async start() {
            this.isLoading = true
            await this.include('https://meet.jit.si/external_api.js')

            try {
                const domain = 'meet.jit.si'

                const options = {
                    roomName: this.roomName,
                    parentNode: this.$el.querySelector('#video-chat'),
                    userInfo: { displayName: this.displayName },
                    height: 400,
                    devices: {
                        audioInput: '<deviceLabel>',
                        audioOutput: '<deviceLabel>',
                        videoInput: '<deviceLabel>',
                    },
                    onload: () => {
                        this.hasStarted = true
                        this.isLoading = false
                    },
                }

                const api = new JitsiMeetExternalAPI(domain, options)

                api.addListener('readyToClose', () => {
                    api.dispose()
                })
            } catch (error) {
                console.error('Failed to setup Jitsi API:', error)
                this.hasStarted = false
                this.isLoading = false
            }
        },

        async terminate() {
            if (this.loading) return

            if (confirm('¿Deseas dar por concluida esta clase?')) {
                this.loading = true

                try {
                    const { id } = this.asigment
                    const url = route('asigment.finish', id)

                    await this.$http.post(url)


                    window.location.href =
                        this.$auth.user.userable_type === 'teacher'
                            ? route('dashboard.index')
                            : route('rate.index', this.teacher.id)
                } catch (error) {
                    console.error(error.response || error)
                } finally {
                    this.loading = false
                }
            }
        },

        include: url =>
            new Promise(resolve => {
                const script = document.createElement('script')
                script.onload = () => resolve()
                script.src = url
                script.async = true
                document.head.appendChild(script)
            }),
    },
}
</script>

<style lang="scss" scoped>
@import '~@/sass/_globals.scss';

.wrapper {
    position: relative;
    min-height: 50vh;
}

hr {
    height: 1px;
    background: color('gray', 50);
    margin: 3.5rem 0;
}

.placeholder,
.loading,
.loading__container {
    @include min-size(100%);
    @include size(100%);
}

.placeholder {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loading__label {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
}

.countdown__label,
.countdown__time {
    font-weight: get('light', $font-weights);
}

.countdown__time {
    font-size: 4rem;
}

.call-to-action__icon {
    font-size: 7rem;
}

.call-to-action__label {
    font-weight: get('light', $font-weights);
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}

// Loading

.loading {
    position: absolute;
    top: 0;
    left: 0;
    background: color('white', 500, 0.75);
    text-align: center;
}

.loading__container {
    @include child-centered;
    flex-flow: column;
}

.sk-chase {
    @include size(75px);
    margin: 0 auto;
    position: relative;
    animation: sk-chase 2.5s infinite linear both;
}

.sk-chase-dot {
    @include size(100%);
    position: absolute;
    left: 0;
    top: 0;
    animation: sk-chase-dot 2s infinite ease-in-out both;
}

.sk-chase-dot:before {
    content: '';
    display: block;
    @include size(30%);
    background-color: color('primary');
    border-radius: 100%;
    animation: sk-chase-dot-before 2s infinite ease-in-out both;
}

.sk-chase-dot:nth-child(1) {
    animation-delay: -1.1s;
}
.sk-chase-dot:nth-child(2) {
    animation-delay: -1s;
}
.sk-chase-dot:nth-child(3) {
    animation-delay: -0.9s;
}
.sk-chase-dot:nth-child(4) {
    animation-delay: -0.8s;
}
.sk-chase-dot:nth-child(5) {
    animation-delay: -0.7s;
}
.sk-chase-dot:nth-child(6) {
    animation-delay: -0.6s;
}
.sk-chase-dot:nth-child(1):before {
    animation-delay: -1.1s;
}
.sk-chase-dot:nth-child(2):before {
    animation-delay: -1s;
}
.sk-chase-dot:nth-child(3):before {
    animation-delay: -0.9s;
}
.sk-chase-dot:nth-child(4):before {
    animation-delay: -0.8s;
}
.sk-chase-dot:nth-child(5):before {
    animation-delay: -0.7s;
}
.sk-chase-dot:nth-child(6):before {
    animation-delay: -0.6s;
}

@keyframes sk-chase {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes sk-chase-dot {
    80%,
    100% {
        transform: rotate(360deg);
    }
}

@keyframes sk-chase-dot-before {
    50% {
        transform: scale(0.4);
    }
    100%,
    0% {
        transform: scale(1);
    }
}

.teacher__avatar {
    @include size(55px);
    border-radius: 50%;
}
</style>

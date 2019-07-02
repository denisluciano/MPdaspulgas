import Vue from 'vue'
import Router from 'vue-router'

import Anuncios from '@/components/Anuncios'
import Login from '@/components/Login'
import Historico from '@/components/Historico'
import MeusAnuncios from '@/components/MeusAnuncios'


Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/anuncios',
        name: 'Anúncios',
        component: Anuncios
    },
    {
        path: '/historico',
        name: 'Historico',
        component: Historico
    },
    {
        path: '/MeusAnuncios',
        name: 'MeusAnuncios',
        component: MeusAnuncios
    },

  ]
})

import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/components/Home'
import Produto from '@/components/Produto'
import Cliente from '@/components/Cliente'
import Compra from '@/components/Compra'
import NovoCliente from '@/components/NovoCliente'
import NovoProduto from '@/components/NovoProduto'


Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
      path: '/clientes/novo',
      name: 'NovoCliente',
      component: NovoCliente
    },
    {
        path: '/produtos/novo',
        name: 'NovoProduto',
        component: NovoProduto
    },
    {
        path: '/produtos',
        name: 'Produto',
        component: Produto
    },
    {
        path: '/clientes',
        name: 'Cliente',
        component: Cliente
    },
    {
        path: '/compras',
        name: 'Compra',
        component: Compra
    }
  ]
})

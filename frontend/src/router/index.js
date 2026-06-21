import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    redirect: '/dashboard',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('../views/Dashboard.vue'),
  },
  {
    path: '/enderecos',
    name: 'enderecos',
    component: () => import('../views/enderecos/Index.vue'),
  },
  {
    path: '/enderecos/novo/:id?',
    name: 'enderecos-form',
    component: () => import('../views/enderecos/Form.vue'),
  },
  {
    path: '/pacientes',
    name: 'pacientes',
    component: () => import('../views/pacientes/Index.vue'),
  },
  {
    path: '/pacientes/novo/:id?',
    name: 'pacientes-form',
    component: () => import('../views/pacientes/Form.vue'),
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

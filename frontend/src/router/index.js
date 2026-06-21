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
    path: '/pacientes',
    name: 'pacientes',
    component: () => import('../views/pacientes/Index.vue'),
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

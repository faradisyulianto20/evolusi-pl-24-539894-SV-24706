import { createRouter, createWebHistory } from 'vue-router'
import BookList from '../views/BookList.vue'
import BookDetail from '../views/BookDetail.vue'

const routes = [
  { path: '/', component: BookList },
  { path: '/books/:id', component: BookDetail },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})

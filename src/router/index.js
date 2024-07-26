import { createRouter, createWebHistory } from 'vue-router';
import CarList from '../views/CarList.vue';
import CarForm from '../views/CarForm.vue';

const routes = [
    { path: '/', name: 'CarList', component: CarList },
    { path: '/cars/new', name: 'CarForm', component: CarForm },
    { path: '/cars/:id/edit', name: 'EditCar', component: CarForm, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
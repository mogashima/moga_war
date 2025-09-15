import { createRouter, createWebHistory } from 'vue-router';
import PeopleManagementComponent from './components/PeopleManagementComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import BattleComponent from './components/BattleComponent.vue';
import TacticsComponent from './components/TacticsComponent.vue';

const BASE_URL = import.meta.env.VITE_API_BASE || '/';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeComponent,
  },
  {
    path: '/battle/:location1/:location2',
    name: 'Battle',
    component: BattleComponent,
    props: true
  },
  {
    path: '/tactics',
    name: 'Tactics',
    component: TacticsComponent,
  },
  {
    path: '/people',
    name: 'PeopleManagement',
    component: PeopleManagementComponent,
  },
];

const router = createRouter({
  history: createWebHistory(BASE_URL),
  routes,
});

export default router;
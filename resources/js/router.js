import { createRouter, createWebHistory } from 'vue-router';
import PeopleManagementComponent from './components/PeopleManagementComponent.vue';
import HomeComponent from './components/HomeComponent.vue';
import BattleComponent from './components/BattleComponent.vue';
import TacticsComponent from './components/TacticsComponent.vue';

const routes = [
  {
    path: '/mogawar/public/',
    name: 'Home',
    component: HomeComponent,
  },
  {
    path: '/mogawar/public/battle/:location1/:location2',
    name: 'Battle',
    component: BattleComponent,
    props: true
  },
  {
    path: '/mogawar/public/tactics',
    name: 'Tactics',
    component: TacticsComponent,
  },
  {
    path: '/mogawar/public/people',
    name: 'PeopleManagement',
    component: PeopleManagementComponent,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
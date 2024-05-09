import { createRouter, createWebHistory  } from 'vue-router'; 
import HomePage from '../pages/HomePage.vue';
import CategoryPage from '../pages/CategoryPage.vue';
import DetailPage from '../pages/DetailPage.vue';
import PaymentPage from '../pages/PaymentPage.vue';

// nested routes
import BillinginfoView from '@/components/payment/BillinginfoView.vue';
import RentalinfoView from '@/components/payment/RentalinfoView.vue';
import PaymentMethodView from '@/components/payment/PaymentMethodView.vue';
import ConfirmationView from '@/components/payment/ConfirmationView.vue';

const routes = [
    {
        path: '/',
        name: HomePage,
        component: HomePage,
    },
    {
        path: '/category',
        name: CategoryPage,
        component: CategoryPage,
    },
    {
        path: '/detail/:id',
        name: DetailPage,
        component: DetailPage,
    },
    {
        path: '/payment/:id',
        name: PaymentPage,
        component: PaymentPage,
        children:[
            { 
                path: '',
                component: BillinginfoView,
                alias:['step/1']
            },
            { 
                path: 'step/2',
                component: RentalinfoView
            },
            { 
                path: 'step/3',
                component: PaymentMethodView
            },
            { 
                path: 'step/4',
                component: ConfirmationView
            }
        ]
    },
];

const router = createRouter({
    history: createWebHistory (),
    routes
  });
export default router
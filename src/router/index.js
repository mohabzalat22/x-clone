import { createRouter, createWebHistory  } from 'vue-router'; 
import HomePage from '../pages/HomePage.vue';
import CategoryPage from '../pages/CategoryPage.vue';
import DetailPage from '../pages/DetailPage.vue';
import PaymentPage from '../pages/PaymentPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import RegisterPage from '../pages/RegisterPage.vue';



// nested routes
import BillinginfoView from '@/components/payment/BillinginfoView.vue';
import RentalinfoView from '@/components/payment/RentalinfoView.vue';
import PaymentMethodView from '@/components/payment/PaymentMethodView.vue';
import ConfirmationView from '@/components/payment/ConfirmationView.vue';
import NavbarView from '@/components/NavbarView.vue';
import FooterView from '@/components/FooterView.vue';

const routes = [
    {
        path: '/login',
        name: LoginPage,
        component: LoginPage,
    },
    {
        path: '/register',
        name: RegisterPage,
        component: RegisterPage,
    },
    {
        path: '/',
        name: HomePage,
        components: 
        {
            default: HomePage,
            NavbarView,
            FooterView
        },
    },
    {
        path: '/category',
        name: CategoryPage,
        components: {
            default: CategoryPage,
            NavbarView,
            FooterView
        },
    },
    {
        path: '/detail/:id',
        name: DetailPage,
        components: {
            default: DetailPage,
            NavbarView,
            FooterView
        },
    },
    {
        path: '/payment/:id',
        name: PaymentPage,
        components: {
            default: PaymentPage,
            NavbarView,
            FooterView
        },
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
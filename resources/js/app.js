import { createApp } from 'vue';
import LoginForm from './components/LoginForm.vue';
import './bootstrap';
import '../css/app.css';

const app = createApp({
    // se quiser, pode adicionar opções aqui no futuro
});

app.component('login-form', LoginForm);
app.mount('#app');

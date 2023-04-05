import './bootstrap';

import Alpine from 'alpinejs';

declare global {
    interface Window {
        Alpine: typeof Alpine;
    }
}

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import router from '@/router/index.ts'
import ContactsIndex from '@/components/contacts/ContactsIndex.vue'
import Notifications from '@kyvg/vue3-notification'

createApp({
    components: {
        ContactsIndex,
    },
})
    .use(router)
    .use(Notifications)
    .mount('#app');

import '../css/app.css';

import Alpine from 'alpinejs';
import store from './store';

window.Alpine = Alpine;

Alpine.store('app', store);

Alpine.start();
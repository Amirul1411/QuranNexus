import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

// Register the focus plugin
Alpine.plugin(focus);

window.Alpine = Alpine

Alpine.start()

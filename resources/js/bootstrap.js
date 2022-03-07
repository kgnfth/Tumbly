window.$ = window.jQuery = require('jquery');


import Alpine from 'alpinejs';
import Plyr from 'plyr';


window.Alpine = Alpine;
window.Plyr = Plyr;

Alpine.start();

Plyr.setup("#player");


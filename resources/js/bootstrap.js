window.$ = window.jQuery = require('jquery');

require('@fancyapps/fancybox');

window.Plyr = require('plyr/src/js/plyr');

$("[data-fancybox]").fancybox({
	afterShow: function() {
		const player = new Plyr.default('.fancybox-video', {});
	}
});

const player = new Plyr.default('#player');

import Alpine from 'alpinejs';
 
window.Alpine = Alpine
 
Alpine.start()
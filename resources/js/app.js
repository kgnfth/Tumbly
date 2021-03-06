window._ = require('lodash');
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
require('@fancyapps/fancybox');

window.Plyr = require('plyr/src/js/plyr');

$("[data-fancybox]").fancybox({
	afterShow: function() {
		const player = new Plyr.default('.fancybox-video', {});
	}
});

const player = new Plyr.default('#player');

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found.');
}
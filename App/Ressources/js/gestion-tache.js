jQuery(document).ready(function($)
{
	Vue.component('gestion-tache', GestionTache);
	Vue.component('alert', WbuAlert);
	Vue.component('builder-forms', BuilderForms);
	new Vue({
	    props : {},
	    el : '#AppGestionTache',
	    data : {},
	});

});
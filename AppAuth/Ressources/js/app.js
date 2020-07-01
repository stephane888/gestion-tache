jQuery(document).ready(function($)
{
	Vue.component('app-authen-lib', AppAutehNutribe);
	Vue.component('tableaugestion', tabGes);
	Vue.component('tavle-v2', tabGesV2);

	new Vue({
	    delimiters : [ '${', '}' ],
	    props : {
	    // datas_modal_body:[Object, Array,String, Number],
	    },
	    el : '#AppAuthen',
	    data : {},
	});

});
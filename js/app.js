(function(window, Vue, VueRouter){
	
	//escape if no holder on page
	if ( document.getElementById( 'app-gcalc' ) === null ) { return; }

	var store = new Vuex.Store({
	  state: {
	    model: window['gcalc' + '__app_model']
	  },
	  mutations: { }
	});

	var router = new VueRouter({
	  routes : [
		  { path: '/', component: my_component_1___gcalc },
		  { path: '/my-component-2', component: my_component_2___gcalc },
		  { path: '/my-component-3', component: my_component_3___gcalc }
		]
	});

	
	var app = new Vue({
	  store: store,
	  router: router
	}).$mount('#app-gcalc');

})(window, Vue, VueRouter);	
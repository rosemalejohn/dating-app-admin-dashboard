import Vue from 'vue'

export default {

	getConfigs() {
		return Vue.http.get('settings');
	},

	updateConfigs(configs) {
		return Vue.http.put('settings', configs);
	}

}
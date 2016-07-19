import Vue from 'vue'

export default {

	all() {
		return Vue.http.get('websites');
	},

	store(website) {
		return Vue.http.post('websites', website);
	},

	update(website) {
		return Vue.http.put('websites/' + website.id, website);
	},

	delete(website) {
		return Vue.http.delete('websites/' + website.id);
	}

}
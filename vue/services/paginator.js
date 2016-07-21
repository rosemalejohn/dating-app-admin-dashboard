import Vue from 'vue'

export default {

	next(url) {
		return Vue.http.get(url);
	}

}
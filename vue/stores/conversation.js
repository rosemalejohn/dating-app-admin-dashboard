import Vue from 'vue'

export default {

	flag(website_id, conversation_id) {
		return Vue.http.post('chat/' + website_id + '/' + conversation_id + '/flag')
	},

	unflag(website_id, conversation_id) {
		return Vue.http.delete('chat/' + website_id + '/' + conversation_id + '/unflag')
	}

}
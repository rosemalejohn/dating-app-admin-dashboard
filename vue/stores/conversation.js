import Vue from 'vue'

export default {

	flag(form) {
		return Vue.http.post('chat/' + form.website_id + '/flag-conversation', form)
	},

	unflag(website_id, conversation_id) {
		return Vue.http.delete('chat/' + website_id + '/' + conversation_id + '/unflag')
	},

	updateFlag(form) {
		return Vue.http.put('chat/' + form.website_id + '/flag-conversation/' + form.id, form);
	}

}
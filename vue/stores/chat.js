import Vue from 'vue'

export default {

	getConversations() {
		return Vue.http.get('chat');
	},

	getConversation(website, conversation) {
		return Vue.http.get(website + '/' + conversation);
	}

}
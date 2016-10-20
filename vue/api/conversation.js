import Vue from 'vue'

export default {

	removeConversation(website_id, conversation_id) {
		return Vue.http.post(`/api/chat/${website_id}/${conversation_id}/remove`);
	}

}
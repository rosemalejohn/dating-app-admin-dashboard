import Vue from 'vue'

export default {

	add(website, conversation, data) {
		return Vue.http.post('chat/' + website.id + '/' + conversation.id + '/notes', data);
	},

	update(note) {
		return Vue.http.put('notes/' + note.id, note);
	},

	remove(note) {
		return Vue.http.delete('notes/' + note.id);
	}

}
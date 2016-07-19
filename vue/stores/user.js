import Vue from 'vue'

export default {

	all() {
		return Vue.http.get('users');
	},

	store(user) {
		return Vue.http.post('users', user);
	},

	update(user) {
		return Vue.http.put('users/' + user.id, user);
	},

	delete(users) {
		return Vue.http.delete('users', users);
	}

}
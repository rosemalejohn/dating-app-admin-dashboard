import Vue from 'vue'

export default {

	delete(data) {
		return Vue.http.delete('websites/' + data.website.id + '/unmanage-users', {users: data.users});
	}

}
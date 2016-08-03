<script>
	// Pages
	import WebsiteListings from './components/WebsiteListings.vue'
	import UserListings from './components/UserListings.vue'
	import ManagedUserListings from './components/ManagedUserListings.vue'
	import UserProfileEdit from './components/UserProfileEdit.vue'
	import SystemSettings from './components/SystemSettings.vue'
	import ManageWebsite from './components/ManageWebsite.vue'
	
	// Chat
	import ChatLobby from './components/chat/Lobby.vue'
	import Conversation from './components/chat/Conversation.vue'

	// Modals
	import WebsiteFormModal from './components/Modal.vue'
	import UserFormModal from './components/Modal.vue'
	// Forms
	import WebsiteForm from './forms/website.vue'
	import UserForm from './forms/users.vue'

	import Vue from 'vue'
	import moment from 'moment'

	// Dashboard 
	import MessageGraph from './components/dashboard/MessageGraph.vue'
	import Account from './components/user/Account.vue'

	export default {
		
		components: {
			WebsiteListings, 
			UserListings,
			ManagedUserListings,
			UserProfileEdit,
			SystemSettings,
			ManageWebsite,
			Conversation,

			ChatLobby,

			WebsiteFormModal,
			UserFormModal,

			WebsiteForm,
			UserForm,

			MessageGraph,
			Account
		},

		ready() {
			let self = this;

			socket.on('take-chat:App\\Events\\UserTakeChatEvent', function(data) {
				self.$broadcast('conversation:remove', data.conversation);
			});

			socket.on('conversation:App\\Events\\ConversationFlaggedEvent', function(data) {
				self.$broadcast('conversation:flag', data.conversation);
			});

			socket.on('user:App\\Events\\UserCreated', function(data) {
				console.log(data);
				self.$broadcast('user:created', data.user);
			});

			// socket.on('user:App\\Events\\UserDeleted', function(data) {
			// 	self.$broadcast('user:deleted', data.user);
			// });
		},

		methods: {
			saveUser() {
				this.$broadcast('form:submit', 'user');
			},

			saveWebsite() {
				this.$broadcast('form:submit', 'website');
			}
		},

		events: {
			'user:created'(user) {
				this.$broadcast('user:created', user);
			},

			'website:created'(website) {
				this.$broadcast('website:created', website);
			}
		},
	}

	Vue.filter('date', function(value, type = null, format = null) {

	    if (type == 'relative') {
	        return moment(value).fromNow();
	    } else if (type == 'unix') {
	    	return moment.unix(value).fromNow();
	    }

	    return moment(value).format(format || "MM/DD/YYYY");

	});

</script>
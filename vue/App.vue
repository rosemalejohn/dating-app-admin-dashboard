<script>
	// Pages
	import WebsiteListings from './components/WebsiteListings.vue'
	import UserListings from './components/UserListings.vue'
	import ExternalUserListings from './components/ExternalUserListings.vue'
	import UserProfileEdit from './components/UserProfileEdit.vue'
	import SystemSettings from './components/SystemSettings.vue'
	import ManageWebsite from './components/ManageWebsite.vue'
	// Modals
	import WebsiteFormModal from './components/Modal.vue'
	import UserFormModal from './components/Modal.vue'
	// Forms
	import WebsiteForm from './forms/website.vue'
	import UserForm from './forms/users.vue'

	export default {
		
		components: {
			WebsiteListings, 
			UserListings,
			ExternalUserListings,
			UserProfileEdit,
			SystemSettings,
			ManageWebsite,

			WebsiteFormModal,
			UserFormModal,

			WebsiteForm,
			UserForm
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
		}
	}
</script>
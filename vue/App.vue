<script>
	// Pages
	import WebsiteListings from './components/WebsiteListings.vue'
	import UserListings from './components/UserListings.vue'
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

			WebsiteFormModal,
			UserFormModal,

			WebsiteForm,
			UserForm
		},

		methods: {
			saveUser() {
				this.$broadcast('form:submit', 'user');
			}
		},

		events: {
			'user:created'(user) {
				this.$broadcast('user:created', user);
			} 
		}
	}
</script>
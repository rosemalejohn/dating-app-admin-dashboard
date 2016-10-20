<template>
	<new-managed-account-modal title="Add new user to manage" target="newManagedAccount">
		<managed-user-form slot="content" :website="website"></managed-user-form>
		<div slot="modal-footer"></div>
	</new-managed-account-modal>

	<bulk-add-user-modal title="Bulk add users" target="bulkAddAccount">
		<bulk-add-user-form slot="content" :website="website"></bulk-add-user-form>
		<div slot="modal-footer"></div>
	</bulk-add-user-modal>

	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption caption-md font-red-sunglo">
				<i class="icon-bar-chart theme-font hide"></i>
				<span class="caption-subject theme-font bold uppercase">Moderated profiles</span>
			</div>
			<div class="actions">
				<div class="inputs">
					<div class="portlet-input input-inline input-small">
						<div class="input-icon right">
							<i class="icon-magnifier"></i>
							<input v-model="search" type="text" class="form-control input-circle" placeholder="search...">
						</div>
					</div>
					<div class="btn-group btn-group-devided">
						<button data-toggle="modal" data-target="#newManagedAccount" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Add moderated profile</button>
						<button data-toggle="modal" data-target="#bulkAddAccount" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Bulk add</button>
						<button v-if="checkedUsers.length" @click="unmanageUsers()" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Unmanage</button>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-scrollable table-scrollable-borderless">
				<table class="table table-hover table-light">
					<thead>
						<tr class="uppercase">
							<th>
								
							</th>
							<th colspan="2">
								 Name
							</th>
							<th>
								 Email
							</th>
							<th>
								 Address
							</th>
							<th>
								Fake message
							</th>
						</tr>
					</thead>
					<tr v-for="user in users | filterBy search">
						<td>
							<input :value="user.id" v-model="checkedUsers" type="checkbox" class="liChild">
						</td>
						<td>
							<img class="user-pic" :src="user.user.avatar.url || '/img/default-photo.png'">
						</td>
						<td>
							{{ user.user.username }}
						</td>
						<td>
							{{ user.user.email }}
						</td>
						<td>
							{{ user.user.address }}
						</td>
						<td>
							<div class="input-group">
								<input v-model="user.fake_message" class="form-control" type="text" placeholder="Add fake message">
								<span class="input-group-btn">
									<button @click="updateManagedUser(user)" class="btn btn-success" type="button"><i class="fa fa-edit fa-fw"></i></button>
								</span>
							</div>
						</td>
					</tr>
				</table>
				<div v-if="!users.length" class="note note-info note-bordered">
					<p>No users listed.</p>
				</div>
			</div>
		</div>
	</div>
</template>

<style lang="sass">
	.editable {
		.table-edit {
			display: none;
			cursor: pointer;
		}
	}

	.editable:hover {
		.table-edit {
			display: inline-block;
		}
	}
</style>

<script>
	import _ from 'underscore'
	import swal from 'sweetalert'
	import WebsiteUser from './../stores/website_user'
	import paginator from './../services/paginator'
	import Spinner from './../spin'

	import NewManagedAccountModal from './Modal.vue'
	import BulkAddUserModal from './Modal.vue'
	import ManagedUserForm from './../forms/managed-user.vue'
	import BulkAddUserForm from './../forms/BulkManagedUser.vue'

	export default {

		components: {
			NewManagedAccountModal, ManagedUserForm, BulkAddUserForm, BulkAddUserModal
		},

		data() {
			return {
				checkedUsers: [],
				paginator: {},

				isFetching: false
			}
		},

		props: {

			website: {
				type: Object,
				default() {
					return {}
				},
				required: false
			},

			users: {
				type: Array,
				default() {
					return []
				},
				required: false
			}

		},

		ready() {
			if (this.users) {

				let self = this;

				self.$http.get('websites/' + self.website.id + '/users').then(response => {
					self.paginator = response.data;
					self.users = self.paginator.data;
				})

				window.onscroll = function(ev) {
					let url = self.paginator.next_page_url

				    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
				    	if (url) {
				    		self.isFetching = true
				    		paginator.next(url).then(response => {
				    			self.paginator = response.data
				    			
				    			self.paginator.data.forEach(data => {
				    				self.users.push(data);
				    			})

				    			self.isFetching = false;
				    		})
						}
				    }
				};
			}
		},

		methods: {

			unmanageUsers() {
				var self = this
				if (this.checkedUsers.length) {
					swal({
						title: "Are you sure?",
						text: "You will not be able to recover this after deletion.",
						type: "warning",
						showCancelButton: true,
						showLoaderOnConfirm: true
					}, () => {
						WebsiteUser.delete({ website: this.website, users: this.checkedUsers }).then(response => {
							self.users = _.reject(self.users, user => {
								return _.contains(self.checkedUsers, user.id);
							})
							this.checkedUsers = [];
							toastr.success(response.data);
						})
					});
				}
			},

			updateManagedUser(user) {
				this.$http.put('websites/' + this.website.id + '/managed-users/' + user.id, user).then(response => {
					toastr.success(response.data);
				}).catch(error => {
					toastr.error('Something went wrong.');
				})
			},

			editIntroMessage(user) {
				console.log(user.id);
			}
		},

		events: {
			'user:created'(user) {
				this.users.push(user);
			}
		},

		watch: {
			isFetching(val) {
				this.$nextTick(() => {
					if (val)
						Spinner.spin()
					else
						Spinner.stop()
				})
				
			}
		}
		
	}
</script>
<template>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject font-green-sharp bold uppercase">Moderated profiles</span>
			</div>
			<div class="actions">
				<a data-toggle="modal" data-target="#newManagedAccount" href="javascript:;" class="btn btn-default btn-circle">
					<i class="fa fa-plus"></i>
					<span class="hidden-480">
					New managed account </span>
				</a>
				<a v-if="checkedUsers.length" @click="unmanageUsers()" class="btn btn-danger btn-circle">
					<i class="fa fa-trash"></i>
					<span class="hidden-480">
					Unmanage </span>
				</a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="col-md-4 input-group pull-right" style="margin-bottom: 10px;">
				<input v-model="search" type="text" class="form-control" placeholder="Type to search...">
				<span class="input-group-addon">
					<i class="fa fa-search"></i>
				</span>
			</div>
			<div class="table-container">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr role="row" class="heading">
							<th width="2%">
								<input type="checkbox" class="group-checkable">
							</th>
							<th width="8%">

							</th>
							<th>
								Name
							</th>
							<th width="15%">
								Email
							</th>
							<th width="25%">
								Address
							</th>
							<th width="30%">Fake message</th>
						</tr>
						
						<tr v-for="user in users | filterBy search" role="row" class="filter">
							<td><input value="{{ user.id }}" v-model="checkedUsers" type="checkbox" class="group-checkable"></td>
							<td>
								<img style="width: 100%;" :src="user.user.avatar.url || '/img/default-photo.png'" />
							</td>
							<td>{{ user.user.username }}</td>
							<td>{{ user.user.email }}</td>
							<td>{{ user.user.profile[0].address }}</td>
							<td>
								<div class="input-group">
									<input v-model="user.fake_message" class="form-control" type="text" placeholder="Add fake message">
									<span class="input-group-btn">
										<button @click="updateManagedUser(user)" class="btn btn-success" type="button"><i class="fa fa-edit fa-fw"></i></button>
									</span>
								</div>
							</td>
						</tr>
					</thead>
				</table>
				<div v-if="!users.length" class="note note-info note-bordered">
					<p>No users listed.</p>
				</div>
			</div>
		</div>
	</div>
	<new-managed-account-modal title="Add new user to manage" target="newManagedAccount">
		<managed-user-form slot="content" :website="website"></managed-user-form>
		<div slot="modal-footer"></div>
	</new-managed-account-modal>
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
	import ManagedUserForm from './../forms/managed-user.vue'

	export default {

		components: {
			NewManagedAccountModal, ManagedUserForm
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
								return _.contains(self.checkedUsers, user.id.toString());
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
<template>
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption caption-md font-red-sunglo">
				<i class="icon-bar-chart theme-font hide"></i>
				<span class="caption-subject theme-font bold uppercase">Accounts</span>
				<span class="caption-helper">user listings</span>
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
						<button data-toggle="modal" data-target="#userFormModal" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Add user</button>
						<button v-if="checkedUsers.length" @click="deleteUsers()" class="btn btn-transparent grey-salsa btn-circle btn-sm active">Delete users</button>
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
							<th colspan="3">
								 Earnings
							</th>
							<th>
								
							</th>
						</tr>
					</thead>
					<tr v-for="user in users | filterBy search">
						<td>
							<input v-if="!user.is_mine && !user.is_super" value="{{ user.id }}" v-model="checkedUsers" type="checkbox" class="liChild">
						</td>
						<td>
							<img class="user-pic" :src="user.photo || '/img/default-photo.png'">
						</td>
						<td>
							{{ user.name }}
						</td>
						<td>
							{{ user.email }}
						</td>
						<td>
							{{ user.earnings }} {{ currency }}
						</td>
						<td>
							<paypal-button v-if="user.earnings > 0" :account="user"></paypal-button>
						</td>
						<td>
							<button v-if="user.earnings > 0" @click="clearEarnings(user)" class="btn btn-xs btn-danger">Clear earnings</button>
						</td>
						<td>
							<a href="{{ 'users/' + user.id + '/edit' }}" class="btn btn-xs green filter-cancel"><i class="fa fa-edit"></i></a>
						</td>
					</tr>
				</table>
				<div v-if="!users.length" class="alert alert-block alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert"></button>
					<h4 class="alert-heading"><strong>Important!</strong></h4>
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
	import User from './../stores/user'
	import PaypalButton from './PaypalButton.vue'
	import Settings from './../stores/settings'

	export default {

		components: {
			PaypalButton
		},

		data() {
			return {
				checkedUsers: [],
				paypalData: {},
				currency: 'USD'
			}
		},

		props: {

			users: {
				type: Array,
				default() {
					return []
				},
				required: false
			}

		},

		ready() {
			Settings.getConfigs().then(response => {
				this.currency = response.data.currency.value;
			})
		},

		methods: {

			deleteUsers() {
				var self = this
				if (this.checkedUsers.length) {
					swal({
						title: "Are you sure?",
						text: "You will not be able to recover this after deletion.",
						type: "warning",
						showCancelButton: true,
						showLoaderOnConfirm: true
					}, () => {
						User.delete({ users: this.checkedUsers }).then(response => {
							self.users = _.reject(self.users, user => {
								return _.contains(self.checkedUsers, user.id.toString());
							})
							this.checkedUsers = [];
							toastr.success(response.data);
						})
					});
				}
			},

			clearEarnings(user) {
				swal({
					title: "Are you sure?",
					text: "You are about to clear the earnings of " + user.name,
					type: "warning",
					showCancelButton: true,
					showLoaderOnConfirm: true
				}, () => {
					this.$http.post('users/' + user.id + '/clear-earnings').then(response => {
						user.earnings = 0;
						toastr.success(response.data);
					})
				});
			}
		},

		events: {
			'user:created'(user) {
				this.users.push(user);
			},
		}
		
	}
</script>
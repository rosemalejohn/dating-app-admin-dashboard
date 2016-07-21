<template>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject font-green-sharp bold uppercase">User Listing</span>
			</div>
			<div class="actions">
				<a data-toggle="modal" data-target="#userFormModal" href="javascript:;" class="btn btn-default btn-circle">
					<i class="fa fa-plus"></i>
					<span class="hidden-480">
					New User </span>
				</a>
				<a v-if="checkedUsers.length" @click="deleteUsers()" class="btn btn-danger btn-circle">
					<i class="fa fa-trash"></i>
					<span class="hidden-480">
					Delete </span>
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
							<th width="5%">

							</th>
							<th width="15%">
								Name
							</th>
							<th width="15%">
								Email
							</th>
							<th width="20%">
								Contact info
							</th>
							<th width="10%">
								Type
							</th>
							<th width="10%">
								 Actions
							</th>
						</tr>
						
						<tr v-for="user in users | filterBy search" role="row" class="filter">
							<td><input v-if="!user.is_mine" value="{{ user.id }}" v-model="checkedUsers" type="checkbox" class="group-checkable"></td>
							<td>
								<img style="width: 100%;" :src="user.profile.photo || '/img/default-photo.png'" />
							</td>
							<td>{{ user.name }}</td>
							<td>{{ user.email }}</td>
							<td class="editable">{{ user.contact_info }}</td>
							<td style="text-align: center;">
								<span class="label label-sm label-{{ user.is_admin ? 'danger' : 'success' }}">{{ user.type }}</span>
							</td>
							<td>
								<a href="{{ 'users/' + user.id + '/edit' }}" class="btn btn-xs green filter-cancel"><i class="fa fa-edit"></i></a>
							</td>
						</tr>
					</thead>
				</table>
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

	export default {

		data() {
			return {
				checkedUsers: []
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

			editIntroMessage(user) {
				console.log(user.id);
			}
		},

		events: {
			'user:created'(user) {
				this.users.push(user);
			}
		}
		
	}
</script>
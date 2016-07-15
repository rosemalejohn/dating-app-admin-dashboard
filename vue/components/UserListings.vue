<template>
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-users font-green-sharp"></i>
				<span class="caption-subject font-green-sharp bold uppercase">User Listing</span>
			</div>
			<div class="actions">
				<a data-toggle="modal" data-target="#userFormModal" href="javascript:;" class="btn btn-default btn-circle">
					<i class="fa fa-plus"></i>
					<span class="hidden-480">
					New User </span>
				</a>
				<a @click="deleteUsers()" href="javascript:;" class="btn btn-danger btn-circle">
					<i class="fa fa-trash"></i>
					<span class="hidden-480">
					Delete </span>
				</a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-container">
				<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
					<thead>
						<tr role="row" class="heading">
							<th width="2%">
								<input type="checkbox" class="group-checkable">
							</th>
							<th width="5%">

							</th>
							<th width="10%">
								Name
							</th>
							<th width="10%">
								Email
							</th>
							<th width="10%">
								Username
							</th>
							<th width="20%">
								Intro message
							</th>
							<th width="10%">
								Type
							</th>
							<th width="10%">
								 Actions
							</th>
						</tr>
						
						<tr v-for="user in users" role="row" class="filter">
							<td><input v-if="!user.is_mine" value="{{ user.id }}" v-model="checkedUsers" type="checkbox" class="group-checkable"></td>
							<td>
								<img style="width: 100%;" src="/img/default-photo.png" />
							</td>
							<td>{{ user.name }}</td>
							<td>{{ user.email }}</td>
							<td>{{ user.username }}</td>
							<td></td>
							<td>
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
	{{ $data | json }}
</template>

<script>
	import _ from 'lodash'

	export default {

		ready() {
			this.getUsers();
		},

		data() {
			return {
				users: [],
				checkedUsers: []
			}
		},

		methods: {
			getUsers() {
				this.$http.get('users').then(response => {
					this.users = response.data;
				});
			},

			deleteUsers() {
				var self = this
				if (this.checkedUsers.length) {
					this.$http.delete('users', { users: this.checkedUsers }).then(response => {
						// _.remove(self.users, user => {

						// })
						toastr.success(response.data);
					});
				}
			}
		},

		events: {
			'user:created'(user) {
				this.users.push(user);
			}
		}
		
	}
</script>
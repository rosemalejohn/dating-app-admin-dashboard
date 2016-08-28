<template>
	<form @submit.prevent="searchUser()">
		<div class="form-group">
			<div class="input-group">
				<input v-model="search" class="form-control" type="text" placeholder="Search user...">
				<span class="input-group-btn">
					<button class="btn btn-success" type="submit"><i class="fa fa-search fa-fw"></i></button>
				</span>
			</div>
		</div>
	</form>
	<div v-show="users.length" class="scroller" style="max-height: 350px; height: 100%; margin-top: 10px 0;" data-always-visible="1" data-rail-visible1="1">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr role="row" class="heading">
					<th width="10%"></th>
					<th>
						Name
					</th>
					<th width="15%">
						Email
					</th>
					<th width="30%">
						Address
					</th>
					<th>
					 	Actions
					</th>
				</tr>
				
				<tr v-for="user in users" role="row" class="filter">
					<td>
						<img style="width: 100%;" :src="user.avatar.url || '/img/default-photo.png'" />
					</td>
					<td>{{ user.username }}</td>
					<td>{{ user.email }}</td>
					<td>{{ user.address }}</td>
					<td>
						<a @click="manageUser(user)" href="javascript:;" class="btn btn-xs green filter-cancel">Manage</a>
					</td>
				</tr>
			</thead>
		</table>
		<button v-show="!isFetching && hasMore" @click="showMore()" class="btn btn-default btn-sm">Load more</button>
	</div>
	<div v-else class="note note-info note-bordered">
		<p>No users listed.</p>
	</div>

	<form @submit.prevent="submit()" v-if="showFakeMessageField">
		<hr />
		<div class="form-group">
			<input type="text" v-model="user.username" class="form-control" readonly="" />
		</div>
		<div class="form-group">
			<textarea class="form-control" v-model="fake_message" placeholder="Write a fake message..."></textarea>
			<small>This is the fake message that will be sent out by default for this user.</small>
		</div>
		<input type="submit" value="Submit" class="btn btn-primary" />
		<button @click="showFakeMessageField = false" type="button" class="btn btn-default">Close</button>
	</form>
</template>

<script>
	import Spinner from './../spin'
	import paginator from './../services/paginator'

	export default {

		data() {
			return {
				users: [],
				search: '',
				showFakeMessageField: false,
				user: {},
				fake_message: '',
				paginator: {},
				isFetching: false,
				hasMore: true
			}
		},

		props: {
			website: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		ready() {
			
		},

		methods: {

			searchUser() {
				Spinner.spin();
				this.$http.get('websites/' + this.website.id + '/users/' + this.search).then(response => {
					console.log(response.data);
					this.paginator = response.data;
					this.users = this.paginator.data;
					Spinner.stop();
				}).catch(response => {
					toastr.error('Error searching...');
				})
			},

			manageUser(user) {
				this.user = user;
				this.showFakeMessageField = true
			},

			submit() {
				this.$http.post('websites/' + this.website.id + '/managed-users', {
					userId: this.user.id,
					fake_message: this.fake_message
				}).then(response => {
					toastr.success('User managed.');
					this.showFakeMessageField = false
					window.location.reload();
				}).catch(response => {
					toastr.error('User cannot be managed.');
				})
			},

			showMore() {
				let self = this

				let url = this.paginator.next_page_url;

				if (url) {
					this.isFetching = true
					paginator.next(url).then(response => {
						self.paginator = response.data;
						self.paginator.data.forEach(data => {
							self.users.push(data)
						})
						this.isFetching = false
					})
				} else {
					this.hasMore = false;
					toastr.info('All users are loaded.');
				}
			}

		},

		events: {
			'managed-user:created'() {
				this.$dispatch('managed-user:created');
			}
		},

		watch: {
			isFetching(val) {
				this.$nextTick(() => {
					if (val)
						Spinner.spin();
					else
						Spinner.stop();
				})
			}
		}

	}
</script>
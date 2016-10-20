<template>
	<form @submit.prevent="bulkAdd()" class="form-inline" role="form" style="padding-bottom: 20px;">
		<div class="form-group">
			<label class="sr-only" for="">Gender</label>
			<select class="layout-style-option form-control input-small">
				<option value="1" selected="selected">Male</option>
				<option value="0">Female</option>
			</select>
		</div>
		<div class="form-group">
			<label class="sr-only" for="">Date from (Join date)</label>
			<input type="date" v-model="date_from" class="form-control">
		</div>
		<div class="form-group">
			<label class="sr-only" for="">Date to (Join date)</label>
			<input type="date" v-model="date_to" class="form-control">
		</div>
		<hr />
		<button type="submit" class="btn btn-default">Bulk add</button>
	</form>
</template>

<script>
	import Spinner from './../spin'
	import paginator from './../services/paginator'

	export default {

		data() {
			return {
				users: [],
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

		data() {
			return {
				gender: '',
				date_from: '',
				date_to: ''
			}
		},

		methods: {

			bulkAdd() {
				Spinner.spin();
				this.$http.get('websites/' + this.website.id + '/users/bulk-add', {
					date_from: this.date_from,
					date_to: this.date_to,
					gender: this.gender
				}).then(response => {
					Spinner.stop();
					toastr.success('Users added!');
					window.location.reload();
				}).catch(response => {
					Spinner.stop();
					toastr.error('Error adding some profiles...');
				})
			},

			submit() {
				
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
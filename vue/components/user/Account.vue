<template>
	<div class="portlet box green ">
		<div class="portlet-title">
			<div class="caption">
				Account settings
			</div>
		</div>
		<div class="portlet-body form">
			<form @submit.prevent="submit()" class="form-horizontal" role="form">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Email</label>
						<div class="col-md-6">
							<input type="text" v-model="form.email" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Old password</label>
						<div class="col-md-6">
							<input type="password" v-model="form.old_password" class="form-control">
						</div>
					 	<small v-if="errors.old_password" class="text-danger">{{ errors.old_password[0] }}</small>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">New password</label>
						<div class="col-md-6">
							<input type="password" v-model="form.password" class="form-control">
						</div>
						<small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Confirm password</label>
						<div class="col-md-6">
							<input type="password" v-model="form.password_confirmation" class="form-control">
						</div>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn green">Submit</button>
							<button onclick="window.history.back();" type="button" class="btn default">Cancel</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			user: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		data() {
			return {
				form: {
					email: '',
				},

				errors: []
			}
		},

		ready() {

			this.form.email = this.user.email;

		},

		methods: {
			submit() {
				this.$http.put('users/' + this.user.id + '/account', this.form)
					.then(response => {
						toastr.success(response.data);
					}).catch(error => {
						this.errors = error.data;
					});
			}
		}
	}
</script>
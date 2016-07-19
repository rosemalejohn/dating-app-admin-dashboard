<template>
	<div class="portlet box green ">
		<div class="portlet-title">
			<div class="caption">
				Update details
			</div>
		</div>
		<div class="portlet-body form">
			<form @submit.prevent="submit()" class="form-horizontal" role="form">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-6">
							<input v-model="user.name" type="text" class="form-control" placeholder="Enter text">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email</label>
						<div class="col-md-6">
							<input v-model="user.email" type="text" class="form-control" placeholder="Enter text">
						</div>
					</div>
					<div class="form-group">
		                <label class="col-md-3 control-label">Account type</label>
		                <div class="col-md-6">
			                <select v-model="user.type" class="form-control">
			                    <option value="user" selected="">User</option>
			                    <option value="admin">Admin</option> 
			                </select>
		                </div>
		            </div>
					<hr />
					<div class="form-group">
						<label class="col-md-3 control-label">Photo</label>
						<div class="col-md-3">
							<photo-upload :photo.sync="user.photo"></photo-upload>
							<p class="help-block">
								photos allowed (.jpeg, .jpg, .png)
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Contact information</label>
						<div class="col-md-6">
							<textarea v-model="user.contact_info" class="form-control" rows="3"></textarea>
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

<style lang="sass">
	.image-picker {
		cursor: pointer;
		width: 50%;
	}
</style>

<script>
	import Website from './../stores/website'
	import User from './../stores/user'
	import PhotoUpload from './PhotoUpload.vue'

	import Spinner from './../spin'

	export default {

		components: {

			PhotoUpload

		},

		data() {
			return {
				websites: [],

				saving: false
			}
		},

		ready() {
			Website.all().then(response => {
				this.websites = response.data;
			})
		},

		props: {

			user: {
				type: Object,
				default() {
					return {}
				}
			}

		},

		methods: {

			submit() {
				this.saving = true
				User.update(this.user).then(response => {
					toastr.success('User updated!');
					this.saving = false;
				}).catch(response => {
					toastr.error('User not updated!');
					this.saving = false;
				})
			}

		},

		events: {
			'website:created'(website) {
				this.websites.push(website);
			}
		},

		watch: {
	        saving(val) {
	            this.$nextTick(() => {
	                if (val) {
	                    Spinner.spin()
	                } else {
	                    Spinner.stop()
	                } 
	            })
	        }
	    }

	}
</script>
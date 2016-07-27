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
			                    <option value="user" {{ user.type == 'user' ? 'selected' : '' }}>User</option>
			                    <option value="admin" {{ user.type == 'admin' ? 'selected' : '' }}>Admin</option> 
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

					<div class="form-group">
						<label class="col-md-3 control-label">Pay rate</label>
						<div class="col-md-6">
							<input v-model="user.pay_rate" type="number" class="form-control" placeholder="Enter pay rate">
						</div>
					</div>

					<div v-if="user.type == 'user'" class="form-group">
		                <label class="col-md-3 control-label">Managed websites</label>
		                <div class="col-md-6">
		                    <div v-for="website in websites" class="icheck-list">
		                        <label>
			                        <input :checked="checkWebsites(website)" v-model="checkedWebsites" :value="website.id" type="checkbox" class="icheck" />
			                        {{ website.name }}
		                        </label>
		                    </div>
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
	import _ from 'underscore'

	export default {

		components: {

			PhotoUpload

		},

		data() {
			return {
				websites: [],

				saving: false,

				checkedWebsites: []
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
				if (!this.user == 'admin') {
					this.user.websites = this.checkedWebsites;
				} else {
					this.user.websites = [];
				}
				User.update(this.user).then(response => {
					toastr.success('User updated!');
					this.saving = false;
				}).catch(response => {
					toastr.error('User not updated!');
					this.saving = false;
				})
			},

			checkWebsites(website) {
				var filtered = _.filter(this.user.managed_websites, (val) => {
					return val.id == website.id
				})

				if (filtered.length) {
					return true
				}
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
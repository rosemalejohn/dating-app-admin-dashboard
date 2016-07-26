<template>
	<div class="portlet box green">
		<div class="portlet-body form">
			<form @submit.prevent="saveSettings()" role="form">
				<div class="form-body">
					<div class="form-group">
						<label>Auto login for entire site</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="form.auto_login_entire_site" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Auto login for fake accounts only</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="form.auto_login_fake_accounts" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Trigger intro message to new male members</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="form.trigger_intro_message" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn green-haze">Submit</button>
					<button onclick="window.history.back();" type="button" class="btn default">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
	export default {

		data() {

			return {
				form: {
					auto_login_entire_site: false,
					auto_login_fake_accounts: false,
					trigger_intro_message: false
				}
			}

		},

		methods: {

			saveSettings() {
				toastr.success('Settings saved.')
			}

		},

		watch: {
			'form.auto_login_fake_accounts'(val) {
				if (val) {
					this.form.auto_login_entire_site = !val;
				}
			},

			'form.auto_login_entire_site'(val) {
				if (val) {
					this.form.auto_login_fake_accounts = !val;
				}
			}
		}

	}
</script>
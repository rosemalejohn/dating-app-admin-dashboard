<template>
	<div class="portlet box green">
		<div class="portlet-body form">
			<form @submit.prevent="saveSettings()" role="form">
				<div class="form-body">
					<div v-for="config in configs" class="form-group">
						<label>{{ config.name }}</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="config.value" type="checkbox" class="icheck"> Yes </label>
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

		props: {

			configs: {
				type: Array,
				default() {
					return []
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
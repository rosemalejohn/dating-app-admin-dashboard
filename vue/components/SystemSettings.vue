<template>
	<div class="portlet box green">
		<div class="portlet-body form">
			<form @submit.prevent="saveSettings()" role="form">
				<div class="form-body">
					<div class="form-group">
						<label>{{ configs.auto_login_entire_site.name }}</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="configs.auto_login_entire_site.value" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>

					<div v-if="configs.auto_login_entire_site.value" class="form-group">
						<label>{{ configs.auto_login_accounts_per_cron_jobs.name }}</label>
						<div class="input-group col-md-6">
							<input v-model="configs.auto_login_accounts_per_cron_jobs.value" class="form-control" />
						</div>
					</div>

					<hr />

					<div class="form-group">
						<label>{{ configs.auto_login_fake_accounts.name }}</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="configs.auto_login_fake_accounts.value" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>

					<div v-if="configs.auto_login_fake_accounts.value" class="form-group">
						<label>{{ configs.auto_login_fake_accounts_per_cron_job.name }}</label>
						<div class="input-group col-md-6">
							<input v-model="configs.auto_login_fake_accounts_per_cron_job.value" class="form-control" />
						</div>
					</div>

					<hr />

					<div class="form-group">
						<label>{{ configs.allow_intro_message_sent_to_male_members.name }}</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="configs.allow_intro_message_sent_to_male_members.value" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>

					<div v-if="configs.allow_intro_message_sent_to_male_members.value" class="form-group">
						<label>{{ configs.number_of_messages_per_cron_job.name }}</label>
						<div class="input-group col-md-6">
							<input v-model="configs.number_of_messages_per_cron_job.value" class="form-control" />
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

	import Settings from './../stores/settings'

	export default {

		data() {
			return {
				configs: {
					auto_login_entire_site: {name: '', value: ''},
					auto_login_accounts_per_cron_jobs: {name: '', value: ''},
					auto_login_fake_accounts: {name: '', value: ''},
					auto_login_fake_accounts_per_cron_job: {name: '', value: ''},
					allow_intro_message_sent_to_male_members: {name: '', value: ''},
					number_of_messages_per_cron_job: {name: '', value: ''}
				}
			}
		},

		ready() {

			Settings.getConfigs().then(response => {
				this.configs = response.data;
			});

		},

		methods: {

			saveSettings() {
				Settings.updateConfigs(this.configs).then(response => {
					toastr.success(response.data);
				});
			}

		},

		watch: {
			'configs.auto_login_entire_site.value'(val) {
				this.$nextTick(() => {
					if (val == 1 || val == true) {
						this.configs.auto_login_fake_accounts.value = false;
					}
				})
			},

			'configs.auto_login_fake_accounts.value'(val) {
				this.$nextTick(() => {
					if (val == 1 || val == true) {
						this.configs.auto_login_entire_site.value = false;
					}
				})
			}
		}

	}
</script>
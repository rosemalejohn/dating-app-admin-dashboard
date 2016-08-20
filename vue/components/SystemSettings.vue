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

					<div class="form-group">
		                <label>{{ configs.currency.name }}</label>
		                <div class="input-group col-md-6">
			                <select v-model="configs.currency.value" class="form-control">
			                    <option {{ configs.currency.value == currency.code }} v-for="currency in currencies" :value="currency.code">{{ currency.currency }}{{ currency.code ? ' - ' + currency.code : '' }}</option> 
			                </select>
		                </div>
		            </div>

		            <hr />
		            <div class="form-group">
						<label>{{ configs.allow_fake_profile_views.name }}</label>
						<div class="input-group">
							<div class="icheck-list">
								<label>
								<input v-model="configs.allow_fake_profile_views.value" type="checkbox" class="icheck"> Yes </label>
							</div>
						</div>
					</div>

					<div v-if="configs.allow_fake_profile_views.value" class="form-group">
						<label>{{ configs.number_of_profile_view.name }}</label>
						<div class="input-group col-md-6">
							<input v-model="configs.number_of_profile_view.value" class="form-control" />
						</div>
					</div>
		           
		            <template v-if="user.is_super">
		            	<hr />
			            <div class="form-group">
							<label>{{ configs.allow_site_limit.name }}</label>
							<div class="input-group">
								<div class="icheck-list">
									<label>
									<input v-model="configs.allow_site_limit.value" type="checkbox" class="icheck"> Yes </label>
								</div>
							</div>
						</div>

						<div v-if="configs.allow_site_limit.value" class="form-group">
							<label>{{ configs.site_limit.name }}</label>
							<div class="input-group col-md-6">
								<input v-model="configs.site_limit.value" class="form-control" />
							</div>
						</div>
					</template>
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
	import Currency from './../stores/currency'

	export default {

		data() {
			return {
				configs: {
					auto_login_entire_site: {name: '', value: ''},
					auto_login_accounts_per_cron_jobs: {name: '', value: ''},
					auto_login_fake_accounts: {name: '', value: ''},
					auto_login_fake_accounts_per_cron_job: {name: '', value: ''},
					allow_intro_message_sent_to_male_members: {name: '', value: ''},
					number_of_messages_per_cron_job: {name: '', value: ''},
					currency: {name: '', value: ''},
					site_limit: {name: '', value: ''},
					allow_site_limit: {name: '', value: ''},
				},
				currencies: [],
				user: {
					is_super: false
				}
			}
		},

		ready() {

			Settings.getConfigs().then(response => {
				this.configs = response.data;
			});

			this.currencies = Currency.getCurrencies();

			this.$http.get('auth').then(response => {
				this.user = response.data;
			})

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
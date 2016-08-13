<template>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="POST">
		<input type="hidden" name="return" :value="host + '/users'">
		<input type="hidden" name="cancel_return" :value="host + '/users'">
		<input type="hidden" name="business" value="{{ account.paypal_email }}" />
		<input type="hidden" name="item_name" value="Payout to {{ account.name }}" />
		<input type="hidden" name="currency_code" value="{{ account.currency || 'USD' }}" />
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="amount" value="{{ account.earnings || 0.00 }}" />
		<button class="btn btn-success btn-xs" type="submit">
			<i class="fa fa-paypal"></i>&nbsp;Pay
		</button>
	</form>
</template>

<script>
	import Settings from './../stores/settings'
	import Config from './../config'

	export default {

		props: {
			account: {
				type: Object,
				default() {
					return {}
				}
			}
		},
		data() {
			return {
				host: '',
			}
		},

		ready() {
			Settings.getConfigs().then(response => {
				this.account.currency = response.data.currency.value;
			});

			this.host = Config.host;
		}
	}
</script>
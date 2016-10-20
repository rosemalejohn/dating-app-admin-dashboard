<template>
	<form @submit.prevent="submit()">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-green">
					<i class="icon-people font-green"></i>
					<span class="caption-subject bold uppercase"> Add new affiliate</span>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="form-body">
					<div class="row">
						<div class="col-md-8">
							<h3>Personal Information</h3>
							<hr />
							<div class="row">
								<div class="col-md-4">
									<label for="">Google Authenticator</label>
									<qr-code :photo.sync="form.qr_code"></qr-code>

									<br />

									<label for="">Photo</label>
									<photo :photo.sync="form.photo"></photo>
								</div>
								<div class="col-md-8">
									<div class="form-group form-md-line-input">
										<input v-model="form.company" type="text" class="form-control" id="">
										<label for="">Company</label>
										<span class="help-block error-block" v-if="errors.company">
											<ul><li v-for="error in errors.company">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<input v-model="form.name" type="text" class="form-control" id="">
										<label for="">Name</label>
										<span class="help-block error-block" v-if="errors.name">
											<ul><li v-for="error in errors.name">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<input v-model="form.birthday" type="date" class="form-control" id="">
										<label for="">Birthday</label>
										<span class="help-block error-block" v-if="errors.birthday">
											<ul><li v-for="error in errors.birthday">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<textarea v-model="form.address" class="form-control" rows="3"></textarea>
										<label for="">Address</label>
										<span class="help-block error-block" v-if="errors.address">
											<ul><li v-for="error in errors.address">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input has-info">
										<select v-model="form.country" class="form-control">
											<option v-for="country in countries" :value="country.code">{{ country.name }}</option>
										</select>
										<label for="">Country</label>
										<span class="help-block error-block" v-if="errors.country">
											<ul><li v-for="error in errors.country">{{ error }}</li></ul>
										</span>
									</div>

									<div class="form-group form-md-line-input">
										<input v-model="form.phone" type="text" class="form-control" id="">
										<label for="">Phone</label>
										<span class="help-block error-block" v-if="errors.phone">
											<ul><li v-for="error in errors.phone">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<input v-model="form.email" type="email" class="form-control" id="">
										<label for="">Email</label>
										<span class="help-block error-block" v-if="errors.email">
											<ul><li v-for="error in errors.email">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<input v-model="form.skype" type="text" class="form-control" id="">
										<label for="">Skype</label>
										<span class="help-block error-block" v-if="errors.skype">
											<ul><li v-for="error in errors.skype">{{ error }}</li></ul>
										</span>
									</div>
									<div class="form-group form-md-line-input">
										<input v-model="form.payment" type="text" class="form-control" id="">
										<label for="">Payment</label>
										<span class="help-block error-block" v-if="errors.payment">
											<ul><li v-for="error in errors.payment">{{ error }}</li></ul>
										</span>
									</div>

									<div class="form-group form-md-line-input has-info">
										<select v-model="form.currency" class="form-control">
											<option v-for="currency in currencies" :value="currency.code">{{ currency.currency }}</option>
										</select>
										<label for="">Currency</label>
										<span class="help-block error-block" v-if="errors.currency">
											<ul><li v-for="error in errors.currency">{{ error }}</li></ul>
										</span>
									</div>

									<div class="form-group form-md-line-input">
										<input v-model="form.salary" type="number" class="form-control" id="">
										<label for="">Salary</label>
										<span class="help-block error-block" v-if="errors.salary">
											<ul><li v-for="error in errors.salary">{{ error }}</li></ul>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<h3>Contract terms</h3>
							<hr />
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.chargeback_rate" type="number" class="form-control" id="">
								<label for="">Chargeback rate</label>
							</div>
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.minimum_payout" type="text" class="form-control" id="">
								<label for="">Minimum payout</label>
							</div>
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.chargeback_fee" type="text" class="form-control" id="">
								<label for="">Chargeback fee</label>
							</div>
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.billing_period" type="text" class="form-control" id="">
								<label for="">Billing period</label>
							</div>
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.rolling_reserve" type="number" class="form-control" id="">
								<label for="">Rolling reserve %</label>
							</div>
							<div class="form-group form-md-line-input">
								<input v-model="form.contract.rolling_reserve_period" type="text" class="form-control" id="">
								<label for="">Rolling reserve period</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions noborder">
					<button type="submit" class="btn blue">Add affiliate</button>
					<button onclick="window.history.back();" type="button" class="btn default">Cancel</button>
				</div>
			</div>
		</div>
	</form>
</template>

<style lang="sass">
	.error-block {
	    color: red !important;
    	opacity: 1 !important;

    	ul {
		    list-style-type: none;
    		padding-left: 0px;
    	}
	}
</style>

<script>
	import Photo from './../components/PhotoUpload.vue'
	import QrCode from './../components/PhotoUpload.vue'
	import country from './../stores/countries'
	import currency from './../stores/currency'
	import _ from 'underscore'

	export default {

		components: {
			Photo, QrCode
		},

		data() {
			return {
				form: {
					name: '',
					birthday: '',
					address: '',
					country: '',
					phone: '',
					skype: '',
					payment: '',
					currency: '',
					qr_code: '',
					photo: '',
					salary: 0,
					email: '',
					password: 'admin',
					password_confirmation: 'admin',
					contract: {},
				},
				countries: [],
				currencies: [],
				errors: []
			}
		},

		ready() {

			this.countries = country.all();

			this.currencies = currency.getCurrencies();

		},

		methods: {
			submit() {
				this.save();
			},

			save() {
				this.$http.post('affiliates', this.form)
					.then(response => {
						toastr.success('Affiliate added!');
					}).catch(err => {
						toastr.error('Affiliate not added!');
						this.errors = err.data;
					});
			}
		}

	}
</script>
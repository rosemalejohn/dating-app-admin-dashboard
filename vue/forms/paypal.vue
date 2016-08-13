<template>
    <form @submit.prevent="pay()" role="form">
        <div class="form-body">
            <div class="form-group">
                <label>Name</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input v-model="form.name" disabled type="text" class="form-control" placeholder="Full name">
                </div>
            </div>

            <div class="form-group">
                <label>Recipient email</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input v-model="form.business" type="email" class="form-control" placeholder="Email">
                </div>
            </div>

            <div class="form-group">
                <label>Amount</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-usd"></i>
                    </span>
                    <input disabled="" v-model="form.amount" type="number" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" value="Paypal" class="btn btn-success"><i class="fa fa-paypal"></i>&nbsp;Pay now</button>
    </form>
</template>

<script>

import Config from './../config'

export default {

    props: {
        form: {
            type: Object,
            twoWay: true,
            default() {
                return {
                    name: '',
                    return: Config.host,
                    cancel_return: Config.host,
                    rm: 2,
                    business: '',
                    item_name: 'Payout to user',
                    currency_code: 'USD',
                    no_note: 1,
                    charset: 'utf-8',
                    cmd: '_xclick-auto-billing',
                    amount: 1200
                }
            }
        }
    },

    methods: {
        pay() {
            console.log(JSON.stringify(this.form));
            this.$http.post('https://www.paypal.com/cgi-bin/webscr', this.form).then(response => {
                console.log(response);
            });
        }
    }
}
</script>
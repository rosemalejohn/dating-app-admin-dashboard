<template>
    <form role="form">
        <div class="form-body">
            <div class="form-group">
                <label>Name</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input v-model="form.name" type="text" class="form-control" placeholder="Full name">
                </div>
            </div>

            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input v-model="form.username" type="text" class="form-control" placeholder="Username" required="">
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input v-model="form.email" type="email" class="form-control" placeholder="Email" required="">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input v-model="form.password" type="text" class="form-control" placeholder="Generate password" required="">
                </div>
            </div>

            <div class="form-group">
                <label>Account type</label>
                <select v-model="form.type" class="form-control">
                    <option value="user" selected="">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

        </div>
    </form>
</template>

<script>

export default {
    props: {
        method: {
            type: String,
            default: 'POST'
        },

        form: {
            type: Object,
            twoWay: true,
            default() {
                return {}
            }
        }
    },

    methods: {
        submit() {
            this.$http.post('users', this.form)
                .then(response => {
                    this.form = {};
                    toastr.success('User: ' + response.data.name + ' is created!');
                    this.$dispatch('user:created', response.data);
                })
        }
    },

    events: {
        'form:submit'(form) {
            if (form == 'user')
                this.submit();
        }
    }
}
</script>
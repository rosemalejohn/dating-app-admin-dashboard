<template>
    <form role="form">
        <div class="form-body">
            <div class="form-group">
                <label>Photo</label>
                <div class="row">
                    <div class="col-md-4">
                        <user-photo-upload :photo.sync="form.photo"></user-photo-upload>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Name</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input v-model="form.name" type="text" class="form-control" placeholder="Full name">
                </div>
                <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
            </div>

            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input v-model="form.email" type="email" class="form-control" placeholder="Email" required="">
                </div>
                <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input v-model="form.password" type="text" class="form-control" placeholder="Generate password" required="">
                </div>
                <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
            </div>

            <div class="form-group">
                <label>Account type</label>
                <select v-model="form.type" class="form-control">
                    <option value="user" selected="">User</option>
                    <option value="admin">Admin</option> 
                </select>
            </div>

            <hr />

            <div class="form-group">
                <label>Contact information</label>
                <textarea v-model="form.contact_info" class="form-control"></textarea>
            </div>

        </div>
    </form>
</template>

<script>

import User from './../stores/user'
import Website from './../stores/website'
import UserPhotoUpload from './../components/PhotoUpload.vue'

import UserModel from './../models/user'

import Spinner from './../spin'

export default {
    
    components: {
        UserPhotoUpload
    },

    props: {
        method: {
            type: String,
            default: 'POST'
        },

        form: {
            type: Object,
            twoWay: true,
            default() {
                return UserModel
            },
            required: false
        }
    },

    ready() {
        Website.all().then(response => {
            this.websites = response.data
        })
    },

    data() {
        return {
            websites: [],

            errors: [], 

            saving: false
        }
    },

    methods: {
        submit() {
            if (!this.saving) {
                this.saving = true;
                User.store(this.form).then(response => {
                    this.form = {};
                    this.errors = [];
                    toastr.success('User: ' + response.data.name + ' is created!');
                    this.$dispatch('user:created', response.data);
                    this.saving = false;
                }).catch(response => {
                    this.saving = false;
                    this.errors = response.data
                })
            }
        }
    },

    events: {
        'form:submit'(form) {
            if (form == 'user')
                this.submit();
        }
    },

    watch: {
        saving(val) {
            this.$nextTick(() => {
                if (val) {
                    Spinner.stop()
                } else {
                    Spinner.spin()
                } 
            })
        }
    }
}
</script>
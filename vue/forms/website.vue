<template>
    <form role="form" enctype="multipart/form-data">
        <div class="form-body">
            <div class="form-group">
                <label>Photo</label>
                <div class="row">
                    <div class="col-md-4">
                        <website-photo-upload :photo.sync="form.logo"></website-photo-upload>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input v-model="form.name" type="text" class="form-control" placeholder="Site name">
                    </div>
                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                </div>

                <div class="form-group col-md-6">
                    <label>Url</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-link"></i>
                        </span>
                        <input v-model="form.url" type="url" class="form-control" placeholder="Url" required="">
                    </div>
                    <small v-if="errors.url" class="text-danger">{{ errors.url[0] }}</small>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="form-group col-md-6">
                    <label>URL</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-link"></i>
                        </span>
                        <input v-model="form.host" type="url" class="form-control" placeholder="Database URL" required="">
                    </div>
                    <small v-if="errors.host" class="text-danger">{{ errors.host[0] }}</small>
                </div>

                <div class="form-group col-md-6">
                    <label>Database name</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input v-model="form.database" type="text" class="form-control" placeholder="Database name" required="">
                    </div>
                    <small v-if="errors.database" class="text-danger">{{ errors.database[0] }}</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input v-model="form.username" type="text" class="form-control" placeholder="Database username" required="">
                    </div>
                    <small v-if="errors.username" class="text-danger">{{ errors.username[0] }}</small>
                </div>

                <div class="form-group col-md-6">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input v-model="form.password" type="text" class="form-control" placeholder="Database password" required="">
                    </div>
                    <small v-if="errors.password" class="text-danger">{{ errors.name[0] }}</small>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Port</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input v-model="form.port" type="text" class="form-control" placeholder="Database port" required="">
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Prefix</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input v-model="form.prefix" type="text" class="form-control" placeholder="Database prefix" required="">
                    </div>
                </div>
            </div>
            <hr />
            
            <div class="form-group">
                <label>FTP Host</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input v-model="form.ftp.host" type="text" class="form-control" placeholder="FTP host" required="">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>FTP Username</label> 
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input v-model="form.ftp.username" type="text" class="form-control" placeholder="FTP username" required="">
                    </div>
                </div>
            
                <div class="form-group col-md-6">
                    <label>FTP Password</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input v-model="form.ftp.password" type="text" class="form-control" placeholder="FTP password" required="">
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import Website from './../stores/website'
import WebsitePhotoUpload from './../components/PhotoUpload.vue'

import Spinner from './../spin'

export default {

    components: {
        WebsitePhotoUpload
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
                return {
                    ftp: {}
                }
            },
            required: false
        }
    },

    data() {
        return {
            errors: [],

            saving: false
        }
    },

    methods: {
        submit() {
            if (this.method == 'POST') {
                this.store();
            } else {
                this.update();
            }
        },

        store() {
            if (!this.saving) {
                this.saving = Spinner.spin();
                Website.store(this.form).then(response => {
                    toastr.success('Website: ' + response.data.name + ' created!');
                    this.$dispatch('website:created', response.data);
                    this.form = {}
                    this.errors = [];
                    this.saving = Spinner.stop();
                }).catch(response => {
                    this.saving = Spinner.stop();
                    if (response.status == 500) {
                        toastr.error(response.data);
                    }
                    this.errors = response.data
                })
            }
        },

        update() {
            if (!this.saving) {
                this.saving = Spinner.spin();
                Website.update(this.form).then(response => {
                    toastr.success('Website updated!');
                    this.saving = Spinner.stop();
                }).catch(e => {
                    this.saving = Spinner.stop();
                    toastr.error('Something went wrong while updating. Please reload the page and try again.');
                })
            }
        }
    },

    events: {
        'form:submit'(form) {
            if (form == 'website')
                this.submit();
        }
    }
}
</script>
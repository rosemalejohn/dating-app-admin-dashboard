<template>
    <form @submit.prevent="submit()" role="form">
        <div class="form-body">
            <div class="form-group">
                <label>Notes</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-info"></i>
                    </span>
                    <input v-model="form.notes" type="text" class="form-control" placeholder="Add notes...">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</template>

<script>

import Spinner from './../spin'
import Conversation from './../stores/conversation'

export default {

    props: {

        form: {
            type: Object,
            twoWay: true,
            default() {
                return {}
            },
            required: false
        },

        conversation: {
            type: Object,
            twoWay: true,
            default() {
                return {}
            }
        },

        method: {
            type: String,
            default: 'POST',
            required: false
        }
    },

    methods: {
        submit() {
            if (this.method == 'POST') {
                Spinner.spin();
                Conversation.flag(this.form)
                    .then(response => {
                        this.conversation.is_flagged = true;
                        this.conversation.flagged.notes = this.form.notes;
                        this.form.notes = '';
                        toastr.success('Conversation flagged.');
                        Spinner.stop();
                    }).catch(err => {
                        toastr.error('Cannot update notes.');
                        Spinner.stop();
                    });
            } else {
                Spinner.spin();
                Conversation.updateFlag(this.form)
                    .then(response => {
                        Spinner.stop();
                        toastr.success('Notes updated!');
                    }).catch(err => {
                        Spinner.stop();
                    })
            }
        }
    }
}
</script>
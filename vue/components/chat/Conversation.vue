<template>
	<div class="alert alert-danger" v-if="conversation.is_flagged">
		This conversation is flagged due to: <strong>{{ conversation.flagged.notes }}</strong>
		<button v-if="conversation.flagged.user_id == $root.auth.id" data-toggle="modal" data-target="#showUpdateConversationFlaggedModal" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></button>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-push-3">
			<chat-box></chat-box>
		</div>
		<div class="col-md-3 col-md-pull-6">
			<profile-box :user="conversation.interlocutor"></profile-box>
			<notes :notes.sync="conversation.notes" filter="interlocutor"></notes>
		</div>
		<div class="col-md-3">
			<profile-box :user="conversation.initiator"></profile-box>
			<notes :notes.sync="conversation.notes" filter="initiator"></notes>
		</div>
	</div>
	<update-conversation-flagged-modal title="Update notes" target="showUpdateConversationFlaggedModal">
		<conversation-flagged-form 
			slot="content" 
			:form.sync="conversation.flagged" 
			:conversation.sync="conversation"
			method="PUT"></conversation-flagged-form>
		<div slot="modal-footer"></div>
	</update-conversation-flagged-modal>
</template>

<script>
	import ProfileBox from './ProfileBox.vue'
	import ChatBox from './ChatBox.vue'
	import Notes from './Notes.vue'

	import ConversationFlaggedForm from './../../forms/FlaggedConversationNotes.vue'
	import UpdateConversationFlaggedModal from './../Modal.vue'

	export default {

		components: {
			ProfileBox, ChatBox, Notes, ConversationFlaggedForm, UpdateConversationFlaggedModal
		},

		props: {
			website: {
				type: Object,
				default() {
					return {}
				}
			},

			conversation: {
				type: Object,
				default() {
					return {}
				}
			},
		},

		ready() {
			let self = this;
			window.onbeforeunload = function(e) {
				self.$http.delete('chat/' + self.website.id + '/' + self.conversation.id + '/active-conversation')
					.then(response => {
						console.log(response.data);
					});
	  		}
		},

		methods: {
			sendAndNext() {
				this.$broadcast('chat:send');
			}
		}

	}
</script>
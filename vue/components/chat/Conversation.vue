<template>
	<div class="row">
		<div class="col-md-3">
			<profile-box :profile="conversation.interlocutor"></profile-box>
			<notes :notes.sync="conversation.notes" filter="interlocutor"></notes>
		</div>
		<div class="col-md-6">
			<chat-box></chat-box>
		</div>
		<div class="col-md-3">
			<profile-box :profile="conversation.initiator"></profile-box>
			<notes :notes.sync="conversation.notes" filter="initiator"></notes>
		</div>
	</div>
</template>

<script>
	import ProfileBox from './ProfileBox.vue'
	import ChatBox from './ChatBox.vue'
	import Notes from './Notes.vue'

	export default {

		components: {
			ProfileBox, ChatBox, Notes
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
			setTimeout(function() {
				window.location.replace('/chat');
			}, 300000)

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
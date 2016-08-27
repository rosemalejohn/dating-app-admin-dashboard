<template>
	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-bubble font-red-sunglo"></i>
				<span class="caption-subject font-red-sunglo bold uppercase">Chats</span>
			</div>
			<div class="actions">
				<div class="btn-group btn-group-devided" data-toggle="buttons">
					<button onclick="window.history.back();" class="btn btn-danger grey-salsa btn-circle btn-sm">Cancel</button>
					<button v-if="conversation.is_flagged" @click="unflagConversation()" class="btn btn-danger grey-salsa btn-circle btn-sm">Unflag</button>
					<button v-else data-toggle="modal" data-target="#showFlaggedConversationModal" class="btn btn-danger grey-salsa btn-circle btn-sm">Flag</button>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="chat-box-scroller" style="height: 400px;" data-always-visible="1" data-rail-visible="1">
				<ul v-if="messages" class="chats">
					<li v-for="message in messages | filterBy searchMessage" class="{{ message.is_sender ? 'out' : 'in' }}">
						<img class="avatar" :src="message.is_sender ? initiator.avatar.url : interlocutor.avatar.url"/>
						<div class="message">
							<span class="arrow"> 
							</span>
							<a target="_blank" href="{{ website.url + '/user/' + message.sender.username }}" class="name">
								{{ message.sender ? message.sender.username : '' }}
							</a>
							<span class="datetime">
							at {{ message.timeStamp | date 'unix' }}</span>
							<span class="body">{{ message.text }}</span>
						</div>
						<div class="message" v-for="attachment in message.attachments" v-if="message.attachments">
							<a class="attachment" href="#" data-featherlight="{{ attachment.link }}">
								<img :class="{'pull-right': message.is_sender}" class="thumbnail" width="40%" :src="attachment.link" />
							</a>
						</div>
					</li>
					<!-- <li v-if="file" class="in" style="position: relative;">
						<img class="avatar" :src="interlocutor.avatar.url"/>
						<div class="message">
							<i @click="file == ''" class="fa fa-close close"></i>
							<a class="attachment" href="#">
								<img :class="" class="thumbnail" width="40%" :src="file" />
							</a>
						</div>
					</li> -->
				</ul>
				<p v-else>No messages to show.</p>
			</div>
			<div v-if="messages" class="chat-form">
				<form @submit.prevent="send()">
					<div class="input-cont">
						<input class="form-control" v-model="textContent" type="text" placeholder="Press enter to send..."/>
					</div>
					<div class="btn-cont">
						<span class="arrow">
						</span>
						<button type="submit" class="btn blue icn-only">
							<i class="fa fa-arrow-right icon-white"></i>
						</button>
						<photo-upload :photo.sync="file">
							<button slot="holder" onclick="document.getElementById('photo').click();" type="button" class="btn blue icn-only">
								<i class="fa fa-photo icon-white"></i>
							</button>
						</photo-upload>
					</div>
				</form>
			</div>
		</div>
	</div>
	<button @click="sendAndNext()" class="btn btn-success grey-salsa btn-circle btn-sm pull-right">Send and next</button>
	<flagged-conversation-modal title="Add notes" target="showFlaggedConversationModal">
		<flagged-conversation-notes slot="content" :form.sync="flaggedConversationForm" :conversation.sync="conversation"></flagged-conversation-notes>
		<div slot="modal-footer"></div>
	</flagged-conversation-modal>
</template>

<style lang="sass">
	.attachment {
		display: inline-block;
	}

	.chat-form {
		.input-cont {
			margin-right: 100px;
		}
		.btn-cont {
			width: unset;

			.arrow {
				right: 100px;
			}
		}
	}
	.avatar {
		&:hover {
			.close {
				display: block;
			}
		}
	}
	.close {
		position: absolute;
		top: 0;
		left: 70px;
	}
</style>

<script>
	import moment from 'moment'
	import Vue from 'vue'
	import Spinner from './../../spin'
	import Conversation from '../../stores/conversation'
	import FlaggedConversationModal from './../Modal.vue'
	import PhotoUpload from './../PhotoUpload.vue'
	import FlaggedConversationNotes from './../../forms/FlaggedConversationNotes.vue'

	export default {

		components: {
			FlaggedConversationModal, FlaggedConversationNotes, PhotoUpload
		},

		data() {
			return {
				textContent: '',
				file: '',
				initiator: this.$parent.conversation.initiator,
				interlocutor: this.$parent.conversation.interlocutor,
				conversation: this.$parent.conversation,
				website: this.$parent.website,
				messages: [],
				flaggedConversationForm: {
					notes: '',
					website_id: '',
					conversation_id: ''
				}
			}
		},

		ready() {
			Spinner.spin();
			this.$http.get('chat/' + this.website.id + '/' + this.conversation.id + '/messages')
				.then(response => {
					Spinner.stop();
					this.messages = response.data;
				}).catch(err => {
					Spinner.stop();
					toastr.error('Cannot fetch conversation messages.');
				})

			this.flaggedConversationForm = {
				website_id: this.website.id,
				conversation_id: this.conversation.id,
			}
		},

		methods: {

			send() {
				let message = {
					text: this.textContent,
					sender: this.$parent.conversation.interlocutor,
					recipient: this.$parent.conversation.initiator,
					timeStamp: moment().unix(),
					file: this.file
				}
				this.messages.push(message);
				this.textContent = ''
				this.$http.post('chat/' + this.$parent.website.id + '/' + this.$parent.conversation.id, message).then(response => {
					message.attachments = response.data.attachments;
					toastr.success('Message sent!');
				}).catch(response => {
					this.textContent = message.text;
					this.messages.$remove(message);
					toastr.error('Message not sent!');
				})
			},

			sendAndNext() {
				let message = {
					text: this.textContent,
					sender: this.$parent.conversation.interlocutor,
					recipient: this.$parent.conversation.initiator,
					timeStamp: moment().unix()
				}
				this.messages.push(message);
				this.textContent = ''
				this.$http.post('chat/' + this.$parent.website.id + '/' + this.$parent.conversation.id, message).then(response => {
					toastr.success('Message sent!');
					window.location.replace('/chat/next');
				}).catch(response => {
					this.textContent = message.text;
					this.messages.$remove(message);
					toastr.error('Message not sent!');
				})
			},	

			unflagConversation() {
				Conversation.unflag(this.website.id, this.conversation.id).then(response => {
					this.conversation.is_flagged = false;
						toastr.success(response.data);
					})
			}

		},

		events: {
			'chat:send'() {
				this.send();
			}
		},

		watch: {
			messages() {
				this.$nextTick(() => {
					$('.chat-box-scroller').slimScroll({
					    start: 'bottom',
					});
				})
			}
		}
	}
</script>
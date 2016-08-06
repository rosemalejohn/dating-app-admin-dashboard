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
					<button v-else @click="flagConversation()" class="btn btn-danger grey-salsa btn-circle btn-sm">Flag</button>
					<button @click="sendAndNext()" class="btn btn-success grey-salsa btn-circle btn-sm">Send and next</button>
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
					</li>
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
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import moment from 'moment'
	import Vue from 'vue'
	import Spinner from './../../spin'
	import Conversation from '../../stores/conversation'

	export default {

		data() {
			return {
				textContent: '',
				initiator: this.$parent.conversation.initiator,
				interlocutor: this.$parent.conversation.interlocutor,
				conversation: this.$parent.conversation,
				website: this.$parent.website,
				messages: []
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
		},

		methods: {

			send() {
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

			flagConversation() {
				Conversation.flag(this.website.id, this.conversation.id)
					.then(response => {
						this.conversation.is_flagged = true;
						toastr.success('Conversation flagged.')
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
<template>
	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-bubble font-red-sunglo"></i>
				<span class="caption-subject font-red-sunglo bold uppercase">Chats</span>
			</div>
			<div class="inputs">
				<div class="portlet-input input-inline input-small">
					<div class="input-icon right">
						<i class="icon-magnifier"></i>
						<input v-model="searchMessage" type="text" class="form-control input-circle" placeholder="Search message...">
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
				<ul v-if="messages" class="chats">
					<li v-for="message in messages | filterBy searchMessage 
					| orderBy 'id' -1" class="{{ message.is_sender ? 'out' : 'in' }}">
						<img class="avatar" :src="message.sender.avatar.url || '/img/default-photo.png'"/>
						<div class="message">
							<span class="arrow">
							</span>
							<a href="javascript:;" class="name">
							{{ message.sender.username }} </a>
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
	export default {

		props: {
			messages: {
				type: Array,
				default() {
					return []
				}
			}
		},

		data() {
			return {
				searchMessage: '',
				textContent: ''
			}
		},

		methods: {

			send() {
				let message = {
					text: this.textContent,
					sender: this.$parent.conversation.interlocutor,
					recipient: this.$parent.conversation.initiator,
					timeStamp: new Date().getTime()
				}
				this.$http.post('chat/' + this.$parent.website.id + '/' + this.$parent.conversation.id, message).then(response => {
					this.messages.push(message);
					this.textContent = ''
				}).catch(response => {
					this.messages.push(message);
					toastr.error('Message not sent!');
				})

				
			}

		}
	}
</script>
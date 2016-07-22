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
		<div class="portlet-body" id="chats">
			<div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
				<ul v-if="conversation.messages" class="chats">
					<li v-for="message in conversation.messages | filterBy searchMessage" class="in">
						<img class="avatar" alt="" :src="message.recipient.profile.photo || '/img/default-photo.png'"/>
						<div class="message">
							<span class="arrow">
							</span>
							<a href="javascript:;" class="name">
							{{ message.recipient.username }} </a>
							<span class="datetime">
							at 20:09 </span>
							<span class="body">{{ message.text }}</span>
						</div>
					</li>
				</ul>
				<p v-else>No conversation selected.</p>
			</div>
			<div v-if="conversation.messages" class="chat-form">
				<div class="input-cont">
					<input class="form-control" type="text" placeholder="Press enter to send..."/>
				</div>
				<div class="btn-cont">
					<span class="arrow">
					</span>
					<button @click="send()" class="btn blue icn-only">
						<i class="fa fa-arrow-right icon-white"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	
	export default {

		props: {
			conversation: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		data() {
			return {
				searchMessage: ''
			}
		},

		methods: {

			send() {
				
			}

		}

	}
</script>
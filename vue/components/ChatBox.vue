<template>
	<div class="row">
		<div class="col-md-8">
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
						<ul v-if="conversation.messages" class="chats">
							<li v-for="message in conversation.messages | filterBy searchMessage" class="{{ conversation.initiator.id == message.sender.id ? 'in' : 'out' }}">
								<img class="avatar" :src="message.sender.avatar.url || '/img/default-photo.png'"/>
								<div class="message">
									<span class="arrow">
									</span>
									<a href="javascript:;" class="name">
									{{ message.sender.username }} </a>
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
		</div>
		<div v-if="conversation.messages" class="col-md-4">
			<div class="portlet light profile-sidebar-portlet website-list">
				<div class="profile-userpic">
					<a href="">
						<img :src="conversation.interlocutor.avatar.url || '/img/default-photo.png'" class="img-responsive thumbnail" alt="Interlocutor image">
					</a>
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						Managed profile: 
						<strong>{{ conversation.interlocutor.username }}</strong>
					</div>
				</div>
			</div>
			<hr />
			<div class="portlet light profile-sidebar-portlet website-list">
				<div class="profile-userpic">
					<a href="">
						<img :src="conversation.initiator.avatar.url || '/img/default-photo.png'" class="img-responsive thumbnail" alt="Initiator image">
					</a>
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{ conversation.initiator.username }}
					</div>
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
<template>
	<div class="row">
		<div class="col-md-3">
			<div class="portlet light profile-sidebar-portlet">
				<div class="profile-userpic">
					<photo-upload :photo.sync="website.logo"></photo-upload>
				</div>
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{ website.name }}
					</div>
					<div class="profile-usertitle-job">
						<a href="{{ website.url }}" target="_blank">{{ website.url }}</a>
					</div>
				</div>
				<div class="profile-usermenu">
					<ul class="nav">
						<li class="active">
							<a href="#credentials" data-toggle="tab">
							<i class="icon-lock"></i>
							Credentials </a>
						</li>
						<li>
							<a href="/websites/{{ website.id }}/users">
							<i class="icon-user"></i>
							Users </a>
						</li>
						<li>
							<a data-target="#editWebsiteModal" data-toggle="modal">
							<i class="fa fa-edit"></i>
							Edit details </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
				<div id="users" class="tab-pane fade">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption caption-md">
								<i class="icon-bar-chart theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase">Users</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row number-stats margin-bottom-30">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="stat-left">
										<div class="stat-chart">
											<div id="sparkline_bar"></div>
										</div>
										<div class="stat-number">
											<div class="title">
												 Total
											</div>
											<div class="number">
												{{ website.users.length }}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<div class="stat-right">
										<div class="stat-chart">
											<div id="sparkline_bar2"></div>
										</div>
										<div class="stat-number">
											<div class="title">
											 	New
											</div>
											<div class="number">
											 	{{ website.users.length }}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
									<tr class="uppercase">
										<th colspan="2">
										 	MEMBER
										</th>
									</tr>
								</thead>
								<tr v-for="user in website.users">
									<td class="fit">
										<img class="user-pic" src="/img/default-photo.png">
									</td>
									<td>
										<a href="/users/{{ user.id }}/edit" class="primary-link">{{ user.name }}</a>
									</td>
								</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="credentials" class="tab-pane fade">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption caption-md">
								<i class="icon-bar-chart theme-font hide"></i>
								<span class="caption-subject font-blue-madison bold uppercase">Credentials</span>
							</div>
						</div>
						<div class="portlet-body">
							<p>URL: {{ website.host }}</p>
							<p>Name: {{ website.database }}</p>
							<p>Username: {{ website.username }}</p>
							<p>Password: {{ website.password }}</p>
							<p>Prefix: {{ website.prefix }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<edit-website-modal title="Website" target="editWebsiteModal">
        <website-form slot="content" method="PUT" :form.sync="website"></website-form>
        <div slot="modal-footer" class="modal-footer">
            <button @click="saveWebsite()" type="button" class="btn btn-default">Save</button>
        </div>
    </edit-website-modal>
</template>

<style lang="sass">
	.profile-userpic {
	    padding: 10px;
		img {
			cursor: pointer;
			border-radius: 0px !important;
			width: 100%;
		}
	}
</style>

<script>
	import EditWebsiteModal from './Modal.vue'
	import WebsiteForm from './../forms/website.vue'
	import PhotoUpload from './../components/PhotoUpload.vue'

	export default {
		components: {
			EditWebsiteModal, WebsiteForm, PhotoUpload
		},

		props: {
			website: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		methods: {
			saveWebsite() {
				this.$broadcast('form:submit', 'website')
			},

			changePhoto() {
				this.$http.put('websites/' + this.website.id + '/change-photo', {logo: this.website.logo})
					.then(response => {
						toastr.success(response.data);
					})
			}
		},

		watch: {
			'website.logo': function() {
				this.$nextTick(response => {
					this.changePhoto();
				})
			}
		}

	}
</script>
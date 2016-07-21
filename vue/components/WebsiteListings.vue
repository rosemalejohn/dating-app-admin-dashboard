<template>
	<div class="row">
		<div v-if="!websites.length" class="col-md-12">
			<div class="note note-info note-bordered">
				<p>No websites listed.</p>
			</div>
		</div>
		<div v-for="website in websites" class="col-md-3">
			<div class="portlet light profile-sidebar-portlet">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<a href="/websites/{{ website.id }}">
						<img :src="website.logo || '/img/default-photo.png'" class="img-responsive" alt="">
					</a>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						{{ website.name }}
					</div>
					<div class="profile-usertitle-job">
						<a href="{{ website.url }}" target="_blank">{{ website.url }}</a>
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<a data-target="#editWebsiteModal" data-toggle="modal" @click="edit(website)" href="#" class="btn btn-circle green-haze btn-sm">Manage</a>
					<a href="/websites/{{ website.id }}/users" class="btn btn-circle btn-primary btn-sm">Profiles</a>
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

<script>
	import swal from 'sweetalert'
	import Website from './../stores/website'

	import EditWebsiteModal from './Modal.vue'
	import WebsiteForm from './../forms/website.vue'
	
	export default {

		props: {

			websites: {
				type: Array,
				default() {
					return []
				}
			}

		},

		components: {
			EditWebsiteModal, WebsiteForm
		},

		data() {
			return {
				website: {}
			}
		},

		methods: {

			edit(website) {
				this.website = website;
			},

			remove(website) {
				swal({
					title: "Are you sure?",
					text: "You will not be able to recover this after deletion.",
					type: "warning",
					showCancelButton: true,
					showLoaderOnConfirm: true
				}, () => {
					Website.delete(website).then(response => {
						toastr.success(response.data);
						this.websites.$remove(website);
					});
				});
			},

			saveWebsite() {
				this.$broadcast('form:submit', 'website')
			},
		},

		events: {
			'website:created'(website) {
				this.websites.push(website);
			}
		}
		
	}
</script>
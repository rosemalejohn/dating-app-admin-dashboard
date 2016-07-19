<template>
	<img onclick="document.getElementById('photo').click()" class="thumbnail img-holder" :src="photo" />
    <input @change="selectPhoto" class="hide" id="photo" type="file" />
</template>

<style lang="sass">
	.img-holder {
		width: 100%;
		cursor: pointer;
	}
</style>

<script>
	export default {

		props: {
			photo: {
				type: String,
				twoWay: true,
				default: '/img/default-photo.png'
			}
		},

		methods: {
			selectPhoto(event) {
				let self = this;
				var input = event.target;
				var acceptedType = /^image\//;

                if (input.files && input.files[0]) {
                	var photo = input.files[0];
                	if (acceptedType.test(photo.type)) {
                		var reader = new FileReader();

	                    reader.onload = e => {
	                        self.photo = e.target.result;
	                    }

	                    reader.readAsDataURL(input.files[0]);
	                    toastr.success('Photo set!');
                	} else {
                		toastr.error('File not allowed!');
                	}
                    
                }
			}
		}

	}
</script>
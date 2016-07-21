<template></template>

<script>
	export default {

		props: {
			paginator: {
				type: Object,
				default() {
					return {}
				},
				twoWay: true,
				required: false
			}
		}

	}
</script>
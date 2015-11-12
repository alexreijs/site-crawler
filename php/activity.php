<div id="activityContainer" class="table-responsive">
</div>

<script>

function getActivity() {
	$.ajax({
		url: 'activity_get.php',
		type: 'GET',
		success: function(data) {
			//called when successful
			//alert(data);
			$('#activityContainer').html(data);
		},
		error: function(e) {
			//called when there is an error
			//console.log(e.message);
		}
	});
}

getActivity();
window.setInterval(getActivity, 5000);

</script>


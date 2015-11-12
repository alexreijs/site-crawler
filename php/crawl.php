<form action="index.php" method="post">

	<input type="hidden" name="action" value="activity">

	<div class="form-group">
		<label for="inputURL">URL</label>
		<input name="url" type="input" class="form-control" id="inputURL" placeholder="URL">
	</div>

	<div class="checkbox">
		<label>
			<input name="screenshots" type="checkbox" id="inputScreenshots"> Take screenshots
		</label>
	</div>

        <div class="checkbox">
                <label>
                        <input name="cookies" type="checkbox" id="inputCookies"> Store cookies
                </label>
        </div>

        <div class="checkbox">
                <label>
                        <input name="resources" type="checkbox" id="inputResources"> Track resources (i.e. images and scripts)
                </label>
        </div>

        <div class="checkbox">
                <label>
                        <input name="errors" type="checkbox" id="inputErrors"> Track javascript errors
                </label>
        </div>

	<button type="submit" class="btn btn-default">Submit</button>

</form>


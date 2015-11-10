<form action="index.php" method="post">

	<input type="hidden" name="action" value="activity">

	<div class="form-group">
		<label for="inputURLs">URLs</label>
		<input name="urls" type="input" class="form-control" id="inputURLs" placeholder="URLs (comma seperated)">
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

	<button type="submit" class="btn btn-default">Submit</button>

</form>


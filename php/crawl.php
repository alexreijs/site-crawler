<form action="index.php" method="post">

	<input type="hidden" name="action" value="jobs">

	<div class="form-group">
		<label for="inputURL">URL (1 per line)</label>
		<textarea rows="5" name="url" class="form-control" id="inputURL" placeholder="URL"></textarea>
	</div>

	<div class="checkbox">
		<label>
			<input name="cookie_consent" type="checkbox" id="inputCookieConsent"> Give Sanoma cookie consent
		</label>
	</div>

	<div class="checkbox">
		<label>
			<input name="deeplinks" type="checkbox" id="inputDeeplinks"> Also crawl all links on page (1 level deep, max 10)
		</label>
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
                        <input name="libraries" type="checkbox" id="inputLibraries"> Scan javascript libraries
                </label>
        </div>
		
        <div class="checkbox">
                <label>
                        <input name="errors" type="checkbox" id="inputErrors"> Track javascript errors
                </label>
        </div>

	<button type="submit" class="btn btn-default">Submit</button>

</form>


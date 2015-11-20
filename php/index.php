<?php

require_once(dirname(__FILE__) . '/includes/config.php');

$data = $database->select('jobs', 'id');

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sanoma - Site-Crawler</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    
    <!-- Custom styles for this template -->
    <link href="./css/jumbotron-narrow.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


    <div class="container">

      <?php require_once('./includes/postfields.php'); ?>

      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"<?php if ($_SESSION['action'] == 'home') echo ' class="active"';?>><a href="index.php?action=home">Home</a></li>
            <li role="presentation"<?php if ($_SESSION['action'] == 'crawl') echo ' class="active"';?>><a href="index.php?action=crawl">Crawl</a></li>
            <li role="presentation"<?php if ($_SESSION['action'] == 'jobs') echo ' class="active"';?>><a href="index.php?action=jobs">Jobs</a></li>
            <li role="presentation"<?php if ($_SESSION['action'] == 'about') echo ' class="active"';?>><a href="index.php?action=about">About</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Site-Crawler</h3>
      </div>



	<?php

	switch($_SESSION['action']) {
		case 'crawl'	: require_once('crawl.php'); 
				break;
		case 'jobs'	: require_once('jobs.php');
				break;
		default		: require_once('home.php');
				break;
	}

	?>


      <footer class="footer">
        <p>&copy; Sanoma 2015 - Alexander Reijs &lt;alexander.reijs@sanoma.com&gt;</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


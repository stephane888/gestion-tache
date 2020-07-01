<?php
use Stephane888\Authen\Config\Init;
use Stephane888\Authen\Auth\Connect;

$ROOT = ROOT_WBU;
$Connect = new Connect();
$ConnextionStatus = $Connect->IsLogin();
/**
 * load page
 *
 * @var array $page
 */
$page = $Connect->LoadCurrentPage();

/**
 * Utile pour les pages de redirections.
 */
if (! empty($page['no_headers'])) {
  include_once getenv("DOCUMENT_ROOT") . $page['URI'];
  exit();
}

/**
 * Build css
 */
if (isset($_GET['build']) && $_GET['build'] == 'scss') {
  Init::_load_scss();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="32x32"
	href="//cdn.shopify.com/s/files/1/0013/2123/8594/t/5/assets/favicon-32x32.png?1823137142525308715">
<!-- Google font Roboto -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400"
	rel="stylesheet">
<title><?php

echo $Connect->getTitlePage()?></title>
<!-- Jquery-ui -->
<link
	href="<?php
echo $ROOT . '/';
?>plugin/jquery-ui/jquery-ui.min.css"
	rel="stylesheet">
<link
	href="<?php

echo $ROOT . '/';
?>plugin/jquery-ui/jquery-ui.theme.css"
	rel="stylesheet">
<!-- Bootstrap core CSS -->
<link
	href="<?php

echo $ROOT . '/';
?>plugin/bootstrap-4.1.1/dist/css/bootstrap.min.css"
	rel="stylesheet">
<!-- Font Awesome  -->
<!-- Our project just needs Font Awesome Solid[fas fa-user] + Brands[fab fa-github-square] + regular[far fa-calendar-alt] -->
<link
	href="<?php

echo $ROOT . '/';
?>plugin/fontawesome-free-5.6.3-web/css/fontawesome.min.css"
	rel="stylesheet">
<link
	href="<?php

echo $ROOT . '/';
?>plugin/fontawesome-free-5.6.3-web/css/brands.min.css"
	rel="stylesheet">
<link
	href="<?php

echo $ROOT . '/';
?>plugin/fontawesome-free-5.6.3-web/css/solid.min.css"
	rel="stylesheet">
<link
	href="<?php

echo $ROOT . '/';
?>plugin/fontawesome-free-5.6.3-web/css/regular.min.css"
	rel="stylesheet">
<!-- Custom styles for this template -->

<link href="/AppAuth/Ressources/css/style.css" rel="stylesheet">
<!-- Jquery -->
<script src="<?php

echo $ROOT . '/';
?>js/jquery.min.js"></script>
<script src="/plugin/ckeditor/ckeditor.js"></script>

<!-- vuejs -->
<script src="<?php

echo $ROOT . '/';
?>js/vuejs/vue.js"></script>

<script src="/vendor/stephane888/componnets-vuejs/js/axios.min.js"></script>


<!-- Chart -->
<script src="<?php

echo $ROOT . '/';
?>plugin/chart/chart.min.js"></script>
<!-- vue-Chart -->
<script src="<?php

echo $ROOT . '/';
?>plugin/chart/vue-chartjs.min.js"></script>

</head>
<body data-root="<?php
echo $ROOT;
?>" data-fullRoot="<?php

echo FULLROOT_WBU?>">
<?php

if ($ConnextionStatus) :
  ?>

    <?php

  if ($page) :
    include_once getenv("DOCUMENT_ROOT") . $page['URI'];
  else :
    ?>
    <div class="container">
    	<ul class="nav p-5">
    		<li class="nav-item"><a class="nav-link" href="/?page=nutribe">Tache Nutribe</a></li>
    		<li class="nav-item"><a class="nav-link" href="/?page=ongola-market">Ongola-market</a></li>
    		<li class="nav-item"><a class="nav-link" href="/?page=gestion-tache">Gestion de taches</a></li>
    		<li class="nav-item"><a class="nav-link" href="/?page=logout">Logout</a></li>
    	</ul>
  	</div>
  	<?php
  endif;
  ?>

	<!-- include default template -->
    <?php

  ?>
<?php

else :
  ?>
	<?php
  include_once getenv("DOCUMENT_ROOT") . '/App/Ressources/Login.php';
  ?>
<?php

endif;
?>

    <!-- Jquery-ui -->
	<script
		src="<?php

  echo $ROOT . '/';
  ?>plugin/jquery-ui/jquery-ui.min.js"></script>
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="<?php

  echo $ROOT . '/';
  ?>plugin/bootstrap-4.1.1/assets/js/vendor/popper.min.js"></script>
	<script
		src="<?php

  echo $ROOT . '/';
  ?>plugin/bootstrap-4.1.1/dist/js/bootstrap.min.js"></script>

</body>
</html>

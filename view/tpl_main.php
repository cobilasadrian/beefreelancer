<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="UTF-8">
	<title><?=$title?></title>

	<!-- Bootstrap -->
	<link href="view/css/bootstrap.min.css" rel="stylesheet">
	<!-- Icons fontawesome-->
	<link href="view/css/font-awesome.css" rel="stylesheet">
	<!-- Styles -->
	<link href="view/css/styles.css" rel="stylesheet">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="view/js/bootstrap.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php if($scripts !=null): ?>
		<!-- Scripts -->
		<?php foreach($scripts as $script): ?>
			<script src="scripts/<?=$script?>"></script>
		<?php endforeach ?>
	<?php endif ?>
</head>
<body>
<div class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php"><img src="images/logo.png"></a>
			<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#navbar-btn-collapse">
				<span class="sr-only">Deschide navigarea</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="navbar-btn-collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php?c=projects">Proiecte</a></li>
				<?php if($user != null and $user['idRole'] == 2): ?>
				<li><a href="index.php?c=newProject">Publica un proiect</a></li>
				<?php endif ?>
				<li><a href="#">Freelanceri</a></li>
			</ul>
			<?php if($user != null): ?>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
				<li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?=$user["email"]?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profilul meu</a></li>
						<li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> Setari</a></li>
						<li class="divider"></li>
						<li class="active">
							<form method="post">
								<button type="submit" name="logout" class="logout-btn">
									<i class="fa fa-sign-out" aria-hidden="true"></i> Iesire
								</button>
							</form>
						</li>
					</ul>
				</li>
			</ul>
			<?php else: ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Logare <span class="caret"></span>
					</a>
					<ul id="dropdown-menu-login" class="dropdown-menu">
						<li>
							<p>Completeaza urmatoarele cimpuri:</p>
							<form class="form" method="post" accept-charset="UTF-8">
								<div class="form-group">
									<input type="email" name="email" class="form-control"  placeholder="Email address" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Password" required>
									<div class="help-block text-right"><a href="">Ai uitat parola?</a></div>
								</div>
								<div class="form-group">
									<button type="submit" name="login" class="btn btn-success btn-block"><i class="fa fa-sign-in"></i> Intra</button>
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> tine-ma minte
									</label>
								</div>
							</form>
							<li class="divider"></li>
							<p class="text-center">
								Nu ești înregistrat? <a href="index.php?c=reg"><b>Alatura-te</b></a>
							</p>
						</li>
					</ul>
				</li>
			</ul>
			<?php endif ?>
		</div>
	</div>
</div>
<?=$content?>
<footer>
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6">
					<div class="first-block">
						<div class="footer-logo">
							<a href="#"><img src="images/logo.png"></a>
						</div>
						<div class="description">
							<p>O comunitate de <b>specialisti independenti</b> disponibili de a lucra pentru tine la un click distanta.</p>
							<p><i class="fa fa-copyright" aria-hidden="true"></i> <b>Beefreelancer.com</b></p>
						</div>
						<div class="social-networks">
							<a href="#">
								<i class="fa fa-facebook-square"></i>
							</a>
							<a href="#">
								<i class="fa fa-twitter-square"></i>
							</a>
							<a href="#">
								<i class="fa fa-youtube-square"></i>
							</a>
							<a href="#">
								<i class="fa fa-odnoklassniki-square"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2">
					<div class="second-block">
						<ul>
							<li class="title">Compania</li>
							<li><a href="#">Despre noi</a></li>
							<li><a href="#">Suport</a></li>
							<li><a href="#">Contacte</a></li>
							<li><a href="#">Clienti</a></li>
							<li><a href="#">Reguli</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					<div class="third-block">
						<ul>
							<li class="title">Catalog de freelanceri</li>
							<?php foreach($categories as $category):?>
							<li><a href="index.php?c=category&idCategory=<?=$category['idCategory']?>"><?=$category['name']?> (<?=$category['users']?>)</a></li>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
</body>
</html>
<?php include("_head.tpl.php"); ?>


	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
			  data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li id="home"><a href="index.php?aktion=allesAnzeigen">Home <span class="sr-only">(current)</span></a></li>
					<li id="neu"><a href="index.php?aktion=anlegen">Neuer Eintrag <span class="sr-only">(current)</span></a></li>
					<!-- <li id="frontend"><a target="_blank" href="../index.php?aktion=alleAnzeigen">Frontend <span class="sr-only">(current)</span></a></li> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php if(!isset($_SESSION['benutzer'])){?>
					<li id="login"><a href="index.php?aktion=login">Login</a></li>
				<?php } else { ?>
					<li> <a>Sie sind eingeloggt als: <?php echo $_SESSION['benutzer']; ?></a></li>
					<li id="ausloggen"><a href="index.php?logout">Ausloggen</a></li>
				<?php } 
				?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	
<?php include("_footer.tpl.php"); ?>
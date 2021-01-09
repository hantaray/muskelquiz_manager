<?php include("_head.tpl.php"); ?>

<?php
session_start();
session_destroy();
$_SESSION = array();
?>

<div class="container">
	<?php include "nav.tpl.php"; ?>
		<div class="row">
			<form method="POST" action="index.php?aktion=allesAnzeigen">
				<div class="col-md-6">
					<div class="form-group">
						<label for="benutzer">Benutzer</label>
						<input class="form-control" type="text" name="benutzer" id="benutzer" placeholder="Benutzername" ></input>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label for="passwort">Passwort</label>
						<input class="form-control" type="password" name="passwort" id="passwort" placeholder="Passwort" ></input>
					</div>
				</div>
				
				<div class="col-md-12">
					<button class="btn btn-primary" name="login" type="submit">Login</button>
				</div>
			</form>
		</div>
</div>
	
<script >
	// Navigationselement aktivieren
	document.getElementById("login").className = "active";
</script>

<?php include("_footer.tpl.php"); ?>

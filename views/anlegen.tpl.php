<?php include("_head.tpl.php"); ?>

<div class="row">
	<div class="col-md-12">
		<?php include "views/nav.tpl.php"; ?>
		<form id="anlegenFom" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

			<div><label for=" kategorie">Kategorie</label></div>
			<div style="width: 50%; margin:0 0 15px 0" class="btn-group btn-group-justified" data-toggle="buttons">
				<label class="btn btn-primary">
					<input type="radio" name="kategorie" value="1"> Obere Extremitäten
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="kategorie" value="2"> Untere Extremitäten
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="kategorie" value="3"> Rumpf
				</label>
				<label class="btn btn-primary">
					<input type="radio" name="kategorie" value="4"> Kopf
				</label>
			</div>
			<script type="text/javascript">
				$('.btn-group > .btn').on("click", function(btn) {
					var kategorieInt = btn.target.control.value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("reihenfolge").value = this.response.nextReihenfolgeInt;
						}
					};
					xhttp.open("GET", "http://muskelabcd.bplaced.net/physio_united/api/getNextReihenfolgeIntByKategorie.php?kategorie=" + kategorieInt, true);
					xhttp.responseType = 'json';
					xhttp.send();
				});
			</script>


			<div class="form-group">
				<label for="reihenfolge">Reihenfolge</label>
				<input type="number" min="1" name="reihenfolge" id="reihenfolge" class="form-control" placeholder="Id für Anzeige-Reihenfolge eingeben" required>
			</div>

			<script>
				var reihenfolge = document.getElementById("reihenfolge")
				var reihenfolge = document.getElementById("reihenfolge")
				reihenfolge.onchange = function() {
					var kategorieGroup = document.getElementById("kategorie")
					var selectedKategorie = 1;

					for (i = 0; i < kategorieGroup.childElementCount; i++) {
						if (kategorieGroup.children[i].classList.contains('active')) {
							selectedKategorie = kategorieGroup.children[i].children[0].value;
						}
					}
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4) {
							if (this.status == 200) {
								console.log(this);
								if (!confirm("Die Reihenfolge-Id existiert bereits! Wollen Sie die bestehende Reihenfolge neu ordnen?")) {
									var xhttp = new XMLHttpRequest();
									xhttp.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
											document.getElementById("reihenfolge").value = this.response.nextReihenfolgeInt;
										}
									};
									xhttp.open("GET", "http://muskelabcd.bplaced.net/physio_united/api/getNextReihenfolgeIntByKategorie.php?kategorie=" + selectedKategorie, true);
									xhttp.responseType = 'json';
									xhttp.send();
								}
							} else {
								var xhttp = new XMLHttpRequest();
								xhttp.onreadystatechange = function() {
									if (this.readyState == 4 && this.status == 200) {
										if (this.response.nextReihenfolgeInt != document.getElementById("reihenfolge").value) {
											alert("Achtung! Die gewählte Reihenfolge-Nummer erzeugt eine Lücke in der Durchnummerierung! Die nächste freie Reihenfolge-Nummer ist die " + this.response.nextReihenfolgeInt + "!")
											document.getElementById("reihenfolge").value = this.response.nextReihenfolgeInt;
										}
									}
								};
								xhttp.open("GET", "http://muskelabcd.bplaced.net/physio_united/api/getNextReihenfolgeIntByKategorie.php?kategorie=" + selectedKategorie, true);
								xhttp.responseType = 'json';
								xhttp.send();
							}
						};
					}
					xhttp.open("GET", "http://muskelabcd.bplaced.net/physio_united/api/checkExistingReihenfolge.php?kategorie=" + 1 + "&reihenfolge=" + reihenfolge.value, true);
					xhttp.responseType = 'json';
					xhttp.send();

				}
			</script>

			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control" placeholder="Name eingeben" required>
			</div>

			<div class="form-group">
				<label for="innervation">Innervation</label>
				<textarea class="form-control" name="innervation" placeholder="Innervation eingeben" required></textarea>
			</div>

			<div class="form-group">
				<label for="ursprung">Ursprung</label>
				<textarea class="form-control" name="ursprung" placeholder="Ursprung eingeben" required></textarea>
			</div>

			<div class="form-group">
				<label for="ansatz">Ansatz</label>
				<textarea class="form-control" name="ansatz" placeholder="Ansatz eingeben" required></textarea>
			</div>

			<div class="form-group">
				<?php if (isset($fehler)) : ?>
					<?php foreach ($fehler as $fehl) : ?>
						<div class="bg-danger text-danger"><?php echo $fehl; ?></div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<script>
				function validateForm() {
					var formIsValid = false;
					var reihenfolgeExists = false;
					// var kategorieInt = btn.target.control.value;
					var reihenfolge = document.getElementById("reihenfolge").value;
					// var selectedReihenfolgeInt = document.getElementById("reihenfolge").value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						document.getElementById("anlegenFom").onsubmit = function() {

							return false;
						}
						if (this.readyState == 4) {
							console.log("ready");
							if (this.status == 200) {
								console.log("ok");
								console.log(this.response);
								// if (this.response) {
								if (confirm("Die Reihenfolge-Id existiert bereits! Wollen Sie die bestehende Reihenfolge neu ordnen?")) {
									// Todo: beim speichern reihenfolge neu ordnen
									console.log("confirm");
									reihenfolgeExists = true;
									document.getElementById("anlegenFom").submit();

								}
							} else {
								console.log("not found");
								document.getElementById("anlegenFom").submit();
							}


						};
					}
					xhttp.open("GET", "http://muskelabcd.bplaced.net/physio_united/api/checkExistingReihenfolge.php?kategorie=" + 1 + "&reihenfolge=" + reihenfolge, true);
					xhttp.responseType = 'json';
					xhttp.send();

					// var x = document.forms["anlegenFom"]["name"].value;
					// if (x == "") {
					// 	alert("Name must be filled out");
					// 	return false;
					// }
					// var kategorieSelected = false;

					// var ele = document.querySelectorAll(".btn-group > .btn");
					// for (var i = 0; i < ele.length; i++) {
					// 	console.log(this.inneHTML);
					// 	if (this.checked) {
					// 		kategorieSelected = true;
					// 	}
					// 	if (!kategorieSelected) {
					// 		alert("Bitte wählen Sie eine Kategorie");
					// 		return false;
					// 	}
					// }
				}
			</script>

			<div class="form-group">
				<button class="btn btn-success" name="speichern">
					Speichern <span class=" glyphicon glyphicon-floppy-disk"></span>
				</button>
				<a href="index.php" <button type="button" class="btn btn-success" name="abbruch">
					Abbruch</a>
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	// Navigationselement aktivieren
	document.getElementById("neu").className = "active";
</script>

<?php include("_footer.tpl.php");

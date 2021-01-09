<?php include("_head.tpl.php"); ?>

<div class="row">
	<?php include "views/nav.tpl.php"; ?>
	<div class="col-md-12">
		<?php foreach ($muskel as $einMuskel) { ?>

			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
				<div><label for="kategorie">Kategorie</label></div>
				<div id="kategorie" style="width: 50%; margin:0 0 15px 0" class="btn-group btn-group-justified" data-toggle="buttons">
					<label class="btn btn-primary disabled">
						<input type="radio" name="kategorie" value="1"> Obere Extremitäten
					</label>
					<label class="btn btn-primary disabled">
						<input type="radio" name="kategorie" value="2"> Untere Extremitäten
					</label>
					<label class="btn btn-primary disabled">
						<input type="radio" name="kategorie" value="3"> Rumpf
					</label>
					<label class="btn btn-primary disabled">
						<input type="radio" name="kategorie" value="4"> Kopf
					</label>
				</div>
				<script type="text/javascript">
					$('.btn-group > .btn').eq(<?php echo $einMuskel->getKategorie() - 1; ?>).addClass('active')

					$('.btn-group > .btn').on("click", function(btn) {
						alert("Das Ändern der Kategorie ist nicht möglich! Bitte legen Sie dazu einen neuen Eintrag mit der entsprechenden Kategorie an.");
					});
				</script>

				<div class="form-group">
					<label for="reihenfolge">Reihenfolge</label>
					<input type="text" min="1" value="<?php echo $einMuskel->getReihenfolge(); ?>" name="reihenfolge" placeholder="Id für Anzeige-Reihenfolge eingeben" id="reihenfolge" class="form-control" required>
				</div>

				<script>
					reihenfolge.onchange = function() {
						var reihenfolge = document.getElementById("reihenfolge")
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
									if (!confirm("Die Reihenfolge-Id existiert bereits! Wollen Sie die bestehende Reihenfolge neu ordnen?")) {
										// Get next reihenfolge-Id and set value
										var xhttp = new XMLHttpRequest();
										xhttp.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												document.getElementById("reihenfolge").value = this.response.nextReihenfolgeInt;
											}
										};
										xhttp.open("GET", "http://hasashi.bplaced.net/physio_united/api/getNextReihenfolgeIntByKategorie.php?kategorie=" + selectedKategorie, true);
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
									xhttp.open("GET", "http://hasashi.bplaced.net/physio_united/api/getNextReihenfolgeIntByKategorie.php?kategorie=" + selectedKategorie, true);
									xhttp.responseType = 'json';
									xhttp.send();
								}
							};
						}
						xhttp.open("GET", "http://hasashi.bplaced.net/physio_united/api/checkExistingReihenfolge.php?kategorie=" + 1 + "&reihenfolge=" + reihenfolge.value, true);
						xhttp.responseType = 'json';
						xhttp.send();

					}
				</script>

				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" value="<?php echo $einMuskel->getName(); ?>" name="name" placeholder="Name eingeben" id="name" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="innervation">Innervation</label>
					<textarea class="form-control" rows="5" name="innervation" placeholder="Innervation eingeben" required><?php echo $einMuskel->getInnervation(); ?></textarea>
				</div>

				<div class="form-group">
					<label for="ursprung">Ursprung</label>
					<textarea class="form-control" rows="5" name="ursprung" placeholder="Ursprung eingeben" required><?php echo $einMuskel->getUrsprung(); ?></textarea>
				</div>

				<div class="form-group">
					<label for="ansatz">Ansatz</label>
					<textarea class="form-control" rows="5" name="ansatz" placeholder="Ansatz eingeben" required><?php echo $einMuskel->getAnsatz(); ?></textarea>
				</div>

				<div class="form-group">
					<?php if (isset($fehler)) : ?>
						<?php foreach ($fehler as $fehl) : ?>
							<div class="bg-danger text-danger"><?php echo $fehl; ?></div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<div class="form-group">
					<button class="btn btn-success" name="speichern">
						Aktualisieren <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
					</button>
					<a href="index.php" <button type="button" class="btn btn-success" name="abbruch">
						Abbruch</a>
					</button>
					<button type="button" onclick="loescheEintrag(<?php echo $_REQUEST['id']; ?>)" class="btn btn-danger" name="loeschen">
						Eintrag löschen <span class="glyphicon glyphicon-remove"></span>
					</button>
				</div>
			</form>
		<?php } ?>
	</div>
</div>
<?php include("_footer.tpl.php");

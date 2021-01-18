<?php
include("_head.tpl.php"); ?>

<div class="row">
	<?php include "nav.tpl.php"; ?>
	<div class="col-md-12">
		<table class="table table-hover sortable-table">
			<thead>
				<tr>
					<th class="numeric-sort">Kategorie</th>
					<th>Reihenfolge</th>
					<th>Name</th>
					<th>Innervation</th>
					<th>Ursprung</th>
					<th>Ansatz</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($muskeln as $muskel) { ?>
					<tr>
						<td><?php echo $muskel->getKategorie(); ?></td>
						<td><?php echo $muskel->getReihenfolge(); ?></td>
						<td><?php echo $muskel->getName(); ?></td>
						<td><?php echo $muskel->getInnervation(); ?></td>
						<td><?php echo $muskel->getUrsprung(); ?></td>
						<td><?php echo $muskel->getAnsatz(); ?></td>

						<td class="text-center">
							<button onclick="javascript:location.href='index.php?aktion=bearbeiten&id=<?php echo $muskel->getId(); ?>'" </button>Eintrag bearbeiten</button> </td> <td class="text-center">
								<button type="button" onclick="loescheEintrag(<?php echo $muskel->getId(); ?>)" name="loeschen">
									Eintrag löschen</button></td>
					</tr>
				<?php } ?>
			</tbody>

			<tfoot>
				<tr>
					<td colspan="5"></td>
				</tr>
			</tfoot>

		</table>
	</div>
</div>
<button onclick="javascript:location.href='index.php?aktion=anlegen'" </button>Neuer Eintrag </button> <script>
	// Navigationselement aktivieren
	document.getElementById("home").className = "active";
	</script>

	<?php include("_footer.tpl.php"); ?>
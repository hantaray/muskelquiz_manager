function loescheEintrag(id) {
	if (confirm("Wollen Sie den Eintrag wirklich löschen?")) {
		window.location.href = "index.php?aktion=delete&id=" + id;
	}
}

function reihenfolgeChange() {
	console.log("reihenfolgeChange");

	// check if the reihenfolgeInt is already set
	// if set show warning
	// if warning ok set new order on save!!

}
function loescheEintrag(id) {
	if (confirm("Wollen Sie den Eintrag wirklich löschen?")) {
		window.location.href = "index.php?aktion=delete&id=" + id;
	}
}
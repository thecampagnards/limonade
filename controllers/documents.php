<?php
require('modeles/documents.php');

function documents_controller(){
	//si post
	if(!empty($_POST)) {

  		if($_POST['action'] == 'edit') $SUCCESS = editDocument($_POST['id'], $_POST['rang'], $_POST['promo'], $_POST['libelle'], $_FILES['fichier']);
  		elseif($_POST['action'] == 'add') $SUCCESS = addDocument($_POST['rang'], $_POST['promo'], $_POST['libelle'], $_FILES['fichier']);
  		elseif($_POST['action'] == 'delete') $SUCCESS = deleteDocument($_POST['id']);
	}

	$documents = getDocuments();
	set("title", "Documents");
	set("subtitle", 'Il y a '.count($documents).' document(s)');
	set("documents", $documents);
	set("SUCCESS", $SUCCESS);

	return html('documents.html.php','layout/default_layout.html.php');
}
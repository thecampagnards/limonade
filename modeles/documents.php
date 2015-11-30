<?php

//fonction pour récupérer les documents
function getDocuments() {
	$bdd = connectDB();
	$sql = 'SELECT * FROM document ORDER BY rang';
	$res = $bdd->prepare($sql);
	$res->execute();
	return $res->fetchAll(PDO::FETCH_ASSOC);
}

//fonction pour editer un document
function editDocument($id, $rang, $promo, $libelle, $fichier) {
	$bdd = connectDB();

	$sql = 'UPDATE document SET
	id = :id,
	rang = :rang,
	libelle = :libelle,
	fichier = :fichier
	WHERE id = :id';

	$stmt = $bdd->prepare($sql);

	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':rang', $rang, PDO::PARAM_INT);
	$stmt->bindParam(':promo', $promo, PDO::PARAM_STR);
	$stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
	$stmt->bindParam(':fichier', $fichier['name'], PDO::PARAM_STR);

	if($stmt->execute() or die(var_dump($stmt->ErrorInfo()))) {
		return true;
	}
	return false;
}

//fonction pour ajouter un document
function addDocument($rang, $promo, $libelle, $fichier) {
	$bdd = connectDB();

	$sql = 'INSERT INTO document SET
	rang = :rang,
	promo = :promo,
	libelle = :libelle,
	fichier = :fichier';

	$stmt = $bdd->prepare($sql);

	if(checkPromotion($promo) == 1){
		$fichier_db = 'A12/'.$fichier['name'];
	}else if(checkPromotion($promo) == 2){
		$fichier_db = 'A345/'.$fichier['name'];
	}else{
		$fichier_db = $fichier['name'];
	}

	$stmt->bindParam(':rang', $rang, PDO::PARAM_INT);
	$stmt->bindParam(':promo', $promo, PDO::PARAM_STR);
	$stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);
	$stmt->bindParam(':fichier', $fichier_db, PDO::PARAM_STR);

	if($stmt->execute() or die(var_dump($stmt->ErrorInfo()))) {
		return true;
	}
	return false;
}

//fonction pour supprimer un document
function deleteDocument($id) {
	$bdd = connectDB();

	$sql = 'DELETE FROM document WHERE id = :id';
	$stmt = $bdd->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);

	if($stmt->execute() or die(var_dump($stmt->ErrorInfo()))) {
		return true;
	}
	return false;
}
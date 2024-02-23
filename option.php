<?php
// Informations de connexion à la base de données
$serveur = "localhost"; // Adresse du serveur de base de données
$utilisateur = "root"; // Nom d'utilisateur de la base de données
$mot_de_passe = ""; // Mot de passe de la base de données

// Connexion à la base de données "information_schema" pour récupérer la liste des bases de données
$connexion_info_schema = new mysqli($serveur, $utilisateur, $mot_de_passe, 'information_schema');

// Vérifier la connexion
if ($connexion_info_schema->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion_info_schema->connect_error);
}

// Récupérer la liste des bases de données
$resultat_bases_de_donnees = $connexion_info_schema->query("SHOW DATABASES");

// Récupérer la base de données sélectionnée lors de la soumission du formulaire
$selected_database = isset($_POST['database']) ? $_POST['database'] : '';

// Afficher les options de la liste déroulante
while ($row = $resultat_bases_de_donnees->fetch_assoc()) {
    $database_name = $row['Database'];
    $selected = ($database_name === $selected_database) ? 'selected' : '';
    echo "<option value=\"$database_name\" $selected>$database_name</option>";
}

// Fermer la connexion à la base de données "information_schema"
$connexion_info_schema->close();
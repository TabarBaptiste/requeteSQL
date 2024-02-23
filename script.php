<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si la requête SQL est vide
    if (!empty($_POST["requete"])) {
        // Informations de connexion à la base de données
        $serveur = "localhost"; // Adresse du serveur de base de données
        $utilisateur = "root"; // Nom d'utilisateur de la base de données
        $mot_de_passe = ""; // Mot de passe de la base de données

        // Récupérer la base de données sélectionnée
        $base_de_donnees = $_POST["database"];

        // Connexion à la base de données
        $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }

        // Récupérer la requête SQL saisie par l'utilisateur
        $requete = $_POST["requete"];

        // Exécution de la requête avec gestion des exceptions
        try {
            $resultat = $connexion->query($requete);
            if ($resultat !== false) {
                // Ajouter la requête à l'historique avec la date et l'heure
                $requete = str_replace(array("\n", "\r"), ' ', $_POST["requete"]); // Remplace les sauts de ligne par un espace
                $historique = fopen("historique.txt", "a");
                fwrite($historique, $requete . " - " . date("d/m/Y H:i:s") . "\n");
                fclose($historique);

                // Afficher les résultats dans un tableau
                echo "<table class='table'><tr>";

                // Récupérer les noms des colonnes à partir du premier enregistrement
                $premier_enregistrement = $resultat->fetch_assoc();
                foreach ($premier_enregistrement as $nom_colonne => $valeur) {
                    echo "<th>" . htmlspecialchars($nom_colonne) . "</th>";
                }
                echo "</tr>";

                // Afficher les données
                $resultat->data_seek(0); // Remettre le pointeur sur le premier enregistrement
                while ($ligne = $resultat->fetch_assoc()) {
                    echo "<tr>";
                    // Afficher les valeurs de chaque colonne
                    foreach ($ligne as $valeur) {
                        if ($valeur === null) {
                            echo "<td class='vide'>null</td>"; // ou tout autre traitement que vous souhaitez
                        } else {
                            echo "<td>" . htmlspecialchars($valeur) . "</td>";
                        }
                    }
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Requête invalide</p>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "<p>Erreur lors de l'exécution de la requête : " . $e->getMessage() . "</p>";
        }

        // Fermer la connexion
        $connexion->close();
    } else {
        echo "<p>Veuillez entrer une requête SQL.</p>";
    }
}

// Gestion du bouton de vidage du fichier "historique.txt"
if (isset($_POST["vider_historique"])) {
    $historique = fopen("historique.txt", "w"); // Ouvre le fichier en mode écriture, supprimant le contenu existant
    fclose($historique);
}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la requête SQL</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="container">
        <h1>Résultats de la requête SQL</h1>

        <form class="req" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="selection">
                <label for="database">Sélectionnez la base de données :</label>
                <select name="database" id="database">
                    <?php
                    require_once 'option.php';
                    ?>
                </select><br>
            </div>
            <label for="requete">Entrez votre requête SQL :</label>
            <textarea id="requete" name="requete" rows="6" cols="50" class="textarea"></textarea><br>

            <input type="submit" value="Exécuter la requête" class="button">
        </form>

        <?php
        require_once 'script.php';
        ?>

        <br><button type="submit" onclick="afficherHistorique()">Historique</button>

        <div id="historique" style="display: none;">
            <h2>Historique des requêtes valides :</h2>
            <ul id="historiqueListe"></ul>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="vider_historique">
                <input type="submit" value="Vider l'historique">
            </form>
        </div>
    </div>
</body>

</html>

<script>
    // Fonction pour afficher l'historique des requêtes
    function afficherHistorique() {
        console.log("Je suis là")
        const historiqueDiv = document.getElementById('historique');
        const historiqueListe = document.getElementById('historiqueListe');
        historiqueListe.innerHTML = '';

        // Charger le contenu du fichier "historique.txt" avec AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const historiqueRequetes = xhr.responseText.split('\n');
                historiqueRequetes.forEach(requete => {
                    const li = document.createElement('li');
                    li.textContent = requete;
                    historiqueListe.appendChild(li);
                });

                // Afficher la fenêtre contextuelle
                historiqueDiv.style.display = 'block';
            }
        };
        xhr.open('GET', 'historique.txt', true);
        xhr.send();
    }
</script>
// Fonction pour afficher l'historique des requêtes
function afficherHistorique() {
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
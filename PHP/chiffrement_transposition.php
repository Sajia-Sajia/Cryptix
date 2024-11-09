<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chiffrement et déchiffrement par transposition</title>
  <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
  <link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <div class="form-group">
    <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
  </div>

  <div class="container">
    <h1>Chiffrement par transposition</h1>
    <form id="myForm" method="post">
    <div class="container">
      <p class="erreurCle"> </p>
      <p class="erreurChar"></p>
      <p class="erreurChiffre"> </p>
      <p class="erreurFrappe"></p>

      <div class="form-group">
        <label for="cle">La clé :</label>
        <input type="number" id="nombre" min="1" oninput="creerTableau()" placeholder="clé">
      </div>
      <div id="tableau-container"></div>
        <div class="form-group">
          <label for="texte">Texte en clair/chiffré :</label>
          <textarea name="texte" id="texte" placeholder="Entrez le texte en clair/chiffré"></textarea>
        </div>

        <button type="button" onclick="document.getElementById('number').value = chiffrer(document.getElementById('texte').value)">Chiffrer</button>
        <button type="button" onclick="document.getElementById('number').value = dechiffrer(document.getElementById('texte').value)">Déchiffrer</button>

        <div class="form-group">
          <label for="number"><br>Résultat :</label>
          <textarea id="number" name="resultat" readonly>

          </textarea>
        </div>

        <button type="button" onclick="resetForm()">Annuler</button>

      </div>

    </form>
  </div>
</body>
<script>
  let tableau = [];

  function creerTableau() {
    // Récupérer la valeur entrée par l'utilisateur
    const nombre = parseInt(document.getElementById('nombre').value, 10);

    // Vérifier si la valeur est valide
    if (isNaN(nombre) || nombre < 1) {
      // alert('Veuillez entrer un nombre valide (au moins 1).');
      // return;
    }

    // Créer le tableau à deux dimensions
    tableau = [];

    for (let i = 1; i <= nombre; i++) {
      tableau.push([i, '']);
    }

    // Afficher le tableau dans la page
    const tableauContainer = document.getElementById('tableau-container');
    tableauContainer.innerHTML = '';

    const table = document.createElement('table');
    const headerRow = document.createElement('tr');

    // Ajouter la première ligne avec les nombres ordonnés
    for (let i = 1; i <= nombre; i++) {
      const headerCell = document.createElement('th');
      headerCell.textContent = i;
      headerRow.appendChild(headerCell);
    }

    table.appendChild(headerRow);

    // Ajouter la deuxième ligne avec les champs d'entrée
    const inputRow = document.createElement('tr');

    for (let j = 0; j < nombre; j++) {
      const inputCell = document.createElement('td');
      const input = document.createElement('input');
      input.type = 'number';
      input.value = tableau[j][1];
      input.oninput = function() {
        // Mettre à jour la valeur dans le tableau lorsque l'utilisateur modifie l'input
        tableau[j][1] = input.value;
      };

      inputCell.appendChild(input);
      inputRow.appendChild(inputCell);
    }

    table.appendChild(inputRow);
    tableauContainer.appendChild(table);
  }

  function afficherTableauConsole() {
    for (let i = 0; i < tableau.length; i++) {
      console.log(`Ligne ${i + 1}: ${tableau[i].join(', ')}`);
    }
  }

  function chiffrer(chaine) {
     let cipher = "";
    // console.log(cipher);
    // Diviser la chaîne en blocs de la taille spécifiée
    const tailleBloc = tableau.length;
    const blocs = [];
    for (let i = 0; i < chaine.length; i += tailleBloc) {
      blocs.push(chaine.slice(i, i + tailleBloc));
    }

    // Désordonner chaque bloc en utilisant le tableau t
    const texteDechiffre = blocs.map(bloc => {
      const caracteresDechiffres = [];
      for (let i = 0; i < tailleBloc; i++) {
        const index = tableau[0][i] - 1; // -1 car les indices commencent à 0
        caracteresDechiffres.push(bloc[index]);
      }
      return caracteresDechiffres.join('');
    });
    for (let i = 0; i < tailleBloc; i++) {
      console.log(tableau[0][i]);
    }

    return cipher;
  }

  function dechiffrer(chaine) {
    // Diviser la chaîne en blocs de la taille spécifiée
    const tailleBloc = tableau.length;
    const blocs = [];
    for (let i = 0; i < chaine.length; i += tailleBloc) {
      blocs.push(chaine.slice(i, i + tailleBloc));
    }

    // Désordonner chaque bloc en utilisant le tableau t
    const texteDechiffre = blocs.map(bloc => {
      const caracteresDechiffres = [];
      for (let i = 0; i < tailleBloc; i++) {
        const index = tableau[0][i] - 1; // -1 car les indices commencent à 0
        caracteresDechiffres.push(bloc[index]);
      }
      return caracteresDechiffres.join('');
    });
    for (let i = 0; i < tailleBloc; i++) {
      console.log(tableau[0][i]);
    }

    return texteDechiffre.join('');
  }

  function goBack() {
    window.location.href = "../choix_algo.php";
  }
</script>

</html>
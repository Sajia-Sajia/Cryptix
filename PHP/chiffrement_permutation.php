	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
		<link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
		<title>Cryptix/permutation</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	</head>

	<body>
	<div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
		<div class="container">
			<h1>Chiffrement par permutation</h1>
			<div class="container">
			<form id="myForm" method="post" onsubmit="return false;">

				<p class="erreurChar1">Erreur: Vous devez entrer seulement les lettres de A/a jusqu'a Z/z !!! </p>
				<p class="erreurChar">Erreur: Un caractére de la chaine que vous avez entrer n'est pas présent dans la table de permutation !!! </p>
				<p class="erreurTableauVide">Erreur: Veuillez soit entrer soit générer automatiquement la clé (table de permutation) !!!</p>
				<p class="erreurTexte">Erreur: Vous devez entrer le texte !!!</p>
				<p class="erreurFrappe">Erreur: Vous devez entrer la clé et le texte !!!</p>

				<div class="form-group">
					<p>Choix de la table de permutation :</p>
					<button onclick="openPopup()">Entrez la table de permutation manuellement </button>
					<button onclick="genererTableauxAutomatiquement()">Générer la table de permutation automatiquement</button>

					<div id="popup" class="popup">
						<span class="close" onclick="closePopup()">&times;</span>
						<div class="table-container">
							<h2>Tableau Majuscules</h2>
							<table id="majTable">
							</table>
						</div>
					</div>
					<div id="tableauDiv">
					</div>
				</div>
				<div class="container">
					<div class="form-group">
						<label for="texte">Texte en clair/chiffré :</label>
						<textarea name="texte" id="texte" placeholder="Entrez le text en clair/chiffré" required></textarea>
					</div>

					<button type="button" onclick="chiffrer()">Chiffrer</button>
					<button type="button" onclick="dechiffrer()">Déchiffrer</button>

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
		var ln = false;

		function genererTableauPermutMaj() {
			lettresMajuscules = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			tableauPermutMaj = [];
			tableauPermutMaj.push(lettresMajuscules.split(''));
			lettresAleatoires = lettresMajuscules.split('').sort(function() {
				return 0.5 - Math.random();
			});
			tableauPermutMaj.push(lettresAleatoires);
			return tableauPermutMaj;
		}

		function afficherTableauPermutMaj(tableau) {
			let htmlContent = "<table border='1' id='tableauMaj'>";
			for (let i = 0; i < tableau.length; i++) {
				htmlContent += "<tr>";
				for (let j = 0; j < tableau[i].length; j++) {
					htmlContent += "<td>" + tableau[i][j] + "</td>";
				}
				htmlContent += "</tr>";
			}
			htmlContent += "</table>";
			document.getElementById("tableauDiv").innerHTML = htmlContent;
			tableauClef("tableauMaj");
		}

		function genererTableauxAutomatiquement() {
			tableauCle = [];
			document.querySelector('.erreurTableauVide').style.display = 'none';
			viderTable("majTable");
			document.getElementById("tableauDiv").style.display = "block";
			console.log("generation");
			tableauPermutMaj = genererTableauPermutMaj();
			afficherTableauPermutMaj(tableauPermutMaj);
		}
		var tableGenerated = false;

		function openPopup() {
			tableauCle = [];
			document.getElementById("tableauDiv").style.display = "none";
			var popup = document.getElementById("popup");
			popup.style.display = "block";
			console.log(tableGenerated);
			if (!tableGenerated) {
				generateTable("majTable", 'A'.charCodeAt(0), 'Z'.charCodeAt(0));
				tableGenerated = true;
			}
		}

		function closePopup() {
			var popup = document.getElementById("popup");
			popup.style.display = "none";
			if (ln == true)
				tableauClef("majTable");
		}

		function generateTable(tableId, start, end) {
			var table = document.getElementById(tableId);
			var row1 = table.insertRow(0);
			var row2 = table.insertRow(1);

			for (var i = start; i <= end; i++) {
				var cell1 = row1.insertCell(-1);
				var cell2 = row2.insertCell(-1);

				cell1.innerHTML = String.fromCharCode(i);
				cell2.innerHTML = '<div onclick="cellClick(this)"><input type="text" style="width: 28px;" onkeydown="updateTableCell(this, event)"></div>';
			}
		}

		function updateTableCell(input, event) {
			document.querySelector('.erreurTableauVide').style.display = 'none';
			if (input.value.trim() !== '') {
				document.getElementById("tableauDiv").style.display = "none";
				if (event.key === 'Enter') {
					input.parentElement.innerHTML = input.value;
					ln = true;
				}

			} else {
				if (event.key === 'Enter')
					document.getElementById("tableauDiv").style.display = "none";
			}
		}

		function cellClick(cell) {
			if (!cell.querySelector('input')) {
				var input = document.createElement('input');
				input.type = 'text';
				input.style.width = '28px';
				input.value = cell.textContent.trim();
				input.addEventListener('keydown', function(event) {
					updateTableCell(this, event);
				});

				cell.innerHTML = '';
				cell.appendChild(input);
				input.focus();
			}
		}

		function viderTable(tableId) {
			var table = document.getElementById(tableId);
			var rows = table.getElementsByTagName('tr');

			for (var i = 1; i < rows.length; i++) {
				var cells = rows[i].getElementsByTagName('td');

				for (var j = 0; j < cells.length; j++) {
					cells[j].innerHTML = '<div onclick="cellClick(this)"><input type="text" style="width: 28px;" onkeydown="updateTableCell(this, event)"></div>';
				}
			}
			ln = false;
		}


		var tableauCle = [];

		function tableauClef(id) {
			var tableauId = document.getElementById(id);
			tableauCle = [];
			for (let k = 0; k < tableauCle.length; k++) {
				tableauCle[k] = [];
			}
			for (var i = 0; i < tableauId.rows.length; i++) {
				var ligneId = tableauId.rows[i];
				var ligneCle = [];
				for (var j = 0; j < ligneId.cells.length; j++) {
					var celluleId = ligneId.cells[j];
					var inputElement = celluleId.querySelector('input');
					if (inputElement) {
						ligneCle.push(inputElement.value);
					} else {
						ligneCle.push(celluleId.textContent);
					}
				}
				tableauCle.push(ligneCle);
			}

			console.log(tableauCle[1][2]);
		}

		function chiffrer() {
			var texte = document.getElementById('texte').value.trim();
			document.querySelector('.erreurChar').style.display = 'none';
			document.querySelector('.erreurChar1').style.display = 'none';
			document.querySelector('.erreurTableauVide').style.display = 'none';
			document.querySelector('.erreurTexte').style.display = 'none';
			document.querySelector('.erreurFrappe').style.display = 'none';
			var resultat = '';
			if (texte == '' && tableauCle.length === 0) {
				document.querySelector('.erreurFrappe').style.display = 'block';
				return false;
			}
			if (texte == '') {
				document.querySelector('.erreurTexte').style.display = 'block';
				return false;
			}
			if (tableauCle.length === 0) {
				document.querySelector('.erreurTableauVide').style.display = 'block';
				return false;
			}
			for (i = 0; i < texte.length; i++) {

				maj = false;
				min = false;
				lettre = texte[i];
				code = lettre.charCodeAt(0);
				if (lettre == ' ')
					continue;
				if (code >= 65 && code <= 90) {
					maj = true;
				} else {
					if (code >= 97 && code <= 122) {
						min = true;
					} else {
						//resultat +=lettre;
						//continue;
						resultat = '';
						document.querySelector('.erreurChar1').style.display = 'block';
						document.getElementById('number').value = resultat;
						return false;
					}
				}
				lettre = lettre.toUpperCase();
				for (var j = 0; j < tableauCle[0].length; j++) {
					var char = tableauCle[0][j];
					if (char === lettre) {
						console.log(tableauCle[1][j]);
						if (tableauCle[1][j].trim() == '') {
							resultat = '';
							document.querySelector('.erreurChar').style.display = 'block';
							document.getElementById('number').value = resultat;
							return false;
						}
						console.log(maj);
						console.log(min);
						console.log(maj);

						if (maj == true) {
							output = tableauCle[1][j].toUpperCase();
						}
						if (min == true) {
							output = tableauCle[1][j].toLowerCase();
						}
						resultat += output;
						break;
					}

				}
			}

			document.getElementById('number').value = resultat;
			return true;
		}

		function dechiffrer() {
			var texte = document.getElementById('texte').value.trim();
			document.querySelector('.erreurChar').style.display = 'none';
			document.querySelector('.erreurChar1').style.display = 'none';
			document.querySelector('.erreurTableauVide').style.display = 'none';
			document.querySelector('.erreurTexte').style.display = 'none';
			document.querySelector('.erreurFrappe').style.display = 'none';
			var resultat = '';
			if (texte == '' && tableauCle.length === 0) {
				document.querySelector('.erreurFrappe').style.display = 'block';
				return false;
			}
			if (texte == '') {
				document.querySelector('.erreurTexte').style.display = 'block';
				return false;
			}
			if (tableauCle.length === 0) {
				document.querySelector('.erreurTableauVide').style.display = 'block';
				return false;
			}
			for (i = 0; i < texte.length; i++) {
				maj = false;
				min = false;
				lettre = texte[i];
				code = lettre.charCodeAt(0);
				if (lettre == ' ')
					continue;
				if (code >= 65 && code <= 90) {
					maj = true;
				} else {
					if (code >= 97 && code <= 122) {
						min = true;
					} else {
						//resultat +=lettre;
						//continue;
						resultat = '';
						document.querySelector('.erreurChar1').style.display = 'block';
						document.getElementById('number').value = resultat;
						return false;
					}
				}
				lettre = lettre.toUpperCase();
				lettreM = lettre.toLowerCase();
				for (var j = 0; j < tableauCle[1].length; j++) {
					var char = tableauCle[1][j];
					if (char === lettre || char === lettreM) {
						console.log(tableauCle[0][j]);
						if (maj == true) {
							output = tableauCle[0][j].toUpperCase();
						}
						if (min == true) {
							output = tableauCle[0][j].toLowerCase();
						}
						resultat += output;
						break;
					} else {
						if (j == tableauCle[1].length - 1) {
							resultat = '';
							document.querySelector('.erreurChar').style.display = 'block';
							document.getElementById('number').value = resultat;
							return false;
						}
					}

				}
			}

			document.getElementById('number').value = resultat;
			return true;
		}

		function resetForm() {
			document.getElementById("myForm").reset();
		}
		function goBack() {
        window.location.href = "../choix_algo.php";
    }
	</script>

	</html>
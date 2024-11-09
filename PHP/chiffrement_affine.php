 <!DOCTYPE html>
 <html lang="fr">

 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title>Cryptix/affine</title>
 	<link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
 	<link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 </head>

 <body>
 	<div class="form-group">
         <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
 	<div class="container"><h1>Chiffrement affine</h1>
 		<div class="container">
 		<form id="myForm" method="post" onsubmit="return false;">
 			<p class="erreurCle">Erreur: Vous devez entrer une clé qui est premier avec 26 !!! </p>
 			<p class="erreurChar">Erreur: Vous devez entrer seulement les lettres de A/a jusqu'a Z/z !!! </p>
 			<p class="erreurChiffre">Erreur: Vous devez entrer une clé entre 1 et 25 !!! </p>
 			<p class="erreurFrappe">Erreur: Vous devez entrer la clé et le texte !!!</p>

 			<div class="form-group">
 				<label for="cle">La clé :</label>
 				<input type="number" name="cle" id="cleA" placeholder="a" style="display: inline-block; width: auto;" />
 				<input type="number" name="cle" id="cleB" placeholder="b" style="display: inline-block; width: auto;" />
 			</div>
 				<div class="form-group">
 					<label for="texte">Texte en clair/chiffré :</label>
 					<textarea name="texte" id="texte" placeholder="Entrez le text en clair/chiffré"></textarea>
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
 	let tableauDeLettresMaj = [];
 	for (let i = 0; i < 26; i++) {
 		let code = i + 65;
 		let lettre = String.fromCharCode(code);
 		tableauDeLettresMaj.push(lettre);
 	}

 	let tableauDeLettresMin = [];
 	for (let i = 0; i < 26; i++) {
 		let code = i + 97;
 		let lettre = String.fromCharCode(code);
 		tableauDeLettresMin.push(lettre);
 	}

 	function pgcd(n, a) {
 		console.log("La fonction Pgcd");
 		if (n == 0) {
 			pgcdResult = a;
 		} else {
 			if (a == 0) {
 				pgcdResult = n;
 			} else {
 				r = n % a;
 				if (r == 0)
 					pgcdResult = a;
 				else {
 					do {
 						pgcdResult = r;
 						n = a;
 						a = r;
 						r = n % a;
 					} while (r != 0)
 				}
 			}
 		}
 		if (pgcdResult == 1)
 			return true;
 		else {
 			return false;
 		}
 	}

 	function Inverse(cle) {
 		for (i = 0; i < 26; i++) {
 			if (((cle * i) % 26) == 1) {
 				inverse = i;
 				break;
 			}
 		}
 		return inverse;
 	}

 	function chiffrer() {
 		var texte = document.getElementById('texte').value.replace(/\s+/g, "");
 		var a = parseInt(document.getElementById('cleA').value);
 		var b = parseInt(document.getElementById('cleB').value);
 		document.querySelector('.erreurCle').style.display = 'none';
 		document.querySelector('.erreurChar').style.display = 'none';
 		document.querySelector('.erreurChiffre').style.display = 'none';
 		document.querySelector('.erreurFrappe').style.display = 'none';
 		console.log("La fonction chiffrer");
 		if (texte.trim() === "" || isNaN(a) || isNaN(b) || (texte.trim() === "" && isNaN(a) && isNaN(b)) || (isNaN(a) && isNaN(b)) || (texte.trim() === "" && isNaN(b)) || (texte.trim() === "" && isNaN(b))) {
 			console.log("Erreur :un des champs est vide");
 			document.querySelector('.erreurFrappe').style.display = 'block';
 			return false;
 		}
 		if (b == 0) {
 			console.log("Redirection vers le chiffrement par multiplication");
 			chiffrerMultiplication(texte, a);
 			return true;
 		}
 		if (a == 1) {
 			console.log("Redirection vers le chiffrement de césar");
 			chiffrerCesar(texte, b);
 			return true;
 		}
 		strReturn = "";
 		if (pgcd(a, 26)) {
			console.log("Length :" + texte.length);
			 console.log("Texte: " + texte);
 			for (i = 0; i < texte.length; i++) {
				console.log("iteration no :"+i);
 				lettre = texte[i];
 				code = lettre.charCodeAt(0);
				console.log("Lettre :"+lettre);
				console.log("Code :"+code);
 				if (code >= 65 && code <= 90) {
 					let indice = tableauDeLettresMaj.indexOf(lettre);
 					newCode = ((indice * a) + b) % 26;
 					newLettre = tableauDeLettresMaj[newCode];
 					strReturn += newLettre;
 				} else {
 					if (code >= 97 && code <= 122) {
 						let indice = tableauDeLettresMin.indexOf(lettre);
 						newCode = ((indice * a) + b) % 26;
 						newLettre = tableauDeLettresMin[newCode];
 						strReturn += newLettre;
 					} else {
 						if (lettre == " ") {
 							continue;
 						} else {
 							//strReturn += str[i];
 							//continue;
 							strReturn = "";
 							console.log("La chaine contient un char spéciale");
 							document.querySelector('.erreurChar').style.display = 'block';
 							break;
 						}
 					}
 				}
 			}
 		} else {
 			console.log("clé n'est pas premier avec 26");
 			document.querySelector('.erreurCle').style.display = 'block';
 		}


 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function dechiffrer() {
 		var texte = document.getElementById('texte').value.replace(/\s+/g, "");
 		var a = parseInt(document.getElementById('cleA').value);
 		var b = parseInt(document.getElementById('cleB').value);
 		document.querySelector('.erreurCle').style.display = 'none';
 		document.querySelector('.erreurChar').style.display = 'none';
 		document.querySelector('.erreurChiffre').style.display = 'none';
 		document.querySelector('.erreurFrappe').style.display = 'none';
 		if (texte.trim() === "" || isNaN(a) || isNaN(b) || (texte.trim() === "" && isNaN(a) && isNaN(b)) || (isNaN(a) && isNaN(b))) {
 			document.querySelector('.erreurFrappe').style.display = 'block';
 			return false;
 		}
 		if (b == 0) {
 			dechiffrerMultiplication(texte, a);
 			return true;
 		}
 		if (a == 1) {
 			dechiffrerCesar(texte, b);
 			return true;
 		}
 		strReturn = "";
 		if (pgcd(a, 26)) {
 			console.log("l'inverse est :");
 			console.log(Inverse(a));
 			console.log("Length :" + texte.length);
			console.log("Texte: " + texte);
			a=Inverse(a);
 			for (i = 0; i < texte.length; i++) {
				console.log("iteration no :"+i);
 				lettre = texte[i];
 				code = lettre.charCodeAt(0);
				console.log("Lettre :"+lettre);
				console.log("Code :"+code);
 				if (code >= 65 && code <= 90) {
 					let indice = tableauDeLettresMaj.indexOf(lettre);
 					newCode = (((indice+ 26 - b) * a) ) % 26;
 					console.log(newCode + "=" + "((" + indice + "-" + b + ")" + "*" + a+ ")%26");
 					newLettre = tableauDeLettresMaj[newCode];
 					strReturn += newLettre;
 				} else {
 					if (code >= 97 && code <= 122) {
 						let indice = tableauDeLettresMin.indexOf(lettre);
 						newCode = (((indice + 26 - b) * a)) % 26;
 						console.log(newCode + "=" + "((" + indice + "-" + b + ")" + "*" + a + ")%26");
 						newLettre = tableauDeLettresMin[newCode];
 						strReturn += newLettre;
 					} else {
 						if (lettre == " ") {
							console.log("espace détécté");
 							continue;
 						} else {
 							//strReturn += str[i];
 							//continue;
 							strReturn = "";
 							console.log("La chaine contient un char spéciale");
 							document.querySelector('.erreurChar').style.display = 'block';
							console.log("un char speciale est detectée");
 							break;
 						}
 					}
 				}
 			}
			
			console.log("Fin boucle");
 		} else {
 			console.log("clé n'est pas premier avec 26");
 			document.querySelector('.erreurCle').style.display = 'block';
 		}

 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function chiffrerMultiplication(texte, cle) {
 		console.log("La fonction chiffrement par multiplication!!!");
 		strReturn = "";
 		if (cle >= 1 || cle <= 25) {
 			if (pgcd(cle, 26)) {
 				for (i = 0; i < texte.length; i++) {
 					lettre = texte[i];
 					code = lettre.charCodeAt(0);
 					if (code >= 65 && code <= 90) {
 						let indice = tableauDeLettresMaj.indexOf(lettre);
 						newCode = (indice * cle) % 26;
 						newLettre = tableauDeLettresMaj[newCode];
 						strReturn += newLettre;
 					} else {
 						if (code >= 97 && code <= 122) {
 							let indice = tableauDeLettresMin.indexOf(lettre);
 							newCode = (indice * cle) % 26;
 							newLettre = tableauDeLettresMin[newCode];
 							strReturn += newLettre;
 						} else {
 							if (lettre == " ") {
 								continue;
 							} else {
 								//strReturn += str[i];
 								//continue;
 								strReturn = "";
 								console.log("La chaine contient un char spéciale");
 								document.querySelector('.erreurChar').style.display = 'block';
 								break;
 							}
 						}
 					}
 				}
 			} else {
 				console.log("clé n'est pas premier avec 26");
 				document.querySelector('.erreurCle').style.display = 'block';
 			}
 		} else {
 			console.log("Clé n'est pas valide");
 			document.querySelector('.erreurChiffre').style.display = 'block';
 		}

 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function dechiffrerMultiplication(texte, cle) {
 		document.querySelector('.erreurFrappe').style.display = 'none';
 		console.log("La fonction dechiffrer");
 		strReturn = "";
 		if (cle >= 1 || cle <= 25) {
 			if (pgcd(cle, 26)) {
 				console.log("Appel de la fonction pgcd effectue et elle retourne true");
 				cle = Inverse(cle);
 				console.log("Appel de la fonction Inverse effectue");
 				for (i = 0; i < texte.length; i++) {
 					lettre = texte[i];
 					code = lettre.charCodeAt(0);
 					if (code >= 65 && code <= 90) {
 						let indice = tableauDeLettresMaj.indexOf(lettre);
 						newCode = (indice * cle) % 26;
 						newLettre = tableauDeLettresMaj[newCode];
 						strReturn += newLettre;
 					} else {
 						if (code >= 97 && code <= 122) {
 							let indice = tableauDeLettresMin.indexOf(lettre);
 							newCode = (indice * cle) % 26;
 							newLettre = tableauDeLettresMin[newCode];
 							strReturn += newLettre;
 						} else {
 							if (lettre == " ") {
 								continue;
 							} else {
 								//strReturn += str[i];
 								//continue ;
 								strReturn = "";
 								console.log("La chaine contient un char speciale");
 								document.querySelector('.erreurChar').style.display = 'block';
 								break;
 							}
 						}
 					}
 				}
 			} else {
 				console.log("La cle n'est pas premier avec 26");
 				document.querySelector('.erreurCle').style.display = 'block';
 			}
 		} else {
 			console.log("La cle n'est pas valide");
 			document.querySelector('.erreurChiffre').style.display = 'block';
 		}

 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function chiffrerCesar(texte, cle) {
 		console.log("La fonction du chiffrement de cesar");
 		strReturn = "";
 		for (i = 0; i < texte.length; i++) {
 			lettre = texte[i];
 			code = lettre.charCodeAt(0);
 			if (code >= 65 && code <= 90) {
 				let indice = tableauDeLettresMaj.indexOf(lettre);
 				newCode = (indice + cle) % 26;
 				newLettre = tableauDeLettresMaj[newCode];
 				strReturn += newLettre;
 			} else {
 				if (code >= 97 && code <= 122) {
 					let indice = tableauDeLettresMin.indexOf(lettre);
 					newCode = (indice + cle) % 26;
 					newLettre = tableauDeLettresMin[newCode];
 					strReturn += newLettre;
 				} else {
 					if (lettre == " ") {
 						continue;
 					} else {
 						//strReturn += str[i];
 						//continue;
 						strReturn = "";
 						console.log("La chaine entrée contient un char spéciale");
 						document.querySelector('.erreurChar').style.display = 'block';
 						break;
 					}
 				}
 			}
 		}
 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function dechiffrerCesar(texte, cle) {
 		console.log(texte);
 		strReturn = "";
 		for (i = 0; i < texte.length; i++) {
 			lettre = texte[i];
 			code = lettre.charCodeAt(0);
 			if (code >= 65 && code <= 90) {
 				let indice = tableauDeLettresMaj.indexOf(lettre);
 				newCode = (indice - cle + 26) % 26;
 				newLettre = tableauDeLettresMaj[newCode];
 				strReturn += newLettre;
 			} else {
 				if (code >= 97 && code <= 122) {
 					let indice = tableauDeLettresMin.indexOf(lettre);
 					newCode = (indice - cle + 26) % 26;
 					newLettre = tableauDeLettresMin[newCode];
 					strReturn += newLettre;
 				} else {
 					if (lettre == " ") {
 						continue;
 					} else {
 						//strReturn += str[i];
 						//continue;
 						strReturn = "";
 						console.log("La chaine contient un char");
 						document.querySelector('.erreurChar').style.display = 'block';
 						break;
 					}
 				}
 			}
 		}
 		document.getElementById('number').value = strReturn;
 		return false;
 	}

 	function resetForm() {
 		document.getElementById("myForm").reset();
 	}
 	function goBack() {
        window.location.href = "../choix_algo.php";
    }
 </script>

 </html>
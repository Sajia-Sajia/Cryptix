<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/code_css_interface_1.css">
	<title>Cryptix</title>
</head>

<body>
<?php

echo "<h1>Bienvenue sur notre application de cryptage et de décryptage !</h1>";
?>
   
   <div class="image-list">
        <div class="image-container">
            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_cesar.php'> <img src=" Images_Crypto/chiffre_cesar.png" alt="chiffrement de césar." class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_cesar.php'><strong>Chiffrement par décalage:César</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_multiplication.php'><img src=" Images_Crypto/chiffre_multi.png" alt="Substitution par multiplication." class="cover-image"></a> 
                <a class="commencer" href='./PHP/chiffrement_multiplication.php'><strong>Chiffrement par multiplication</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_transposition_colonne.php'> <img src=" Images_Crypto/chiffre_transp.jpg" alt="Chiffrement par transposition.\" class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_transposition_colonne.php'><strong>Chiffrement de transposition par colonnes</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_transposition.php'> <img src=" Images_Crypto/transpos.jpg" alt="Chiffrement par transposition.\" class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_transposition.php'><strong>Chiffrement de transposition </strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_permutation.php'><img src=" Images_Crypto/chiffre_permut.png" alt="chiffrement par permutation." class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_permutation.php'><strong>Chiffrement par permutation</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_vigenere.php'><img src=" Images_Crypto/chiffre_vigenere.jpg" alt="Chiffrement Vigenere." class="cover-image"></a> 
                 <a class="commencer" href='./PHP/chiffrement_vigenere.php'><strong>Chiffrement de Vigenère</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_hill.php'> <img src=" Images_Crypto/chiffre_hill.jpg" alt="Chiffrement d'Hill." class="cover-image"></a> 
                <a class="commencer" href='./PHP/chiffrement_hill.php'><strong>Chiffrement de Hill</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_affine.php'><img src=" Images_Crypto/chiffre_affine.jpg" alt="Substitution affine." class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_affine.php'> <strong>Chiffrement affine</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_RC4.php'><img src=" Images_Crypto/chiffre_moderne.png" alt="Chiffrement_RC4.php" class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_RC4.php'> <strong>Chiffrement RC4</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_DES.php'><img src=" Images_Crypto/DES.jpg" alt="Chiffrement_DES.php." class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_DES.php'> <strong>Chiffrement DES</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_AES.php'><img src=" Images_Crypto/AES.jpg" alt="Chiffrement_AES.php" class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_AES.php'> <strong>Chiffrement AES</strong></a>
                </div>
            </div>

            <div class="image">
                <div class="image-item">
                <a href='./PHP/chiffrement_RSA.php'><img src=" Images_Crypto/RSA.jpg" alt="Chiffrement_RSA.php" class="cover-image"></a>
                <a class="commencer" href='./PHP/chiffrement_RSA.php'> <strong>Chiffrement RSA</strong></a>
                </div>
            </div>
    </div>
</div>            

<script type="text/javascript">
	function showModal() {
			var message = 'Veuillez choisir un algorithme si vous souhaitez chiffrer ou déchiffrer un texte.';
			var styledMessage = '<span>' + message + '</span>';

			var modal = document.createElement('div');
			modal.className = 'modal';
			modal.innerHTML = styledMessage;

			document.body.appendChild(modal);

			modal.style.display = 'block';
	}
		window.onload = showModal;

//Style de image-item
    document.addEventListener('DOMContentLoaded', function () {
        var imageItems = document.querySelectorAll('.image-item');

        imageItems.forEach(function (item) {
            item.addEventListener('mouseover', function () {
                 var coverImage = this.querySelector('.cover-image');
                var commencerText = this.querySelector('.commencer');

                 coverImage.classList.add('hovered');
                commencerText.classList.add('hovered');
            });

            item.addEventListener('mouseout', function () {
                 var coverImage = this.querySelector('.cover-image');
                var commencerText = this.querySelector('.commencer');

                coverImage.classList.remove('hovered');
                commencerText.classList.remove('hovered');
            });
        });
    });
</script>

</body>
</html>
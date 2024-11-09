<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryptix/RSA</title>
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface_2.css">
    <link rel="stylesheet" type="text/css" href="../css/code_css_interface3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="form-group">
        <i class="fas fa-arrow-left back-arrow" onclick="goBack()"></i>
    </div>
    <div class="container">
        <h1>Chiffrement par RSA</h1>
        <div class="container">
            <form id="myForm" method="post">

                <p class="erreurCle"> </p>
                <p class="erreurChar"></p>
                <p class="erreurChiffre"> </p>
                <p class="erreurFrappe"></p>

                <div class="form-group">
                    <label for="cle">Le premier entier:</label>
                    <input type="number" id="p" placeholder="p">
                </div>
                <div class="form-group">
                    <label for="cle">Le deuxieme entier :</label>
                    <input type="number" id="q" placeholder="q">
                </div>
                <div id="tableau-container"></div>
                <div class="form-group">
                    <label for="texte">Texte en clair/chiffré :</label>
                    <textarea name="texte" placeholder="Entrez le text en clair/chiffré" id="texte"></textarea>
                </div>

                <button type="button" onclick="chiffrerRSA()">Chiffrer</button>
                <button type="button" onclick="dechiffrerRSA()">Dechiffrer</button>

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
    function chiffrerRSA() {
        var gcd, p, q, no, n, t, e, i, x;
        gcd = function(a, b) {
            return (!b) ? a : gcd(b, a % b);
        };
        p = document.getElementById('p').value;
        q = document.getElementById('q').value;
        no = document.getElementById('texte').value;
        n = p * q;
        t = (p - 1) * (q - 1);
        for (e = 2; e < t; e++) {
            if (gcd(e, t) == 1) {
                break;
            }
        }
        e = 7;
        for (i = 0; i < 10; i++) {
            x = 1 + i * t
            if (x % e == 0) {
                d = x / e;
                break;
            }
        }
        ctt = Math.pow(no, e).toFixed(0);
        ct = ctt % n;
        document.getElementById('number').innerHTML = ct;
    }

    function dechiffrerRSA() {
        var gcd, p, q, no, n, t, e, i, x;
        gcd = function(a, b) {
            return (!b) ? a : gcd(b, a % b);
        };
        p = document.getElementById('p').value;
        q = document.getElementById('q').value;
        ct = document.getElementById('texte').value;
        n = p * q;
        t = (p - 1) * (q - 1);
        for (e = 2; e < t; e++) {
            if (gcd(e, t) == 1) {
                break;
            }
        }
        //  e=7;
        for (i = 0; i < 10; i++) {
            x = 1 + i * t
            if (x % e == 0) {
                d = x / e;
                break;
            }
        }
        dtt = Math.pow(ct, d).toFixed(0);
        dt = dtt % n;
        document.getElementById('number').innerHTML = dt;
    }

    function goBack() {
        window.location.href = "../choix_algo.php";
    }
</script>

</html>
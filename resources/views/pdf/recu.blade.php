<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'Inscription</title>
    <style>
        body { font-family: Georgia, serif; margin: 20px;  padding-top: 90px;}
        .header { text-align: right; font-size: 14px; margin-bottom: 10px; }
        .content { margin-top: 20px; }
        .logo img { width: 120px; }
        .title { text-align: center; font-weight: bold; font-size: 18px; }
        .bold { font-weight: bold; }
        .title span {
            color: red; /* ✅ Numéro rouge */
        }
        .logo { margin-bottom: 10px; }
        .logo img { width: 100px; }
        .qr-code { margin: 20px auto; }
        .qr-code img { width: 150px;}
        .footer { margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        Date : {{ now()->format('d/m/Y') }}
    </div>
    
    <div class="logo">
        <img src="https://fablab.inphb.ci/imagesdjoro/icon.png" alt="Logo INP-HB">

    </div>
    
    <p style="font-size: 16px; font-weight: bold;">INP-HB</p>
    <p style="font-size: 14px; font-weight: bold;">FABLAB ACADEMY 2025</p>
    <p class="title">FACTURE D’INSCRIPTION N° <span>{{ $renseignement->numero_enregistrement }}</span></p>


    <div class="content">
        <p><span class="bold">NOM DU PARENT :</span> {{ $renseignement->nom }} {{ $renseignement->prenoms }}</p>
        <p><span class="bold">NOMBRE D’ENFANTS 5 à 10 ans :</span> {{ $renseignement->nb_enfants_5_10 }}</p>
        <p><span class="bold">NOMBRE D’ENFANTS 11 à 17 ans :</span> {{ $renseignement->nb_enfants_11_17 }}</p>
        <p><span class="bold">MONTANT :</span> {{ number_format($renseignement->tarif, 2, ',', ' ') }} FCFA</p>
        
    </div>
    <!-- QR Code -->
    <div class="qr-code">
    <img src="https://fablab.inphb.ci/imagesdjoro/qrcode.png" alt="QR Code">

    </div>

    <div class="footer">
        <p><small>NB : LES RECUS SONT PAYÉS SUR PLACE</small></p>
    </div>
</body>
</html>

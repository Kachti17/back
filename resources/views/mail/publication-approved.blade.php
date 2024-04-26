<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication approuvée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        p {
            color: #666;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer p {
            color: #999;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Publication approuvée</h1>
        <p>Bonjour {{ $publication->user->prenom }} {{ $publication->user->nom }},</p>
        <p>Votre publication a été approuvée avec succès.</p>
        <p>Voici les détails de votre publication :</p>
        <ul>
            <li><strong>Date de publication :</strong> {{ $publication->date_pub }}</li>
            <li><strong>Contenu :</strong> {{ $publication->contenu->nom_contenu }}</li>
            <!-- Ajoutez d'autres détails de la publication ici -->
        </ul>
        <div class="footer">
            <p>Merci pour votre contribution !</p>
        </div>
    </div>
</body>

</html>

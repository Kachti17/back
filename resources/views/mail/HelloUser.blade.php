<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de création de compte</title>
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
        <h1>Confirmation de création de compte</h1>
        <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
        <p>Votre compte utilisateur a été créé avec succès.</p>
        <p>Voici vos informations :</p>
        <ul>
            <li><strong>Nom :</strong> {{ $user->nom }}</li>
            <li><strong>Prénom :</strong> {{ $user->prenom }}</li>
            <li><strong>Email :</strong> {{ $user->email }}</li>
            <li><strong>Mot de passe temporaire :</strong> {{ $password }}</li>
        </ul>
        <div class="footer">
            <p>Merci de votre confiance !</p>
        </div>
    </div>
</body>

</html>

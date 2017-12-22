<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <style>

    td{
      background-color: #e03913;
      border-radius: 5px;
      padding: 10px 20px 10px 20px;
      text-align: center;
    }

    td > a{
      display: block;
      text-decoration: none;
      color: white !important;
      font-size: 15px;
      font-family: Avenir,Helvetica,sans-serif;
    }

  </style>
</head>
<body>
  <h3>Bonjour,</h3>
  <p>Vous avez demander à réinitialiser votre mot de passe.</p>
  <p>Afin de valider ce choix, veuillez cliquer sur le bouton ci-dessous.</p>
  <table>
      <tr>
          <td>
              <a href="http://listin.fr/password/reset/{{ $token }}">Changer mot de passe</a>
          </td>
      </tr>
  </table>
  <p>Si vous avez reçu ce mail mais que vous n'avez pas oublié votre mot de passe</p>
  <p>ou que vous avez changer d'avis, aucun action n'est recquise.</p>
  <p>Merci de votre confiance,</p>
  <img src="http://listin.arkanii.fr/images/Logo_V4_transparent.png" width="150">
</body>
</html>

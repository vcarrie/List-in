<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <style>

    td{
      background-color: #e03913;
      border-color: #000000;
      border-radius: 5px;
      border: 1px solid #000000;
      padding: 10px;
      text-align: center;
    }

    td > a{
      display: block;
      color: #FFFFFF;
      font-size: 12px;
      font-family: Avenir,Helvetica,sans-serif;
      text-decoration: none;
    }

  </style>
</head>
<body>
  <h3>Bonjour, {{ $name }}</h3>
  <p>Voici votre e-mail de confirmation</p>
  <p>Pour valider votre compte, veuillez cliquer sur le bouton ci-dessous.</p>
  <p>Vous serez redirigé vers notre site et pourrez ensuite profiter de toutes nos fonctionnalités.</p>
  <table>
      <tr>
          <td>
              <a>Confirmer</a>
          </td>
      </tr>
  </table>
  <p>Merci de votre confiance,</p>
  <p>List'In</p>
</body>
</html>

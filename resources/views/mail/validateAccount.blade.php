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
      color: #FFFFFF !important;
      font-size: 15px;
      font-family: Avenir,Helvetica,sans-serif;
    }

  </style>
</head>
<body>
  <h3>Bonjour, {{ $name }}</h3>
  <p>Nous avons besoin de vérifier votre e-mail afin de valider votre action</p>
  <p>Pour cela, il vous suffit de cliquer sur le bouton ci-dessous.</p>
  <p>Vous serez redirigé vers notre site et pourrez ensuite profiter de toutes nos fonctionnalités.</p>
  <table>
      <tr>
          <td>
              <a href="http://listin.fr/confirmation/{{ $id }}/{{ $token }}">Confirmer</a>
          </td>
      </tr>
  </table>
  <p>Merci de votre confiance,</p>
  <img src="http://listin.arkanii.fr/images/Logo_V4_transparent.png" width="150">
</body>
</html>

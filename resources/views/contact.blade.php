@extends(template.main)

@section('title', 'Nous contacter')

@section('mid-content')

<div class="text">
  <p> Des idées, des remarques, des questions ? Faites en nous part !</p>
</div>

<div class="contactForm">
  <form method="post">
    <p>Nom <input type="text" name="lastname" /></p>
    <p>Mail <input type="text" name="email" /></p>
    <p>Objet <input type="text" name="object" /></p>
    <p>Description <input type="textarea" name="description" /></p>
    <p><input type="submit" value="Envoyer" /></p>
  </form>
</div>

<div class="autreContact">
  <p> Vous pouvez également nous contacter par téléphone au : </p>
  <p> ou bien directement par mail à l'adresse  : listin@gmail.com</p>
</div>

@endsection

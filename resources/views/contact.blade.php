@extends(template.master)

@section('title', 'Nous contacter')

@section('mid-content')

<div class="contactForm">
  <form method="post">
    <p>Nom <input type="text" name="lastname" /></p>
    <p>Mail <input type="text" name="email" /></p>
    <p>Objet <input type="text" name="object" /></p>
    <p>Description <input type="textarea" name="description" /></p>
    <p><input type="submit" value="Envoyer" /></p>
  </form>
</div>
@endsection

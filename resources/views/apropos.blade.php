@extends('template.master')

@section('title', 'A Propos')

@section('main')

<div class="row apropos-content">

    <div class="text-presentation col-md-8 col-md-offset-2">
      <h1 class="title-apropos">List'In, qu'est-ce que c'est ?</h1>
      <p>List'in est un site web qui vous permet de trouver et de commander des listes de courses, pré-faites via l'API de CDiscount.
      Vous pouvez trouver différentes listes en recherchant les tags qui leur sont associés.

      <h1 class="title-apropos">Notre équipe</h1>
      <div class="content-team-part1">
        <div class="val">
          <figure>
            <a href="https://www.linkedin.com/in/valentin-carri%C3%A9/?lipi=urn%3Ali%3Apage%3Ad_flagship3_people_connections%3BkUtnIGz6SDak4NhXTCFCgA%3D%3D" target="_blank"><img src="../../../public/images/valentin.jpg" alt="valentin"></a>
            <figcaption>Valentin CARRIE</figcaption>
          </figure>
        </div>

        <div class="mat">
          <figure>
            <a href="https://www.linkedin.com/in/matthieu-cormelier/?lipi=urn%3Ali%3Apage%3Ad_flagship3_people_connections%3BkUtnIGz6SDak4NhXTCFCgA%3D%3D" target="_blank"><img src="../../../public/images/matthieu.jpg" alt="matthieu"></a>
            <figcaption>Matthieu CORMELIER</figcaption>
          </figure>
        </div>

        <div class="ced">
          <figure>
            <a href="https://www.linkedin.com/in/cedricfrecheville/" target="_blank"><img src="../../../public/images/cedric.jpg" alt="cedric"></a>
            <figcaption>Cédric FRECHEVILLE</figcaption>
          </figure>
        </div>
      </div>
      <div class="content-team-part2">

        <div class="the">
          <figure>
            <a href="https://www.linkedin.com/in/theofrison/?lipi=urn%3Ali%3Apage%3Ad_flagship3_people_connections%3BkUtnIGz6SDak4NhXTCFCgA%3D%3D" target="_blank"><img src="../../../public/images/theo.jpg" alt="theo"></a>
            <figcaption>Théo FRISON</figcaption>
          </figure>
        </div>

        <div class="mar">
          <figure>
            <a href="https://www.linkedin.com/in/marceau-jeanjean/?lipi=urn%3Ali%3Apage%3Ad_flagship3_people_connections%3BkUtnIGz6SDak4NhXTCFCgA%3D%3D" target="_blank"><img src="../../../public/images/marceau.jpg" alt="marceau"></a>
            <figcaption>Marceau JEANJEAN</figcaption>
          </figure>
        </div>
      </div>
    </div>
</div>


@endsection

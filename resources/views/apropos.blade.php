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
          <img src="../../../public/images/wailordPl.png" alt="valentin">
          <p>Valentin CARRIE</p>
        </div>

        <div class="mat">
          <img src="../../../public/images/Pikabear.jpg" alt="matthieu">
          <p>Matthieu CORMELIER</p>
        </div>

        <div class="ced">
          <img src="../../../public/images/778.png" alt="cedric">
          <p>Cédric FRECHEVILLE</p>
        </div>
      </div>
      <div class="content-team-part2">
        <div class="the">
          <img src="../../../public/images/riolu-teo.jpg" alt="theo">
          <p>Théo FRISON</p>
        </div>

        <div class="mar">
          <img src="../../../public/images/joliflor.png" alt="marceau">
          <p>Marceau JEANJEAN</p>
        </div>
      </div>
    </div>


@endsection

<?php

namespace App\Repositories\Liste;

use App\Liste;

class ValidateCreateListRepository
{
    public function createList($form)
    {
        $title = $form->title; //à changer en fonction des values="" données
        $description = $form->description;
        $idcreator = $form->idCreator;

        Liste::createList($title, $description, $idcreator);
    }
}
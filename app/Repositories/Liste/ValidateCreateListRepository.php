<?php

namespace App\Repositories\Liste;

use App\Belong;
use App\Categorize;
use App\Liste;

class ValidateCreateListRepository
{
    public function createList($form)
    {
        $title = $form->title; //à changer en fonction des values="" données
        $description = $form->description;
        $idCreator = $form->idCreator;
        $tags = $form->tags;
        $products = $form->products;

        $idList = Liste::createList($title, $description, $idCreator);
        Belong::createList($idList, $products);
        Categorize::createList($idList, $tags);

    }
}
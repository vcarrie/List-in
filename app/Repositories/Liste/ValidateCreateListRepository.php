<?php

namespace App\Repositories\Liste;

use App\Belong;
use App\Categorize;
use App\Liste;
use Auth;

class ValidateCreateListRepository
{
    public function createList($form)
    {
        $title = $form->title; //à changer en fonction des values="" données
        $description = $form->description;
        $idCreator = Auth::user()->id;
        $tags = $form->tags;
        $products = $form->products;
        $quantity = $form->products->quantity;

        $idList = Liste::createList($title, $description, $idCreator);
        Belong::createList($idList, $products, $quantity);
        Categorize::createList($idList, $tags);

    }
}
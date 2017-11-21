<?php

namespace App\Repositories\Liste;

use App\Belong;
use App\Categorize;
use App\Liste;
use Illuminate\Support\Facades\Auth;

class ValidateCreateListRepository
{
    public function createList($form)
    {
        $title = $form->list_name;
        $description = $form->list_description;
        $idCreator = Auth::user()->id;

        $tags = $form->selected_tags;

        $products = array();
        $quantities = array();

        foreach ($form->product as $product) {
            array_push($products, $product['id']);
        }

        foreach ($form->product as $product) {
            array_push($quantities, $product['quantity']);
        }


        $idList = Liste::createList($title, $description, $idCreator);
        Belong::createList($idList, $products, $quantities);
        Categorize::createList($idList, $tags);

        return $idList;
    }
}
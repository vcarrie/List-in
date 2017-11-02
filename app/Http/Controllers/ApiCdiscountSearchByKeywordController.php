<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiCdiscountSearchByKeywordRequest;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByKeywordRepository;

class ApiCdiscountSearchByKeywordController extends Controller
{
    public function get(){
        return "Oui oui";
    }

    public function post(ApiCdiscountSearchByKeywordRequest $request, ApiCdiscountSearchByKeywordRepository $apiRepository){
        return $apiRepository->searchWithKeyword($request->search);
    }
}

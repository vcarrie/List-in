<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiCdiscountSearchByKeywordRequest;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByKeywordRepository;

class ApiCdiscountSearchByKeywordController extends Controller
{
    public function get(){
        return view('api.api');
    }

    public function post(ApiCdiscountSearchByKeywordRequest $request, ApiCdiscountSearchByKeywordRepository $apiRepository){

        $data = $apiRepository->searchWithKeyword($request->search);
        $result = json_decode($data, true);

        var_dump($result);

        return view('api.apiresponse', compact('result'));
    }
}

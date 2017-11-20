<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiCdiscountSearchByKeywordRequest;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByKeywordRepository;
use Illuminate\Http\Request;

class ApiCdiscountSearchByKeywordController extends Controller
{
    public function post(Request $request, ApiCdiscountSearchByKeywordRepository $apiRepository){
        return $apiRepository->searchWithKeyword($request->input('search'));
    }
}

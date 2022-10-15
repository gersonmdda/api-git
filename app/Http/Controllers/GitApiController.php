<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Service\GithubService;
use \Throwable;

// use App\Service\RankingService;

class GitApiController extends BaseController
{
    private GithubService $gitHubService;

    function __construct(GithubService $gitHubService) 
    {
        $this->gitHubService = $gitHubService;
    }

    public function index(Request $request)
    {
        $filters = [
            // 'language' => 'PHP',
            // 'size' => 20673,
            // 'archived' => false
        ];
        $name = 'desa';
        $sort = null;//'commit';
        $this->gitHubService->getRepositories($filters,$name,$sort);
        // try{
        //     return response()->json([
        //         'status' => true,
        //         'response'=> $this->rankingService->getRanking($request->get('movement'))
        //     ],200);
        // } catch(Throwable $e){
        //     $error_code = $e->getCode() ? $e->getCode() : 500;
        //     return response()->json([
        //         'status' => false,
        //         'error'=> $e->getMessage()
        //     ],$error_code);
        // }
    }

}
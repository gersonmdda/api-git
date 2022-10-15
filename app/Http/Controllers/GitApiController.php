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
        $params = $request->all();
        if($params){
            $filters = [
                'language' => $params['language'],
                'size' =>  $params['size'] ? (int) $params['size'] : $params['size'],
                'archived' => (int) ($params['archived']) == 2 ? null : $params['archived']
            ];
            $name = $params['name'];
            $sort = $params['sort'] ?? null;
            $repositories = $this->gitHubService->getRepositories($filters,$name,$sort);
        } else {
            $repositories = $this->gitHubService->getRepositories();
        }
        return view('git_projects', [
                                        'repositories' => $repositories,
                                        'filters' =>$filters ?? null,
                                        'name' =>$name ?? null
                                    ]);
        
    }

}
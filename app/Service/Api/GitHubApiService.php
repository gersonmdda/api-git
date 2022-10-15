<?php

namespace App\Service\Api;

use \Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class GitHubApiService
{
    // protected PersonalRecordRepository $personalRecordRepository;
    // protected MovementRepository $movementRepository;

    // function __construct(PersonalRecordRepository $personalRecordRepository,MovementRepository $movementRepository) 
    // {
    //     $this->personalRecordRepository = $personalRecordRepository;
    //     $this->movementRepository = $movementRepository;
    // }

    private $status_code_success = 200;

    public function getRepositories($sort = 'full_name',$asc = 'asc'):? array 
    {

        try{
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer '.env('GIT_HUB_TOKEN')
            ])->get(env('GIT_HUB_URL').'/users/gersonmdda/repos',['sort'=>$sort,'direction'=>$asc]);
            // ])->get(env('GIT_HUB_URL').'/user/repos');
            $return = $this->verifyStatusCode($response);
        }catch (Exception $e) {
            throw $e;
        }
        return $return;

        //https://docs.github.com/pt/rest/repos/repos#list-repositories-for-a-user
        // Path parameters
        // sortstring
        // The property to sort the results by.

        // Default: full_name

        // Can be one of: created, updated, pushed, full_name
    }

    public function getLastCommit(String $repository,String $branch = 'main'):? array
    {
        try{
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer '.env('GIT_HUB_TOKEN')
            ])->get(env('GIT_HUB_URL')."/repos/gersonmdda/{$repository}/commits/{$branch}");
            $return = $this->verifyStatusCode($response);
        }catch (Exception $e) {
            throw $e;
        }
        return $return;
    }

    private function verifyStatusCode(Response $response):? array
    {
        if($this->status_code_success === $response->getStatusCode()){
            $return = (array) json_decode($response->getBody()->getContents());
        } else {
            $return = null;
        }
        return $return;
    }



}
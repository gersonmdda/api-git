<?php

namespace App\Service\Api;

use \Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class GitHubApiService
{
    
    private $status_code_success = 200;

    public function getRepositories($sort = 'full_name',$asc = 'asc'):? array 
    {

        try{
            $number_page = 1;
            $array = [];
            do{
                $response = Http::withHeaders([
                    'Accept' => 'application/vnd.github+json',
                    'Authorization' => 'Bearer '.env('GIT_HUB_TOKEN')
                ])->get(env('GIT_HUB_URL').'/users/'.env('GIT_HUB_USER').'/repos',['sort'=>$sort,'direction'=>$asc,'per_page'=>100,'page'=>$number_page]);
                $response_array = $this->verifyStatusCode($response);
                $array = array_merge($array,$response_array);
                $number_page ++; 
            } while ($response_array);
        }catch (Exception $e) {
            throw $e;
        }
        return $array;
    }

    public function getLastCommit(String $repository,String $branch = 'main'):? array
    {
        try{
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer '.env('GIT_HUB_TOKEN')
            ])->get(env('GIT_HUB_URL')."/repos/".env('GIT_HUB_USER')."/{$repository}/commits/{$branch}");
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
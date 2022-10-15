<?php

namespace App\Service;

use \Exception;
use Illuminate\Support\Facades\Http;
use App\Service\Api\GitHubApiService;


class GithubService
{
    protected GitHubApiService $gitHubApiService;
    
    function __construct(GitHubApiService $gitHubApiService) 
    {
        $this->gitHubApiService = $gitHubApiService;
    }

    public function getRepositories(array $filters = [], ?String $name, ?String $sort = 'name'):? array
    {
        $repositories = $this->gitHubApiService->getRepositories();
        $repositories = $this->getLastCommit($repositories);
        if($filters){
            $repositories = $this->applyFilters($filters,$repositories);
        }
        if($sort === 'commit'){
            $repositories = $this->applySort($repositories);
        }
        if($name){
            $repositories = $this->applySearchName($repositories,$name);
        }
        dd($repositories);
        return $repositories;
    }

    private function applySearchName(array $repositories, String $name):? array
    {
        $return =  [];
        foreach($repositories as $key => $repository){
            if(str_contains($repository->full_name, $name)){
                $return[] = $repository;
            }
        }
        return $return;
    }

    private function applySort(array $repositories):? array
    {
        usort($repositories, fn($a, $b) => strcmp($a->last_commit_date, $b->last_commit_date));
        return $repositories;
    }

    private function getLastCommit(array $repositories):? array
    {
        foreach($repositories as $key => $repository){
            $last_commit = $this->gitHubApiService->getLastCommit($repository->name);
            $date = $last_commit ? $last_commit['commit']->author->date : null;
            $repositories[$key]->last_commit_date = $date;
        }
        return $repositories;
    }

    private function applyFilters(array $filters,array $repositories):? array
    {

        if(isset($filters['language'])){
            $repositories = $this->search($repositories,'language',$filters['language']);
        }

        if(isset($filters['size']) && $repositories){
            $repositories = $this->search($repositories,'size',$filters['size']);
        }

        if(isset($filters['archived']) && $repositories){
            $repositories = $this->search($repositories,'archived',$filters['archived']);
        }

        return $repositories;
    }

    private function search(array $repositories,String $parameter,$value):? array
    {
        $return =  [];
        foreach($repositories as $key => $repository){
            if($repository->{$parameter} === $value){
                $return[] = $repository;
            }
        }
        return $return;
    }


}
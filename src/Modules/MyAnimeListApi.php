<?php

namespace DateAnime\Modules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class MyAnimeListApi
{
    /**
     * @throws GuzzleException
     */
    public function getAnimeBySeason($year, $season)
    {
        $client = new Client();
        $request = new Request('GET', 'https://api.jikan.moe/v4/seasons/' . $year . '/' . $season);    
    
        $response = $client->send($request);
    
        return json_decode($response->getBody()->getContents());
    }
    
    public function getUpcomingAnime()
    {
        $client = new Client();
        $request = new Request('GET', 'https://api.jikan.moe/v4/seasons/upcoming');
        
        $response = $client->send($request);
        
        return json_decode($response->getBody()->getContents());
    }
    
    public function getAnimeById($id)
    {
        $client = new Client();
        $request = new Request('GET', 'https://api.jikan.moe/v4/anime/' . $id);
        
        $response = $client->send($request);
        
        return json_decode($response->getBody()->getContents());
    }
}

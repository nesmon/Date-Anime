<?php

namespace DateAnime\Controller;
use DateAnime\Modules\MyAnimeListApi;

class AnimeController extends Controller
{
    /**
     * @var MyAnimeListApi
     */
    private $mal;
    
    public function __construct()
    {
        parent::__construct();
        $this->mal = new MyAnimeListApi();
    }
    
    public function index()
    {
        $anime = $this->pdo->query('SELECT * FROM animes');
        $anime = $anime->fetchAll();
    
        $upcomingAnime = $this->mal->getUpcomingAnime();
        $upcomingAnime = $upcomingAnime->data;
        
        echo $this->twig->render('./anime.twig', 
            [
                'animes' => $anime,
                'upcomingAnimes' => [
                    $upcomingAnime[rand(0, count($upcomingAnime) - 1)],
                    $upcomingAnime[rand(0, count($upcomingAnime) - 1)],
                    $upcomingAnime[rand(0, count($upcomingAnime) - 1)],
                    $upcomingAnime[rand(0, count($upcomingAnime) - 1)],
                ],
            ]);
    }

    public function seasonal()
    {
        $anime = $this->mal->getUpcomingAnime();
        
        $anime = $anime->data;
        
        echo $this->twig->render('./seasonal.twig', ['animes' => $anime]);
    }
}

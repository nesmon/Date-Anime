<?php

namespace DateAnime\Controller;

use DateAnime\Modules\MyAnimeListApi;

class AdminController extends Controller
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
        if ($_SESSION['user']['role'] == 'admin') {
            $anime = $this->pdo->query('SELECT * FROM animes');
            $anime = $anime->fetchAll();
            
            echo $this->twig->render('./admin.twig', [
                'animes' => $anime,
            ]);
        } else {
            header('Location: /');
        }
    }
    
    public function addAnime() {
        if ($_SESSION['user']['role'] == 'admin') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = htmlspecialchars($_POST['id']);
                
                $anime = $this->mal->getAnimeById($id);
                $anime = $anime->data;
                
                $this->pdo->prepare('INSERT INTO animes (title, mal_id, image_url, synopsis, year, season) VALUES (:title, :mal_id, :image_url, :synopsis, :year, :season)')
                    ->execute([
                        'title' => $anime->title,
                        'mal_id' => $anime->mal_id,
                        'image_url' => $anime->images->jpg->image_url,
                        'synopsis' => $anime->synopsis,
                        'year' => $anime->year,
                        'season' => $anime->season,
                    ]);
                
                header('Location: /admin');
            }
        } else {
            header('Location: /');
        }
    }
}

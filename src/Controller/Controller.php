<?php

namespace DateAnime\Controller;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    
    protected $twig;
    protected $pdo;
    
    /**
     * Controller constructor.
     */
    function __construct()
    {
        $this->pdo = new PDO(getenv('DATABASE_URL'));
        $this->pdo->query("SET NAMES 'utf8'");
        
        $loader = new FilesystemLoader('./../views/');
    
        $this->twig = new Environment($loader, array(
            'cache' => false,
        ));
    
        $this->twig->addGlobal('isLogged', $_SESSION['loggedIn']);
        
        if ($_SESSION['user']) {
            $this->twig->addGlobal('user', $_SESSION['user']);
        }
    }
    
}

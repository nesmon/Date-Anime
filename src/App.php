<?php
namespace DateAnime;
require './../vendor/autoload.php';

use DateAnime\Modules\DotEnv;
use DateAnime\Router\Router;

class App
{
    public function app()
    {
        // Start the session
        session_start();
        
        if (!isset($_SESSION['loggedIn'])) {
            $_SESSION['loggedIn'] = false;
        }
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = [];
        }
        
        // Load .env file
        $dotenv = new DotEnv('./../.env');
        $dotenv->load();
        
        // Create a new router
        $router = new Router($_SERVER['REQUEST_URI']);

        // DefaultController                                            
        $router->get('/', "Default#index");

        // SecurityController                                          
        $router->get('/login', "Security#login");
        $router->post('/login', "Security#login");
        
        $router->get('/register', "Security#register");
        $router->post('/register', "Security#register");
    
        $router->get('/logout', "Security#logout");
        
        // AnimeController
        $router->get('/anime', "Anime#index");
        $router->get('/anime/seasonal', "Anime#seasonal");
        
        // AdminController
        $router->get('/admin', "Admin#index");
        $router->post('/admin/add_anime', "Admin#addAnime");
        
        // Start the router
        $router->run();
    }
}

// Start the app
(new App())->app();

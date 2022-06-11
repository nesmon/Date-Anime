<?php

namespace DateAnime\Controller;

class SecurityController extends Controller
{
    public function login()
    {
        if ($_SESSION['loggedIn']) {
            header('Location: /');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            
            $user = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
            $user->execute(['username' => $username]);
            $user = $user->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['loggedIn'] = true;
                header('Location: /');
            } else {
                $this->twig->addGlobal('error', 'Invalid username or password');
            }
        }
        
        echo $this->twig->render('./login.twig');
    }
     
    public function register()
    {
        if ($_SESSION['loggedIn']) {
            header('Location: /');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $verifyPassword = htmlspecialchars($_POST['verifyPassword']);
    
            $user = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
            $user->execute(['username' => $username]);
            $user = $user->fetch();
            
            if ($user) {
                $this->twig->addGlobal('error', 'Username already exists');
            } else if ($password !== $verifyPassword) {
                $this->twig->addGlobal('error', 'Passwords do not match');
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                
                $user = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
                $user->execute(['username' => $username, 'password' => $password]);
    
                $_SESSION['user'] = $user;
                $_SESSION['loggedIn'] = true;
                header('Location: /');
            }
        }
        
        echo $this->twig->render('./register.twig');
    }
    
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}

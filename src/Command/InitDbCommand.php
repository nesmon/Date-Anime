<?php

namespace DateAnime\Command;


use DateAnime\Modules\DotEnv;
use PDO;

class InitDbCommand
{
    public function initUserDB()
    {
        $dotenv = new DotEnv('./.env');
        $dotenv->load();
    
        $pdo = new PDO(getenv('DATABASE_URL'));
        $pdo->query("SET NAMES 'utf8'");
        
        // Setup users tables
        $user = $pdo->prepare('CREATE TABLE IF NOT EXISTS users (
            id serial CONSTRAINT user_pk PRIMARY KEY,
            username varchar(255),
            password varchar(255),
            role varchar(255) DEFAULT \'user\'
        )');
        $user->execute();
    
        $user = $pdo->prepare('ALTER TABLE users OWNER TO dateanime');
        $user->execute();
    
        $user = $pdo->prepare('CREATE UNIQUE INDEX user_id_uindex ON users (id)');
        $user->execute();
    
        $user = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $user->execute(['username' => 'rick']);
        $user = $user->fetch();
        
        if (!$user) {
            $user = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
            $user->execute(['username' => 'rick', 'password' => password_hash('rick', PASSWORD_DEFAULT), 'role' => 'admin']);
    
            $user = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
            $user->execute(['username' => 'nick', 'password' => password_hash('nick', PASSWORD_DEFAULT), 'role' => 'user']);
        }
    }
    
    public function initAnimeDb() {
        $dotenv = new DotEnv('./.env');
        $dotenv->load();
    
        $pdo = new PDO(getenv('DATABASE_URL'));
        $pdo->query("SET NAMES 'utf8'");
    
        // Setup animes tables
        $anime = $pdo->prepare('CREATE TABLE IF NOT EXISTS animes (
            id serial CONSTRAINT animes_pk PRIMARY KEY,
            mal_id INTEGER NOT NULL,
            title VARCHAR(255) NOT NULL,
            image_url TEXT NOT NULL,
            synopsis TEXT NOT NULL,
            year INTEGER NOT NULL,
            season VARCHAR(255) NOT NULL
        )');
        $anime->execute();
    
        $anime = $pdo->prepare('ALTER TABLE animes OWNER TO dateanime');
        $anime->execute();
    }
}

<?php
namespace DateAnime\Controller;

class DefaultController extends Controller
{
    public function index()
    {
        echo $this->twig->render('./index.twig');
    }
}

<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoutes()
    {
        if (!isset($_SESSION)) session_start();

        $currentUrl = ($_SERVER['REQUEST_URI'] === '') ? '/' :  $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        //dividimos la URL actual cada vez que exista un '?' eso indica que se están pasando variables por la url
        $splitURL = explode('?', $currentUrl);
        // debuguear($splitURL);

        if ($method === 'GET') {
            $fn = $this->getRoutes[$splitURL[0]] ?? null; //$splitURL[0] contiene la URL sin variables 
        } else {
            $fn = $this->postRoutes[$splitURL[0]] ?? null;
        }


        if ($fn) {
            // Call user fn is gonna be called when we don't know the function name
            call_user_func($fn, $this); // This to pass args
        } else {
            echo "Page not found or invalid route";
        }
    }

    public function render($view, $data = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($data as $key => $value) {
            $$key = $value;  // Double dollar means variable-variable, so the variable name is assigned dynamically
        }

        ob_start(); // Storing in memory

        // including view on layout
        include_once __DIR__ . "/views/$view.php";

        // Clearing buffer
        $content = ob_get_clean();

        include_once __DIR__ . '/views/layout.php';
    }
}

<?php

namespace Controller;

use Model\Service;
use MVC\Router;

class ServiceController
{
    public static function index(Router $router)
    {
        if (!isset($_SESSION)) session_start();
        isAdmin();

        $services = Service::all();

        $router->render('services/index', [
            'name' => $_SESSION['name'],
            'services' => $services
        ]);
    }

    public static function new(Router $router)
    {
        if (!isset($_SESSION)) session_start();
        isAdmin();

        $service = new Service;
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Save input data after clicking button
            $service->synch($_POST);

            // Error management
            $alerts = $service->validate();

            if (empty($alerts)) {
                $service->save();
                header('Location: /services');
            }
        }

        $router->render('services/new', [
            'name' => $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function edit(Router $router)
    {
        if (!isset($_SESSION)) session_start();
        isAdmin();

        if (!is_numeric($_GET['id'])) return;
        $service = Service::find($_GET['id']);
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->synch($_POST);
            $alerts = $service->validate();

            if (empty($alerts)) {
                $service->save();
                header('Location: /services');
            }
        }

        $router->render('services/edit', [
            'name' => $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function delete()
    {
        if (!isset($_SESSION)) session_start();
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $service = Service::find(($id));
            $service->delete();
            header('Location: /services');
        }
    }
}

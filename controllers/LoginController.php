<?php

namespace Controller;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);

            $alerts = $auth->validateLogin();

            if (empty($alerts)) {
                // Check if user is registered
                $user = User::where('email', $auth->email);

                if ($user) {
                    // Check password
                    if ($user->checkPasswordAndConfirmed($auth->password)) {
                        // Authenticate user
                        if (!isset($_SESSION)) session_start();

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->surname;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        // Redirection
                        if ($user->admin === "1") {
                            $_SESSION['admin'] = $user->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /appointment');
                        }
                    }
                } else {
                    User::setAlert('error', 'User not confirmed');
                }
            }
        }
        $alerts = User::getAlerts();

        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }

    public static function logout()
    {
        if (!isset($_SESSION)) session_start();

        // Clear session
        $_SESSION = [];
        header('Location: /');
    }

    public static function forgot(Router $router)
    {
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                $user = User::where('email', $auth->email);

                if ($user && $user->confirmed === '1') {
                    // Generate single-use token
                    $user->createToken();
                    $user->save();

                    // Send email
                    $email = new Email($user->name, $user->email, $user->token);
                    $email->sendInstructions();

                    // Success alert
                    User::setAlert('success', 'Check your email inbox');
                } else {
                    User::setAlert('error', 'User is not registered or not confirmed');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/forgot', [
            'alerts' => $alerts
        ]);
    }

    public static function reset(Router $router)
    {
        $alerts = [];
        $error = false;

        $token = s($_GET['token']);

        // Search user by token
        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlert('error', 'Invalid Token');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read new password and save it
            $password = new User($_POST);
            $alerts = $password->validatePassword();

            if (empty($alerts)) {
                $user->password = null;

                $user->password = $password->password;
                $user->hashPassword();
                $user->token = null;

                $result = $user->save();
                if ($result) {
                    header('Location: /');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/reset', [
            'alerts' => $alerts,
            'error' => $error
        ]);
    }

    public static function create(Router $router)
    {
        $user = new User;

        // Empty alerts
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->synch($_POST);
            $alerts = $user->validateNewAccount();

            // Criteria to pass validation (no errors)
            if (empty($alerts)) {
                // Check if user already exists
                $result = $user->userExists();

                if ($result->num_rows) {
                    $alerts = User::getAlerts();
                } else {
                    // Hashing password
                    $user->hashPassword();

                    // Generating a single-use token
                    $user->createToken();

                    // Sending confirmation email
                    $email = new Email($user->name, $user->email, $user->token);

                    $email->sendConfirmation();

                    // Registering the user
                    $result = $user->save();
                    if ($result) {
                        header('Location: /message');
                    }

                    // debug($user);
                }
            }
        }

        $router->render('auth/create-account', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function message(Router $router)
    {
        $router->render('auth/message');
    }

    public static function confirm(Router $router)
    {
        $alerts = [];

        $token = s($_GET['token']);

        $user = User::where('token', $token);

        if (empty($user)) {
            // Show error message
            User::setAlert('error', 'Invalid Token');
        } else {
            // Switch 'confirmed' variable to 1
            $user->confirmed = 1;
            $user->token = '';
            $user->save();
            User::setAlert('success', 'Account was successfully confirmed');
        }

        // Getting alerts
        $alerts = User::getAlerts();

        // Rendering view
        $router->render('auth/confirm-account', [
            'alerts' => $alerts
        ]);
    }
}

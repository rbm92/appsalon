<?php

namespace Controller;

use Model\AdminAppointment;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        if (!isset($_SESSION)) session_start();

        isAdmin();

        // Current date by default
        $date = $_GET['date'] ?? date('Y-m-d');

        // Separating day, month and year for later check
        $dateArray = explode('-', $date);

        // Check if it's a valid date
        if (!checkdate($dateArray[1], $dateArray[2], $dateArray[0])) {
            header('Location: /404');
        };

        // Query DB
        $query = "SELECT appointments.id, appointments.`time`, CONCAT( users.`name`, ' ', users.surname) as customer, ";
        $query .= " users.email, users.phone, services.`name` as service, services.price  ";
        $query .= " FROM appointments  ";
        $query .= " LEFT OUTER JOIN users ";
        $query .= " ON appointments.userId=users.id  ";
        $query .= " LEFT OUTER JOIN appointmentsServices ";
        $query .= " ON appointmentsServices.appointmentId=appointments.id ";
        $query .= " LEFT OUTER JOIN services ";
        $query .= " ON services.id=appointmentsServices.serviceId ";
        $query .= " WHERE date =  '${date}' ";

        $appointments = AdminAppointment::SQL($query);

        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'appointments' => $appointments,
            'date' => $date
        ]);
    }
}

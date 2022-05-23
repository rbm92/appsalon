<?php

namespace Controller;

use Model\Appointment;
use Model\AppointmentService;
use Model\Service;

class APIController
{
    public static function index()
    {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save()
    {
        // Save appointment and return ID
        $appointment = new Appointment($_POST);
        $result = $appointment->save();

        $id = $result['id'];

        // Save services with appointment ID
        $servicesId = explode(',', $_POST['services']);
        foreach ($servicesId as $serviceId) {
            $args = [
                'appointmentId' => $id,
                'serviceId' => $serviceId
            ];
            $appointmentService = new AppointmentService($args);
            $appointmentService->save();
        }

        // Return a response
        $response = [
            'result' => $result
        ];

        echo json_encode(['result' => $result]);
    }

    public static function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $appointment = Appointment::find($id);
            $appointment->delete();

            // Redirect to previous page
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}

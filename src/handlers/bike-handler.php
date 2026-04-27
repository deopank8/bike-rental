<?php

include 'config.php';
include 'service.php';

$bikeService = new BikeService();

echo handleRequest();

function handleRequest() {
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    try {
        switch ($action) {
            case 'list':
                return json_encode($bikeService->getAllBikes());
            case 'available':
                return json_encode($bikeService->getAvailableBikes());
            case 'get_by_type':
                $type = isset($_GET['type']) ? $_GET['type'] : '';
                return json_encode($bikeService->getBikesByType($type));
            case 'get':
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                return json_encode($bikeService->getBikeById($id));
            case 'rent':
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                $bikeService->rentBike($id);
                return json_encode(['status' => 'success', 'message' => 'Bike rented successfully.']);
            case 'return':
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                $bikeService->returnBike($id);
                return json_encode(['status' => 'success', 'message' => 'Bike returned successfully.']);
            case 'reset':
                $bikeService->resetBikes();
                return json_encode(['status' => 'success', 'message' => 'All bikes have been reset.']);
            default:
                return json_encode(['status' => 'error', 'message' => 'Unknown action.']);
        }
    } catch (Exception $e) {
        return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
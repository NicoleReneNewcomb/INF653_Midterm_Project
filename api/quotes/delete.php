<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // get raw Quote data
    $data = json_decode(file_get_contents("php://input"));

    // Get ID of Quote to delete
    $quote->id = $data->id;

    // delete Quote
    if ($quote->delete()) {
        echo json_encode(
            array('id' => $quote->id)
        );
    } else {
        echo json_encode(
            array('message' => 'quote_id Not Found')
        );
    }
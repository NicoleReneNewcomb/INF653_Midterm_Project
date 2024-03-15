<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
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

    // Return error message and stop if parameters missing
    if (!isset($data->id, $data->quote, $data->author_id, $data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit;
    }

    // Get ID and other fields of Quote to update
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // update Quote
    if ($quote->update()) {
        echo json_encode(
            array('id' => $quote->id, 
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'quote_id Not Found')
        );
    }
<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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
    if (!isset($data->quote, $data->author_id, $data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit;
    }

    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id; 
    $quote->category_id = $data->category_id;

    // Check if author_id and category_id exist
    if (!$quote->authorExists($quote->author_id)) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
        exit;
    }

    if (!$quote->categoryExists($quote->category_id)) {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
        exit;
    }

    // create Quote
    if ($quote->create()) {
        echo json_encode(
            array('id' => $quote->id, 
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'Failed to create quote')
        );
    }
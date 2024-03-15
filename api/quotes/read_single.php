<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // get Quote ID if set
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call read_single() to fetch the quote
    $quote->read_single();

    // Quote read_single() query
    if ($quote->quote) {
        // Create Quote array
        $quote_arr = array(
            'id' => (int) $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );

        // create JSON object
        print_r(json_encode($quote_arr));
    }
    else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
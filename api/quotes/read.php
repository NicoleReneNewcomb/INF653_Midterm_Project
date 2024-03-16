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
    $quoteObj = new Quote($db);

    // Quote read() query
    $result = $quoteObj->read();
    // count number of Quotes
    $num = $result->rowCount();

    // Condition to check Quotes exist
    if ($num > 0) {

        // Create Quotes array
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {

            // extract table fields to be used as variables, i.e. $id
            extract($row);

            // create individual Quote array from extracted field variables
            $quote_item = array(
                'id' => (int) $id,
                'quote' => html_entity_decode($quote),
                'author' => $author,
                'category' => $category
            );

            // Push Quote into "data" part of array
            array_push($quotes_arr, $quote_item);
        }

        // Turn to JSON and output
        echo json_encode($quotes_arr);
    }
    else {
        
        // If no posts
        echo json_encode(
            array('message' => 'quote_id Not Found')
        );
    }
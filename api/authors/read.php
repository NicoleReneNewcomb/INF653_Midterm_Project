<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author = new Author($db);

    // Author read() query
    $result = $author->read();
    // count number of Authors
    $num = $result->rowCount();

    // Condition to check Authors exist
    if ($num > 0) {

        // Create Authors array
        $authors_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {

            // extract table fields to be used as variables, i.e. $id
            extract($row);

            // create individual Author array from extracted field variables
            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push Author into "data" part of array
            array_push($authors_arr, $author_item);
        }

        // Turn to JSON and output
        echo json_encode($authors_arr);
    }
    else {
        
        // If no posts
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
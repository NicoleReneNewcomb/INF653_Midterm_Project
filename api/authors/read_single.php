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

    // get Author ID if set
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Author read_single() query
    if ($author->author) {
        // Create Author array
        $author_arr = array(
            'id' => (int) $author->id,
            'author' => $author->author
        );

        // create JSON object
        print_r(json_encode($author_arr));
    }
    else {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    }
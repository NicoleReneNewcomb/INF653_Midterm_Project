<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category object
    $category = new Category($db);

    // get Category ID if set
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Call read_single() to fetch the category
    $category->read_single();

    // Category read_single() query
    if ($category->category) {
        // Create Category array
        $category_arr = array(
            'id' => (int) $category->id,
            'category' => $category->category
        );

        // create JSON object
        print_r(json_encode($category_arr));
    }
    else {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
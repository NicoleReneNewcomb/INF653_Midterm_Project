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

    // Category read() query
    $result = $category->read();
    // count number of Categorys
    $num = $result->rowCount();

    // Condition to check Categorys exist
    if ($num > 0) {

        // Create Categorys array
        $categorys_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {

            // extract table fields to be used as variables, i.e. $id
            extract($row);

            // create individual Category array from extracted field variables
            $category_item = array(
                'id' => (int) $id,
                'category' => $category
            );

            // Push Category into "data" part of array
            array_push($categorys_arr, $category_item);
        }

        // Turn to JSON and output
        echo json_encode($categorys_arr);
    }
    else {
        
        // If no posts
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }
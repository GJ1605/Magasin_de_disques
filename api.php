<?php
    include "model.php";

    if($_SERVER['REQUEST_METHOD'] != "GET") {echo "MUST be get !"; die(); }

    if( isset($_GET['action']) ) {
        try {
            print_r($_GET['action']($_GET['value']));
        } catch (Exception $e) {
            echo "error";
        }

    } else {
        echo "no function name like this !";
    }
?>
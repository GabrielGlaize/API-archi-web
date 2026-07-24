<?php
    header('content-type: application/json');
    if (!$ticket) {
        http_response_code(404);
        echo json_encode(array("error" => "Ticket not found"));
    } else {
        echo json_encode($ticket);
    }

<?php
    http_response_code(500);
    header('content-type: application/json');
    echo json_encode($error);
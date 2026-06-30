<?php
    function getConnexion(){
        return new PDO('mysql:dbname=esgi1-archi;host=localhost', 'root', '');
    }
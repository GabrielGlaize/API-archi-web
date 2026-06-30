<?php
include_once('./model/ticket.model.php');

class TicketController {
    function getAll(){
        $tickets = TicketModel::getAll();
        include('./view/ticketList.json.php');
    }

    function getById($id){
        $ticket = TicketModel::getById($id);
        include('./view/ticket.json.php');
    }
        
    function create(){
        $data = file_get_contents("php://input");
        $ticket = json_decode($data);

        TicketModel::create($ticket);
        include('./view/createTicket.json.php');
    }

    function update($id){
        $data = file_get_contents("php://input");
        $ticket = json_decode($data);

        TicketModel::update($id, $ticket);
        include('./view/updateTicket.json.php');
    }
    
    function delete($id){
        TicketModel::delete($id);
        include('./view/deleteTicket.json.php');
    }
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach($tickets as $ticket){ ?>
        <div class="ticket">
            <div class="title"><?=  $ticket->title; ?></div>
            <div class="category"><?=  $ticket->category; ?></div>
            <div class="priority"><?=  $ticket->priority; ?></div>
            <div class="status"><?=  $ticket->status; ?></div>
        </div>
    <?php } ?>
</body>
</html>
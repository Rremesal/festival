<?php include("festivaldb.php"); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Webshop</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <?php require("menu.php") ?>
    <div class="content" id="webshopPage">

    <?php 
        $query = "SELECT * FROM ticket";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($data as $ticket) {
        ?>      <div class="ticket-div">
                    <div class="ticket-info">
                        <h2><?=$ticket->ticket_type;?></h2>
                    </div>

                    <div id="ticket-image">
                        <img src="images/ticket.png"/>
                    </div>
                </div>
                <br/>
        <?php
            }
        }

    ?>



    </div>
    
</body>
</html>
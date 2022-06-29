<?php include("festivaldb.php");?>
<?php 
    session_start(); 
    $conn = connectToDB();

    $totalTicketsSold = TotalTicketsSold();
   
    $remainingTickets = 60 - $totalTicketsSold->ticketsSold;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Webshop</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js"></script>
</head>
<body>
    <?php require("menu.php") ?>
    <div class="content" id="webshopPage">
        <h3 id="remainingTickets"><?=$remainingTickets." "."tickets still remaining"?></h3>
    <?php 
        $tickets = getTickets();
        foreach($tickets as $ticket) {
    ?>  <div class="ticket-div">
        <?php
            $query = "SELECT amount FROM amountSoldTable WHERE ticket_id = $ticket->ticket_id";
            $stm = $conn->prepare($query);
            $stm->execute();
            $amountOfTicketsSold = $stm->fetch(PDO::FETCH_OBJ);
        ?>
                    <div class="ticket-info">
                        <h2><?=$ticket->ticket_type;?></h2>
                        
                        <div class="ticket-price">
                            <h1><?="€ ".$ticket->price;?></h1>
                        </div>
                        
                        <form method="POST">
                            <input type="text" name="ticket_id" value="<?=$ticket->ticket_id?>" hidden/>
                            <div class="ticket-form">
                            <select name="amount" id="ticket-amount">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <input type="submit" name="btnSubmit" class="btnForm" value="Add to Cart"/>
                            </div>
                        </form>
                    </div>

                    <div id="ticket-image">
                        <img src="<?=$ticket->image;?>"/>
                    </div>
            </div>
                <br/>
        <?php  } ?>
        


        <?php
            if(isset($_POST['btnSubmit'])) {
                $ticketId = $_POST['ticket_id'];
                $amount = intval($_POST['amount']);

                if(empty($_SESSION['shoppingCart'])) $_SESSION['shoppingCart'] = array();
                if(isset($_SESSION['shoppingCart'][$ticketId])) $_SESSION['shoppingCart'][$ticketId] += $amount;
                else $_SESSION['shoppingCart'][$ticketId] = $amount;
            }
        ?>



    </div>
    
</body>
</html>
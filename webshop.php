<?php include("festivaldb.php"); ?>
<?php session_start(); ?>
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

    <?php 
        $query = "SELECT * FROM ticket";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            $name = "btnAddToCart";
            $counter = 1;
            foreach($data as $ticket) {
                $variable = $name.strval($counter);
        ?>  <div class="ticket-div">
                    <div class="ticket-info">
                        <div class="">
                        <h2><?=$ticket->ticket_type;?></h2>
                        
                        <div class="ticket-price">
                            <h1><?="€ ".$ticket->price;?></h1>
                        </div>
                        </div>
                        
                        <form method="POST">
                            <input type="text" value="<?=$ticket->ticket_id?>" hidden/>
                            <div class="ticket-form">
                            <select name="ticket-amount" id="ticket-amount">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                            <input type="submit" name="<?=$variable?>" class="btnForm" value="Add to Cart"/>
                            </div>
                        </form>
                    </div>

                    <div id="ticket-image">
                        <img src="<?=$ticket->image;?>"/>
                    </div>
                </form>
            </div>
                <br/>
        <?php  
                $counter = $counter + 1;
            }
        }

        if(isset($_POST['btnAddToCart1'])) {
            $query = "SELECT ticket_id FROM ticket WHERE `ticket_type`='Vrijdag-ticket'";
        }
        if(isset($_POST['btnAddToCart2'])) {
            $query = "SELECT ticket_id FROM ticket WHERE `ticket_type`='Zaterdag-ticket'";
        }
        if(isset($_POST['btnAddToCart3'])) {
            $query = "SELECT ticket_id FROM ticket WHERE `ticket_type`='Combi-ticket'";
        }

            echo $query;
            $stm = $conn->prepare($query);
            $stm->execute();
            $data = $stm->fetch(PDO::FETCH_OBJ);

        

        

        

    ?>



    </div>
    
</body>
</html>
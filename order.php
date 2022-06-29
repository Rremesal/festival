<?php 
    include("festivaldb.php"); 
    $conn = connectToDB();

    $totalTicketsSold = TotalTicketsSold();
    $remainingTickets = 60 - $totalTicketsSold->ticketsSold;
?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Order</title>
    <script src="script.js"></script>
</head>
<body id="orderBody">
    <?php include("menu.php"); ?>
    <div class="content" id="orderPage">
        <table>
            <tr>
                <th>Product</th>
                <th>Amount</th>
                <th>Price</th>
                <th></th>
                <th></th>
            </tr>
            <?php $totalPrice = 0; ?>
            <?php if(isset($_SESSION['shoppingCart'])) {
                    foreach($_SESSION['shoppingCart'] as $id => $amount) { 
                        $query = "SELECT ticket_type,price FROM ticket WHERE ticket_id=$id";
                        $stm = $conn->prepare($query);
                        $stm->execute();
                        $data = $stm->fetch(PDO::FETCH_OBJ);
                        $totalPrice += $data->price;    
                ?> 
                <tr>
                    <td><?=$data->ticket_type?></td>
                    <td id="tdAmount">
                        <div>
                            <form method="POST">
                                <input type="submit" name="btnSubtract" value="-"/>
                                <?=$amount?>
                                <input type="text" name="id" value="<?=$id?>" hidden/>
                                <input type="submit"name="btnAdd" value="+" />
                            </form>
                        </div> 
                    </td>
                    <td><?=$data->price?></td>
                    <td><a href="removefromcart.php?id=<?=$id?>"><img id="trash" src="images/trash.png"/></a></td>
                </tr>
                
                <?php }?>
            <?php }?>
            <tr id="totalPrice-row">
                <td>Totaal:</td>
                <td></td>
                <td><?= $totalPrice.".00"?></td>
            </tr>
        </table>

        <div id="orderDiv">
            <form method="POST">
                <input type="submit" value="Order" name="btnOrder" class="btnForm"/>
            </form>
        </div>
    
    <?php 
        if(empty($_SESSION['shoppingCart'])) {
    ?>      <h3>Your shoppingcart is empty.</h3>
    <?php
        }

        if(isset($_POST['btnAdd'])) {
            $id = $_POST['id'];
            $_SESSION['shoppingCart'][$id] += 1;
            header("Refresh: 0");
        }
        if(isset($_POST['btnSubtract']) && $_SESSION['shoppingCart'][$id] > 0) {
            $id = $_POST['id'];
            $_SESSION['shoppingCart'][$id] -= 1;
            header("Refresh: 0");
        }

        if(isset($_POST['btnOrder']) && isset($_SESSION['shoppingCart']) ) {
            if ($_SESSION['shoppingCart'][$id]  <= $remainingTickets) {
                foreach($_SESSION['shoppingCart'] as $id => $value) {
                    $query = "INSERT INTO transaction (`user_id`,`ticket_id`,`date`,`amount`)". 
                    " VALUES (".$_SESSION['user'].",$id,NOW(),$value)";
                    $stm = $conn->prepare($query);
                    if($stm->execute()) {
                        header("Location: ordered.php");
                    }
                }
            } else {
            ?> <h3>Your order exceeds ticket availability: <?=$remainingTickets?></h3>
            <?php
            }
        }   ?>
    </div>
</body>
</html>
<?php 
    include("festivaldb.php"); 
    $conn = connectToDB();

    $amountOfTicketsSoldQuery = "SELECT SUM(amount) as ticketsSold FROM transaction";
    $stm = $conn->prepare($amountOfTicketsSoldQuery);
    $stm->execute();
    $amountOfTickets = $stm->fetch(PDO::FETCH_OBJ);
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

        if(isset($_POST['btnOrder']) && isset($_SESSION['shoppingCart']) && ($_SESSION['shoppingCart'][$id]  <= (20 - $amountOfTickets->ticketsSold))  ) {
            foreach($_SESSION['shoppingCart'] as $id => $value) {
                $orderQuery = "INSERT INTO transaction (`user_id`,`ticket_id`,`date`,`amount`)". 
                " VALUES (".$_SESSION['user'].",$id,NOW(),$value)";
                echo $orderQuery."<br/>";
                $stm = $conn->prepare($orderQuery);
                $stm->execute();
            } 
            header("Location: ordered.php");
            unset($_SESSION['shoppingCart']);
        }

        if($_SESSION['shoppingCart'][$id]  > (20 - $amountOfTickets->ticketsSold)) {
    ?>      <h3>Your order exceeds the available tickets</h3>
    <?php
        }
    ?>
    </div>
</body>
</html>
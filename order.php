<?php include("festivaldb.php"); ?>
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
                    <td><?=$amount?></td>
                    <td><?=$data->price?></td>
                    <td><a href="removefromcart.php?id=<?=$id?>"><img id="trash" src="images/trash.png"/></a></td>
                    
                </tr>
                
                <?php }?>
            <?php }?>
            <tr id="totalPrice-row">
                <td>Totaal:</td>
                <td></td>
                <td></td>
                <td><?= $totalPrice.".00"?></td>
            </tr>
        </table>


    </div>
</body>
</html>
<?php 
    include("festivaldb.php");
    $conn = connectToDB(); 
?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js"></script>
    <title>Management Tool</title>
</head>
<body id="moduleBody">
    <?php require("menu.php") ?> 
    <div id="module-content">
        <div id="module-table">
            <table>
                <tr>
                    <th>Kind of Ticket</th>
                    <th>Amount sold</th>
                    <th>Income</th>
                </tr>
                <?php 
                    $ticketsSoldQuery = "SELECT * FROM transaction LEFT JOIN ticket ON ticket.ticket_id=transaction.ticket_id GROUP BY ticket_type";
                    $stm = $conn->prepare($ticketsSoldQuery);
                    $stm->execute();
                    $tickets = $stm->fetchAll(PDO::FETCH_OBJ);
                    $totalIncome = 0;
                    foreach($tickets as $ticket) {
                ?>      <tr>
                            <td><?=$ticket->ticket_type?></td>
                            <td><?=$ticket->amount?></td>
                            <td><?= "€ ",$ticket->price += $ticket->price?></td>
                        </tr>
                        <?php $totalIncome += $ticket->price?>
                <?php
                    }    
                ?>
                <tr id="totalIncomeRow">
                    <td>Total</td>
                    <td></td>
                    <td><?= "€ ",$totalIncome?></td>
                </tr> 
            </table>
        </div>

        <div class="module-holder">
            <div id="module-newsitems">
                <h2>NewsItems</h2>
                <form method="POST">
                    <label for="txtHeader">Header:</label>
                    <div>
                        <input type="text" id="txtHeader" name="txtHeader">
                    </div>
                    
                    <label for="txtNewsitem">Content:</label>
                    <div>
                        <textarea type="text" id="txtNewsitem" name="txtNewsitem" maxlength="200" rows="3"></textarea>
                    </div>
                    <br/>
                    <input type="submit" name="btnSaveItem" class="btnForm"/>
                    <br/>
                    <?php 
                        if(isset($_POST['btnSaveItem'])) {
                            $header = $_POST['txtHeader'];
                            $newsitem = $_POST['txtNewsitem'];
                            $query = "INSERT INTO newsitem (header,content) VALUES ('$header','$newsitem')";
                            $stm = $conn->prepare($query);
                            if($stm->execute()) {
                                echo "Newsitem added";
                    ?>          </form> 
                    <?php               
                                $query2 = "SELECT item_id FROM newsitem WHERE content='$newsitem'";
                                $stm = $conn->prepare($query2);
                                $stm->execute();
                                $itemdata = $stm->fetch(PDO::FETCH_OBJ);

                                $query3 = "INSERT INTO admin_item (user_id,item_id,date) VALUES (".$_SESSION['user'].",$itemdata->item_id,now())";
                                $stm = $conn->prepare($query3);
                                $stm->execute();
 
                            }
                        }
                    ?>
                    
                </form>
            </div>

            <div id="module-lineup">
                <h2>Artists</h2>
                <form method="POST">
                    <label for="txtName">First Name:</label>
                    <div><input id="txtName" name="txtName" type="text"/></div>
                    <label for="txtLastName">Last Name:</label>
                    <div><input id="txtLastName" name="txtLastName" type="text"/></div>
                    <label for="txtImage">Image:</label>
                    <div><input id="txtImage" name="txtImage" type="text"/></div>
                    <label for="txtWeblink">Web link:</label>
                    <div><input id="txtWeblink" name="txtWeblink" type="text"/></div>
                    <label for="txtTwitterlink">Twitter link:</label>
                    <div><input id="txtTwitterlink" name="txtTwitterlink" type="text"/></div>
                    <label for="txtPreview">Preview:</label>
                    <div><input id="txtPreview" name="txtPreview" type="text"></div>
                    <input type="submit" class="btnForm"name="btnUpload"/>
                <?php 
                    if(isset($_POST['btnUpload'])) {
                        $firstName = $_POST['txtName'];
                        $lastName = $_POST['txtLastName'];
                        $image = $_POST['txtImage'];
                        $webLink = $_POST['txtWeblink'];
                        $twitterLink = $_POST['txtTwitterlink'];
                        $preview = $_POST['txtPreview'];

                        $query = "INSERT INTO lineup (first_name,last_name,image,weblink,twitterlink,preview)". 
                        "VALUES ('$firstName','$lastName','$image','$webLink','$twitterLink','$preview')";
                        echo $query;
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            echo "Artist added";
                ?>          </form>
                <?php
                        }
                    }
                ?>
                </form>
            </div>
        

            <div id="module-accounts">
                <h2>Admin Management</h2>
                <form method="POST">
                    <label for="txtPassword">Password:</label>
                    <div><input type="text" name="txtPassword" id="txtPassword"/><input type="submit" onclick="isClicked()" id="btnConvert" value="convert" name="btnConvert"/></div>

                    
                    <?php if(isset($_POST['btnConvert']) && isset($_POST['txtPassword'])) {
                    ?>      <label for="txtHashed">Hashed password:</label>    
                            <div><input type="text" value="<?= hashPassword($_POST['txtPassword'])?>" name="txtHashed" id="txtHashed" readonly/></div>
                    <?php } ?>
                    
                    
                    
                    
                    <label for="txtFirstName">First name:</label>
                    <div><input type="text" name="txtFirstName" id="txtFirstName"/></div>
                    
                    <label for="txtPrefix">(Prefix + ) Last name:</label>
                    <div>
                        <input type="text" name="txtPrefix" class="inputPrefix"/>
                        <input type="text" name="txtSurname" id="txtSurname"/>
                    </div>
                    
                    <label for="txtPhonenumber">Phone number:</label>
                    <div><input type="text" name="txtPhonenumber" id="txtPhonenumber"/></div>
                    
                    <label for="txtEmail">Email:</label>
                    <div><input type="text" name="txtEmail" id="txtEmail"/></div>
                    
                    
                    <input type="submit" class="btnForm" name="btnSave"/>
                    <?php 
                        if(isset($_POST['btnSave']) && isset($_POST['txtHashed'])) {
                            $insertUserQuery = "INSERT INTO user (email, password,phonenumber,firstname,surname_prefix,surname,isAdmin)". 
                            "VALUES ( :email, :password, :phonenumber, :firstname, :prefix, :surname, 1)";
                            $stm = $conn->prepare($insertUserQuery);
                            $stm->bindParam(":email",$_POST['txtEmail']);
                            $stm->bindParam(":password",$_POST['txtHashed']);
                            $stm->bindParam(":phonenumber",$_POST['txtPhonenumber']);
                            $stm->bindParam(":firstname",$_POST['txtFirstName']);
                            $stm->bindParam(":surname",$_POST['txtSurname']);
                            $stm->bindParam(":prefix",$_POST['txtPrefix']);
                            $stm->execute();
                            
                            
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>

    


</body>
</html>
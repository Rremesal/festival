<?php include("festivaldb.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Management Tool</title>
</head>
<body>
    <?php require("menu.php") ?> 
    <div id="module-content">
        <div id="module-table">
            <table>
                <tr>
                    <th>Kind of Ticket</th>
                    <th>Amount sold</th>
                </tr>
                <tr>
                    <td>[ticketsoort1]</td>
                    <td>aantal</td>
                </tr>
                <tr>
                    <td>[ticketsoort2]</td>
                    <td>aantal</td>
                </tr>
                <tr>
                    <td>[ticketsoort3]</td>
                    <td>aantal</td>
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
                <input type="submit" name="btnSave" class="btnForm"/>
                <br/>
                <?php 
                    if(isset($_POST['btnSave'])) {
                        $header = $_POST['txtHeader'];
                        $newsitem = $_POST['txtNewsitem'];
                        $query = "INSERT INTO newsitem (header,content) VALUES ('$header','$newsitem')";
                        $stm = $conn->prepare($query);
                        if($stm->execute()) {
                            echo "Newsitem added";
                ?>          </form> 
                <?php    
                            $query1 = "SELECT user_id FROM user WHERE email='".$_SESSION['user']."'";
                            $stm = $conn->prepare($query1);
                            $stm->execute();
                            $userdata = $stm->fetch(PDO::FETCH_OBJ);
                            
                            $query2 = "SELECT item_id FROM newsitem WHERE content='$newsitem'";
                            $stm = $conn->prepare($query2);
                            $stm->execute();
                            $itemdata = $stm->fetch(PDO::FETCH_OBJ);

                            $query3 = "INSERT INTO admin_item (user_id,item_id,date) VALUES ($userdata->user_id,$itemdata->item_id,now())";
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
                        <div><input id="txtPreview" name="txtPreview" type="text"><div>
                        <br/>
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
                    </div>

    </div>


</body>
</html>
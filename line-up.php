<?php include("festivaldb.php"); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <title>Line-up</title>
    
</head>
<body>
    <?php require("menu.php"); ?>
    <div class="content" id="line-up-page">
        <div id="tools">
            <form method="POST">
                <div><input type="text" name="txtSearch" id="txtSearch"/>
                <input type="submit" name="btnSearch" value="Search" id="btnSearch" class="btnForm"/></div>
            </form>
        </div>
        <?php 
            
        ?>

        <div id="line-up-container">
    <?php 
        if(isset($_POST['btnSearch'])) {
            $search = "%".$_POST['txtSearch']."%";
            // $searchQuery = "SELECT * FROM lineup WHERE first_name LIKE :zoek OR last_name LIKE :zoek";
            $searchQuery = "SELECT * FROM lineup WHERE CONCAT(first_name,last_name) LIKE :zoek";
            $stm = $conn->prepare($searchQuery);
            $stm->bindParam(":zoek", $search);
            if($stm->execute()) {
                $data = $stm->fetchAll(PDO::FETCH_OBJ);
               
                foreach($data as $artist) {
    ?> 
                    <div class="artist-profile">
                        <div class="artist-profile-side front">
                            <div>
                                <img src="<?= $artist->image;?>"/>
                            </div>
                            
                            <div>
                                <h2><?= $artist->first_name." ".$artist->last_name;?></h2>
                            </div>
                        </div>
                        <div class="artist-profile-side back">
                            <div id="socials-div"> 
                                <div id="links">
                                <a href="<?= $artist->twitterlink;?>"><img src="images/twitter.png"/></a>
                                <a href="<?= $artist->weblink;?>"><img src="images/web.png"/></a>
                                <a href="<?= $artist->preview;?>" target="_blank"><img src="images/youtube.png"/></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                            
    <?php
                }
            }
        } else {

    ?>
    <?php
        $query = "SELECT * FROM lineup";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($data as $artist) {
                
    ?>          
                    <div class="artist-profile">
                        <div class="artist-profile-side front">
                            <div>
                                <img src="<?= $artist->image;?>"/>
                            </div>
                            
                            <div>
                                <h2><?= $artist->first_name." ".$artist->last_name;?></h2>
                            </div>
                        </div>
                        <div class="artist-profile-side back">
                            <div id="socials-div"> 
                                <div id="links">
                                <a href="<?= $artist->twitterlink;?>"><img src="images/twitter.png"/></a>
                                <a href="<?= $artist->weblink;?>"><img src="images/web.png"/></a>
                                <a href="<?= $artist->preview;?>" target="_blank"><img src="images/youtube.png"/></a>
                            </div>
                        </div>
                    </div>
                </div>
                           
    <?php
            }
        }
    }

    ?>
        </div>
    </div>
    
</body>
</html>
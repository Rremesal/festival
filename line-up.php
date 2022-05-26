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
    <div class="content">
        <div id="line-up-container">
    <?php 
        $query = "SELECT * FROM lineup";
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            foreach($data as $artist) {
                
    ?>          <a>
                    <div class="artist-profile">
                        <div class="artist-profile-side front">
                            <div>
                                <img src="<?= $artist->image;?>"/>
                            </div>
                            
                            <div>
                                <h2><?= $artist->first_name, $artist->last_name;?></h2>
                            </div>
                        </div>
                        <div class="artist-profile-side back">
                            <div id="socials-div"> 
                                <a href="<?= $artist->twitterlink;?>"><img src="images/twitter.png"/></a>
                                <a href="<?= $artist->weblink;?>"><img src="images/web.png"/></a>
                                <a href="<?= $artist->preview;?>" target="_blank"><img src="images/youtube.png"/></a>
                            </div>
                        </div>
                    </div>
                </a>            
    <?php
            }
        }

    ?>
        </div>
    </div>
    
</body>
</html>
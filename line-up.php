<?php 
    include("festivaldb.php"); 
    $conn = connectToDB();
?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Line-up</title>
</head>
<body id="lineupBody">
    <?php require("menu.php"); ?>
    <div class="content" id="line-up-page">
        <div id="tools">
            <form method="POST">
                <div>
                    <input type="text" name="txtSearch" id="txtSearch"/>
                    <input type="submit" name="btnSearch" value="Search" id="btnSearch" class="btnForm"/>
                    <input type="submit" name="btnReset" value="See all" id="btnSearch" class="btnForm"/>
                </div>
            </form>
        </div>
        <div id="line-up-container">
    <?php 
        if(isset($_POST['btnSearch'])) {
            $search = "%".$_POST['txtSearch']."%";
            $query = "SELECT * FROM lineup WHERE CONCAT(first_name,last_name) LIKE :search";
            $stm = $conn->prepare($query);
            $stm->bindParam(":search", $search);
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
        <a href="#menu" id="topOfPage"><div>UP</div></a>
    </div>
    <script src="script.js"></script>
</body>
</html>
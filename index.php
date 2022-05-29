<?php include("festivaldb.php"); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css"/>
    <title>Home - </title>
</head>
<body id="home">
    <?php require("menu.php"); ?>
    <section id="section-attention">
        <a href="line-up.php">
            <div class="attention-items">
                <img src="images/line-up-item3.png"/> 
                <div>
                    <h2>New Line-up</h2>
                </div> 
            </div>
        </a>
        <a>
        <div class="attention-items">
            <img src="images/tortuga_item.jpg"/>
            <div>
                <h2>Tickets Now</h2>
            </div>
        </div>
        </a>

    </section>
    <section id="section-newsitems">
        <h2>NEWS</h2>
                <?php 
                $query = "SELECT * FROM newsitem n RIGHT JOIN admin_item ai ON n.item_id=ai.item_id LIMIT 3";
                $stm = $conn->prepare($query);
                if($stm->execute()) {
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    foreach($data as $newsitems) {
                ?>      <div id="newsitem">
                            <div  id="newsitems-date">
                                <?php 
                                $orginalDate = $newsitems->date; 
                                $newDate = date("d-m-Y",strtotime($orginalDate));
                                echo $newDate;
                                ?>
                            </div>
                            <div id="newsitems-content">
                                <h3> <?= $newsitems->header; ?></h3>
                                <p><?= $newsitems->content; ?><p>

                            </div>
                        </div>
                        <br/>
                <?php        
                    }
                    
                } else echo "mislukt";
                ?>
            
            
        

    </section>
    

    
</body>
</html>
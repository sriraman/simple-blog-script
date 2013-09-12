<?php

require('db_connect.php');

$limit = (($_GET['page_num']-1)*5).",5";


       $articles = $db->prepare("SELECT * from article order BY createdAt DESC LIMIT $limit");

        $articles->execute(); 

        
$prev_date = $_GET['prev_date'];

while($article = $articles->fetch())
                {
                    $date = strtotime($article['createdAt']); 

                    $formatted_date = date("F Y",$date);

                    if($formatted_date != $prev_date)
                    {
                        echo "<div class='ss-row'><div class='ss-left'><h2>".date("F",$date)."</h2></div><div class='ss-right'><h2>".date("Y",$date)."</h2></div></div>";
                        $prev_date = $formatted_date;

                    }
                ?>

                <div class="ss-row ss-<?php echo $article['featureSize']; ?>">

                <?php



                if($article['featureImageFloat']=="left")
                    {
                ?>

                    <div class="ss-left">
                        <a href="http://tympanus.net/Tutorials/TypographyEffects/" class="ss-circle" style="background-image: url('<?php echo $article['featuredImage']; ?>');">Typography Effects with CSS3 and jQuery</a>
                    </div>
                    <div class="ss-right">
                        <h3>
                            <span><?php $date = strtotime($article['createdAt']); echo date("F j",$date); ?></span>
                            <a href="http://tympanus.net/Tutorials/TypographyEffects/"><?php echo $article['title']; ?></a>
                        </h3>
                    </div>
                <?php

                }
                else
                {

                ?>      
                    <div class="ss-left">
                        <h3>
                            <span><?php $date = strtotime($article['createdAt']); echo date("F j",$date); ?></span>
                            <a href="http://tympanus.net/Tutorials/TypographyEffects/"><?php echo $article['title']; ?></a>
                        </h3>
                    </div>
                    <div class="ss-right">
                        <a href="http://tympanus.net/Tutorials/TypographyEffects/" class="ss-circle" style="background-image: url('<?php echo $article['featuredImage']; ?>');">Typography Effects with CSS3 and jQuery</a>
                    </div>



                <?php

                }

                ?>
                </div>

                <?php

                }

                ?>

<script type="text/javascript" src="js/modernizr.custom.11333.js"></script>
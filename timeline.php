<?php

require('db_connect.php');



$settings = $db->prepare("SELECT * from admin");

$settings->execute();

$setting = $settings->fetchAll();



$posts = $db->prepare("SELECT COUNT('articleId') from article");
    
$posts->execute();
$post = $posts->fetch();
    
$articles = $db->prepare("SELECT * from article order BY article.createdAt DESC");

$articles->execute();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link href='http://fonts.googleapis.com/css?family=Kelly+Slab' rel='stylesheet' type='text/css' />
		<!--[if lt IE 9]>
				<link rel="stylesheet" type="text/css" href="css/styleIE.css" />
		<![endif]-->
		<script type="text/javascript" src="js/modernizr.custom.11333.js"></script>
		<style>
			body{
				background: #f9f9f9 url(images/cloth.jpg) repeat top left;
			}
		</style>
    </head>
    <body>
        <div class="container">
            
            <h1><?php echo $setting[0]['value']; ?></h1>
            <h2 class="ss-subtitle"><?php echo $setting[1]['value']; ?>'s Timeline</h2>
            <div id="ss-container" class="ss-container">
                


                <?php

                $prev_date = NULL;

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
                        <a href="post.php?id=<?php echo $article['articleId']; ?>" class="ss-circle" style="background-image: url('<?php echo $article['featuredImage']; ?>');"><?php echo $article['title']; ?></a>
                    </div>
                    <div class="ss-right">
                        <h3>
                            <span><?php $date = strtotime($article['createdAt']); echo date("F j",$date); ?></span>
                            <a href="post.php?id=<?php echo $article['articleId']; ?>"><?php echo $article['title']; ?></a>
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
                            <a href="post.php?id=<?php echo $article['articleId']; ?>"><?php echo $article['title']; ?></a>
                        </h3>
                    </div>
                    <div class="ss-right">
                        <a href="post.php?id=<?php echo $article['articleId']; ?>" class="ss-circle" style="background-image: url('<?php echo $article['featuredImage']; ?>');"><?php echo $article['title']; ?></a>
                    </div>



                <?php

                }

                ?>
                </div>

                <?php

                }

                ?>
            </div>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<!-- <script type="text/javascript" src="js/jquery.easing.1.3.js"></script> -->
        <script type="text/javascript">

        var page = 1;

		$(function() {

			var $sidescroll	= (function() {
					
					// the row elements
				var $rows			= $('#ss-container > div.ss-row'),
					// we will cache the inviewport rows and the outside viewport rows
					$rowsViewport, $rowsOutViewport,
					// navigation menu links
					$links			= $('#ss-links > a'),
					// the window element
					$win			= $(window),
					// we will store the window sizes here
					winSize			= {},
					// used in the scroll setTimeout function
					anim			= false,
					// page scroll speed
					scollPageSpeed	= 2000 ,
					// page scroll easing
					scollPageEasing = 'easeInOutExpo',
					// perspective?
					hasPerspective	= true,
					
					perspective		= hasPerspective && Modernizr.csstransforms3d,
					// initialize function
					init			= function() {
						
						// get window sizes
						getWinSize();
						// initialize events
						initEvents();
						// define the inviewport selector
						defineViewport();
						// gets the elements that match the previous selector
						setViewportRows();
						// if perspective add css
						if( perspective ) {
							$rows.css({
								'-webkit-perspective'			: 600,
								'-webkit-perspective-origin'	: '50% 0%'
							});
						}
						// show the pointers for the inviewport rows
						$rowsViewport.find('a.ss-circle').addClass('ss-circle-deco');
						// set positions for each row
						placeRows();
						
					},
					// defines a selector that gathers the row elems that are initially visible.
					// the element is visible if its top is less than the window's height.
					// these elements will not be affected when scrolling the page.
					defineViewport	= function() {
					
						$.extend( $.expr[':'], {
						
							inviewport	: function ( el ) {
								if ( $(el).offset().top < winSize.height ) {
									return true;
								}
								return false;
							}
						
						});
					
					},
					// checks which rows are initially visible 
					setViewportRows	= function() {
						
						$rowsViewport 		= $rows.filter(':inviewport');
						$rowsOutViewport	= $rows.not( $rowsViewport )
						
					},
					// get window sizes
					getWinSize		= function() {
					
						winSize.width	= $win.width();
						winSize.height	= $win.height();
					
					},
					// initialize some events
					initEvents		= function() {
						
						// navigation menu links.
						// scroll to the respective section.
						$links.on( 'click.Scrolling', function( event ) {
							
							// scroll to the element that has id = menu's href
							$('html, body').stop().animate({
								scrollTop: $( $(this).attr('href') ).offset().top
							}, scollPageSpeed, scollPageEasing );
							
							return false;
						
						});
						
						$(window).on({
							// on window resize we need to redefine which rows are initially visible (this ones we will not animate).
							'resize.Scrolling' : function( event ) {
								
								// get the window sizes again
								getWinSize();
								// redefine which rows are initially visible (:inviewport)
								setViewportRows();
								// remove pointers for every row
								$rows.find('a.ss-circle').removeClass('ss-circle-deco');
								// show inviewport rows and respective pointers
								$rowsViewport.each( function() {
								
									$(this).find('div.ss-left')
										   .css({ left   : '0%' })
										   .end()
										   .find('div.ss-right')
										   .css({ right  : '0%' })
										   .end()
										   .find('a.ss-circle')
										   .addClass('ss-circle-deco');
								
								});
							
							},
							// when scrolling the page change the position of each row	
							'scroll.Scrolling' : function( event ) {
								
								// set a timeout to avoid that the 
								// placeRows function gets called on every scroll trigger
								if( anim ) return false;
								anim = true;
								setTimeout( function() {
									
									placeRows();
									anim = false;
									
								}, 10 );
							
							}
						});
					
					},
					// sets the position of the rows (left and right row elements).
					// Both of these elements will start with -50% for the left/right (not visible)
					// and this value should be 0% (final position) when the element is on the
					// center of the window.
					placeRows		= function() {
						
							// how much we scrolled so far
						var winscroll	= $win.scrollTop(),
							// the y value for the center of the screen
							winCenter	= winSize.height / 2 + winscroll;
						
						// for every row that is not inviewport
						$rowsOutViewport.each( function(i) {
							
							var $row	= $(this),
								// the left side element
								$rowL	= $row.find('div.ss-left'),
								// the right side element
								$rowR	= $row.find('div.ss-right'),
								// top value
								rowT	= $row.offset().top;
							
							// hide the row if it is under the viewport
							if( rowT > winSize.height + winscroll ) {
								
								if( perspective ) {
								
									$rowL.css({
										'-webkit-transform'	: 'translate3d(-75%, 0, 0) rotateY(-90deg) translate3d(-75%, 0, 0)',
										'opacity'			: 0
									});
									$rowR.css({
										'-webkit-transform'	: 'translate3d(75%, 0, 0) rotateY(90deg) translate3d(75%, 0, 0)',
										'opacity'			: 0
									});
								
								}
								else {
								
									$rowL.css({ left 		: '-50%' });
									$rowR.css({ right 		: '-50%' });
								
								}
								
							}
							// if not, the row should become visible (0% of left/right) as it gets closer to the center of the screen.
							else {
									
									// row's height
								var rowH	= $row.height(),
									// the value on each scrolling step will be proporcional to the distance from the center of the screen to its height
									factor 	= ( ( ( rowT + rowH / 2 ) - winCenter ) / ( winSize.height / 2 + rowH / 2 ) ),
									// value for the left / right of each side of the row.
									// 0% is the limit
									val		= Math.max( factor * 50, 0 );
									
								if( val <= 0 ) {
								
									// when 0% is reached show the pointer for that row
									if( !$row.data('pointer') ) {
									
										$row.data( 'pointer', true );
										$row.find('.ss-circle').addClass('ss-circle-deco');
									
									}
								
								}
								else {
									
									// the pointer should not be shown
									if( $row.data('pointer') ) {
										
										$row.data( 'pointer', false );
										$row.find('.ss-circle').removeClass('ss-circle-deco');
									
									}
									
								}
								
								// set calculated values
								if( perspective ) {
									
									var	t		= Math.max( factor * 75, 0 ),
										r		= Math.max( factor * 90, 0 ),
										o		= Math.min( Math.abs( factor - 1 ), 1 );
									
									$rowL.css({
										'-webkit-transform'	: 'translate3d(-' + t + '%, 0, 0) rotateY(-' + r + 'deg) translate3d(-' + t + '%, 0, 0)',
										'opacity'			: o
									});
									$rowR.css({
										'-webkit-transform'	: 'translate3d(' + t + '%, 0, 0) rotateY(' + r + 'deg) translate3d(' + t + '%, 0, 0)',
										'opacity'			: o
									});
								
								}
								else {
									
									$rowL.css({ left 	: - val + '%' });
									$rowR.css({ right 	: - val + '%' });
									
								}
								
							}	
						
						});
					
					};
				
				return { init : init };
			
			})();
			
			$sidescroll.init();
			
		});
    
// Code to update the timeline dynamically . 

         // $(window).scroll(function () {
         //        var height = $(document).height();

         //        if($(window).scrollTop() + $(window).height() < $(document).height() - 100) {
         //            $('#more').hide();
         //            $('#no-more').hide();
         //        }
         //        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
         //            $('#more').css("top","400");
         //            $('#more').show();
         //        }
         //        if($(window).scrollTop() + $(window).height() == $(document).height()) {

         //            $('#more').hide();
         //            $('#no-more').hide();

         //            page++;

         //            var data = {
         //                page_num: page,
         //                prev_date: "<?php echo $prev_date; ?>"
         //            };

         //            var actual_count = <?php echo $post['0']; ?>;

         //            if((page-1)* 5 > actual_count){
         //                $('#no-more').css("top","400");
         //                $('#no-more').show();
         //            }else{
         //                $.ajax({
         //                    type: "GET",
         //                    url: "timelineData.php",
         //                    data:data,
         //                    success: function(res) {
         //                        $("#ss-container").append(res);

         //                        $.ajax({

         //                            url: 'js/modernizr.custom.11333.js',

         //                            dataType: 'script'

         //                        });


         //                    }
         //                });
         //            }
         //        }
         //    });

		</script>
    </body>
</html>
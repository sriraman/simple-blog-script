<?php

require('../db_connect.php');



/***

 Table structure for table `article`

**/


$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS `article` (
  `articleId` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` MEDIUMTEXT NOT NULL,
  `featureSize` enum('small','medium','large') NOT NULL,
  `featureImageFloat` enum('left','right') NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdAt` timestamp NULL DEFAULT NULL,
  `featuredImage` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`articleId`) 
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

$stmt->execute();

/***

Table structure for table `articleCategory`

**/

$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS `articlecategory` (
  `articleId` int(11) NOT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

$stmt->execute();



/***
   Table structure for table `newsletter`
**/

$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS `newsletter` (
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `email` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
)  ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

$stmt->execute();




/***
	 Table structure for table `category`
**/

$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS `category` (
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$stmt->execute();


/***
 Table structure for table `admin`
**/

$stmt = $db -> prepare("CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

$stmt->execute();


/***
  Default content for table `admin`
**/



$stmt = $db->prepare("INSERT INTO `admin` (`id`, `option`, `value`) VALUES
(1, 'title', 'Sinkara'),
(2, 'authorName' , 'Sriraman'),
(3, 'profilePic', ''),
(4, 'fburl' , 'http://facebook.com/sri.smartkiller'),
(5, 'gpurl' , 'http://plus.google.com/sriraman'),
(6, 'twitterurl','http://twitter.com/sriraman2'),
(7, 'email',''),
(8, 'password' , ''),
(9, 'footer', 'powered by xxxxx'),
(10, 'logo', 'default_logo.png')");

$stmt->execute();

$_SESSION['flash_notice'] = "Initial Installation completed :)";

header('Location: setup.php');

?>
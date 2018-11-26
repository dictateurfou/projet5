<?php 


/*route*/
$controller->addRoute("account");
$controller->addRoute("post");
$controller->addRoute("contact");
$controller->addRoute("home");

$controller->addRoute("adminPanel");
/*fin route*/
$controller->control();
/* include is for action in top at this controller
(replace after per anotation)
 */
include "Controller/".$controller->getController();

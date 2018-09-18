<?php 


/*route*/
$controller->addRoute("account");
$controller->addRoute("post");
/*fin route*/
$controller->control();
include "Controller/".$controller->getController();
$result = $controller->checkAction();

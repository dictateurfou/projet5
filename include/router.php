<?php 


/*route*/
$controller->addRoute("account");
/*fin route*/
$controller->control();
include "Controller/".$controller->getController();
$result = $controller->checkAction();

<?php 


/*route*/
$controller->addRoute("account");
/*fin route*/
$controller->control();
include "controller/".$controller->getController();
$result = $controller->checkAction();

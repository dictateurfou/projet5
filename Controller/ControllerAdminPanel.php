<?php

$controller->addAction('', true, true);
$controller->addAction('addPost', true, true);
$controller->addAction('accountValidation/state/id', true, true);
$controller->addAction('commentValidation/state/id', true, true);


class ControllerAdminPanel
{
    public static function defaut()
    {
        $presentation = "Dévelloppeur full stack capable de réaliser vos application les plus folles seul votre imagination es une limite.";
    }

    public static function accountValidation()
    {
        $userManager = new Manager\UserManager();
        if (empty($_GET['id']) !== true && empty($_GET['state']) !== true) {
            $id = $_GET["id"];
            $state = $_GET["state"];
            $userManager->validate($state, $id);
        }
        return ["validation" => $userManager->accountInvalid()];
    }

    public static function addPost()
    {
        if (array_key_exists('image', $_FILES)) {
            $image = new \Entity\File($_FILES['image']);
            if (!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0 && $image->checkValidExtension(array('jpg','jpeg','png'))) {
                $name = md5(uniqid(rand(), true)).'.'.$image->checkType();
                $target = 'post/'.$name;
                $image->changeFolder($target);
                $postManager = new \Manager\PostManager();
                /* mettre post en objet */
                $postManager->addPost($_POST['title'], $target, $_POST['content']);
            }
        }
    }

    public static function commentValidation()
    {
        $commentManager = new Manager\CommentManager();
        if (empty($_GET['id']) !== true && empty($_GET['state']) !== true) {
            $id = $_GET["id"];
            $state = $_GET["state"];
            $commentManager->validate($state, $id);
        }
        return ["comments" => $commentManager->getInvalidComment()];
    }
}

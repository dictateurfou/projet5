<?php
/*LOAD ROUTE ACTION*/


$controller->addAction('viewAll', false, false, ["edit","delete"]);
$controller->addAction("view/id", false, false);
$controller->addAction('addComment/post', true, false);
$controller->addAction('edit/id', true, true);
$controller->addAction('delete/id', true, true);

class ControllerPost
{
    public static function viewAll()
    {
        $postManager = new \Manager\PostManager();
        return ["articles" => $postManager->viewAll()];
    }

    public static function view()
    {
        if (array_key_exists('id', $_GET)) {
            $postManager = new \Manager\PostManager();
            $commentManager = new \Manager\CommentManager();
            $article = $postManager->view($_GET['id']);
            if ($article !== false) {
                $test = ["header" => ["view" => "header/post.twig","article" => $article,"user"=> $article->getAuthor()->getName()],
                "article" => $article,
                "comments" => $commentManager->getComment($_GET['id'])];
                return $test;
            } else {
                header('Location: /index.php');
            }
        } else {
            header('Location: /index.php');
        }
    }


    public static function addComment()
    {
        if (!empty($_POST['content'])) {
            $commentManager = new \Manager\CommentManager();
            $commentManager->addComment($_GET['post'], $_SESSION['id'], $_POST['content']);
            header('Location: /post/view/'.$_GET['post']);
        }
    }

    public static function edit()
    {
        $postManager = new \Manager\PostManager();

        if (!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 4 && !empty($_GET['id'])) {
            $postManager->edit($_POST['title'], $_POST['content'], $_GET['id']);
        }
        /*si post avec image*/
        elseif (!empty($_POST['title']) && !empty($_POST['content']) && $_FILES['image']['error'] == 0 && !empty($_GET['id'])) {
            $image = new \Entity\File($_FILES['image']);
            if ($image->checkValidExtension(array('jpg','jpeg','png'))) {
                $name = md5(uniqid(rand(), true)).'.'.$image->checkType();
                $target = 'post/'.$name;
                $image->changeFolder($target);
                $postManager->edit($_POST['title'], $_POST['content'], $_GET['id'], $target);
                /*ajouter redirection*/
                header('Location: /index.php?post&action=view&id='.$_GET['id']);
            }
        } else {
            if (!empty($_GET['id'])) {
                $article = $postManager->view($_GET['id']);
                if ($article !== false) {
                    return ["article" => $article];
                } else {
                    /* redirect post inconnu */
                }
            } else {
                /* redirect */
            }
        }
    }
    
    public static function delete()
    {
        if (array_key_exists('id', $_GET)) {
            $postManager = new \Manager\PostManager();
            $postManager->delete($_GET['id']);
            header('Location: /index.php?post&action=viewAll');
        }
    }
}

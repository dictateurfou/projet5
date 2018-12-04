<?php
namespace Controller;

/*for twig component*/
require_once("vendor/autoload.php");

class Controller
{
    private $vue;
    private $controller;
    private $route;
    private $routeList = [];
    private $action = false;
    private $url;
    private $header = [];
    private $menu = 'menu/default'.self::EXTENSIONVIEW;
    private $data = [];
    private $urlExplode;
    const EXTENSIONCLASSE = '.php';
    const EXTENSIONVIEW = '.twig';
    const DEFAULTPAGE = 'home';
    const DEFAULTACTION = '';
    const DEFAULTBANNER = "/assets/img/home-bg.png";
    const DEFAULT_TITLE = "Mon Blog";
    const DEFAULTSUBTITLE = "Un blog parlant de développement";
    const DEFAULTHEADER = "header/default.twig";
    public function __construct()
    {
        $this->url = ltrim($_SERVER['REQUEST_URI'], '/');
        $this->urlExplode = explode('/', $this->url);
    }
    public function control()
    {
        $find = false;
        $i = 0;
        $namespace = explode('/', $this->url)[0];
        while (count($this->routeList) > $i) {
            /*cherche si ?routeList es spécifier en rapport avec les routeLists principals*/
            if ($this->routeList[$i]['name'] == $namespace) {
                $this->route = $this->routeList[$i]['name'];
                $this->vue = $this->routeList[$i]['name']."/";
                $this->controller = "Controller".ucfirst($this->routeList[$i]['name']);
                $find = true;
            }
            $i++;
        }
        /*si aucune route trouver on redirige vers la route par defaut */
        if ($find == false) {
            header('Location: /'.self::DEFAULTPAGE.'/'.self::DEFAULTACTION);
        }
    }
    public function getvue()
    {
        return $this->vue.self::EXTENSIONVIEW;
    }
    public function getController()
    {
        return $this->controller.self::EXTENSIONCLASSE;
    }

    public function setHeader($routeName)
    {
        $this->header = $header;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setVue()
    {

    }

    private function setMenu($routeName)
    {
        $userManager = new \Modal\UserManager();
        if($routeName !== "adminPanel"){
            if (array_key_exists('id', $_SESSION) === true) {
                if ($userManager->userHaveRight("adminPanel", '') === true) {
                    $this->menu = 'menu/adminMenu'.self::EXTENSIONVIEW;
                } else {
                    $this->menu = 'menu/connected'.self::EXTENSIONVIEW;
                }
            } else {
                $this->menu = 'menu/default'.self::EXTENSIONVIEW;
            }
        }
        $this->setData(["menu" => $this->menu]);
    }

    private function checkAuth($action){
        $userManager = new \Modal\UserManager();
        $passed = true;

        /* si connecter on rafraichi l'user en bdd */
        if (array_key_exists('id', $_SESSION)) {
            $_SESSION['user'] = $userManager->getUserById($_SESSION['id']);
        }

        if ($action["connected"] == true) {
            if (!array_key_exists('id', $_SESSION)) {
                $passed = false;
            } elseif ($action["restricted"] === true && $userManager->userHaveRight($this->route, $action["name"]) === false) {
                $passed = false;
            }
        }

        if (array_key_exists('restrictedSubAction', $action) && $passed !== false && array_key_exists('id', $_SESSION) === true) {
            $this->setData(["right" => $userManager->userHaveMultipleRight($this->route, $action['restrictedSubAction'])]);
        }

        return $passed;
    }

    private function setData($data)
    {
        foreach ($data as $key => $value){
            $this->data[$key] = $value;
        }
    }

    private function executeAction($className,$methodName)
    {
        if ($methodName === "") {
            $result = $className::defaut();
            if($result !== null){
                $this->setData($result);
            }
            if ($this->urlExplode[0] == "adminPanel") {
                $this->vue = "defaut";
            } else {
                $this->vue = $this->urlExplode[0].'/defaut';
            }
        } else {
            $result = $className::$methodName();
            if($result !== null){
                $this->setData($result);
            }
        }
    }

    private function checkAction()
    {
        $actionOffset = 1;
        $actionIndex;
        $defautAction = false;
        $data = ["passed" => false,"className" => "\Controller\\".$this->controller,"methodName" => "defaut"];
        if (array_key_exists($actionOffset, $this->urlExplode) === false) {
            $this->urlExplode[1] = "";
            $defautAction = true;
            if ($this->urlExplode[0] !== "adminPanel") {
                $this->vue = $this->urlExplode[0]."/defaut";
            } else {
                $this->vue = "/defaut";
            }
        }

        if (array_key_exists($actionOffset, $this->urlExplode)) {
            $i = 0;
            while ($i < count($this->action)) {
                $actionExplode = explode('/', $this->action[$i]["name"]);
                /*si l'action contient des paramètre on lui attribut au tableau get et sont défini dans l'url actuelle*/
                if (isset($this->urlExplode[2]) && strpos($this->action[$i]["name"], "/") !== false) {
                    $this->action[$i]["name"] = $actionExplode[0];
                    $e = 1;
                    while ($e < count($actionExplode)) {
                        $_GET[$actionExplode[$e]] = $this->urlExplode[$e+1];
                        $e++;
                    }
                }
                /*sinon si l'argument n'est pas défini dans l'url et que la route correspond (pour les url avec paramètre optionel) */
                elseif (!isset($this->urlExplode[2]) && strpos($this->action[$i]["name"], "/") !== false) {
                    $this->action[$i]["name"] = $actionExplode[0];
                }
                /* ici on check si l'action correspond a l'url */
                if ($this->urlExplode[$actionOffset] == $this->action[$i]["name"]) {
                    $data["className"] = $this->controller;
                    /*si on es sur l'action par défaut*/
                    if ($defautAction == false) {
                        $data["methodName"] = $this->action[$i]["name"];
                        $this->vue = $this->vue.$this->action[$i]["name"];
                        $actionIndex = $i;
                    } else {
                        $this->vue = $this->vue.$this->action[$i]["name"];
                        $actionIndex = $i;
                    }
                    $data["passed"] = $this->checkAuth($this->action[$i]);

                }
                $i++;
            }
        }
        return $data;
    }
    
    public function render()
    {
        $find = false;
        $userManager = new \Modal\UserManager();

        $checkAction = $this->checkAction();
        $find = $checkAction["passed"];
        /*si page n'existe pas on redirige*/
        if ($find == false) {
            /*si aucune action ne correspond a la routeList on redirige vers la route par défaut */
            header('Location: /'.self::DEFAULTPAGE.'/'.self::DEFAULTACTION);
        }
        /*sinon (condition obliger sinon éxecute quand même l'action avant redirection)*/
        else {
            $this->setMenu($this->urlExplode[0]);
            /*si on doit rajouter une aplication rajouter une condition*/
            if ($this->urlExplode[0] == "adminPanel") {
                if ($this->vue !== "/defaut") {
                    $this->vue = $this->action[$actionIndex]["name"];
                }
                $loaderTwig = new \Twig_Loader_Filesystem('./View/adminPanel');
                $twig = new \Twig_Environment($loaderTwig);
            } else {
                $loaderTwig = new \Twig_Loader_Filesystem('./View');
                $twig = new \Twig_Environment($loaderTwig);
            }

            $this->executeAction($checkAction['className'],$checkAction['methodName']);
            if ($this->data !== null) {
                if (array_key_exists('header', $this->data) === false) {
                    $this->setData(["header" => ["view" => self::DEFAULTHEADER,"title" => self::DEFAULT_TITLE,"subtitle" => self::DEFAULTSUBTITLE,"img" => self::DEFAULTBANNER]]);
                }
                
                /*verifier array key header (retour de className::methodName)*/
                return $twig->render($this->data["header"]["view"], $this->data["header"]).$twig->render($this->vue.self::EXTENSIONVIEW, $this->data);
            } else {
                $header = ["view" => self::DEFAULTHEADER,"title" => self::DEFAULT_TITLE,"subtitle" => self::DEFAULTSUBTITLE,"img" => self::DEFAULTBANNER];
                return $twig->render($header["view"], $header).$twig->render($this->vue.self::EXTENSIONVIEW, ["nothing" => "","menu" => $this->menu]);
            }
        }
    }

    public function addRoute($name)
    {
        array_push($this->routeList, ["name" => $name]);
    }
    public function addAction($name, $connected, $restricted, $restrictedSubAction = null)
    {
        if ($this->action == false) {
            $this->action = [];
        }

        if ($restrictedSubAction !== null) {
            array_push($this->action, ["name" => $name,"connected" => $connected,'restricted' => $restricted,'restrictedSubAction' => $restrictedSubAction]);
        } else {
            array_push($this->action, ["name" => $name,"connected" => $connected,'restricted' => $restricted]);
        }
    }
}

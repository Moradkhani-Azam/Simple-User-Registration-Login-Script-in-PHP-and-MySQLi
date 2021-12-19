<?php

namespace App\Controllers;

use App\Models\Link;
use core\Connector;
use App\helpers\Validator;

class AdminController
{
    private $connector;
    private $connection;

    public function __construct()
    {
        if (!isset($_SESSION["token"]) || !$_SESSION["token"]) {
            header('Location: ' .  $_SERVER['SCRIPT_NAME']);
            exit;
        }
        require_once  __DIR__ . "/../../Core/Connector.php";

        $this->connector = new Connector();
        $this->connection = $this->connector->Connection();
    }

    public function index()
    {
        $link = new Link($this->connection);
        $links = $link->getAll();

        $this->view("index", array(
        "title" => "لیست دامنه",
        "links" => $links
        ));
    }

    public function create()
    {
        $this->view("create");
    }

    public function store()
    {
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        if (!$token || $token !== $_SESSION['token']) {
            header('Location: ' .  $_SERVER['SCRIPT_NAME']);
            exit;
        } else {
            $rules = ['url' => ['required', 'url']];

            $validate = new Validator();
            $validate->validate($_POST, $rules);

            if(!$validate->error()) {
                $model = new link($this->connection);
                $existUrl = $model->checkUniqUrl($_POST["url"]);

                if(!$existUrl) {
                    $link = new Link($this->connection);
                    $link->url = $_POST["url"];
                    $shortened = substr(md5(rand()), 0, 7);
                    $model = new link($this->connection);
                    while($model->checkUniqShortened($shortened)) {
                        $model = new link($this->connection);
                        $shortened = substr(md5(rand()), 0, 7);
                    }
                    $link->shortened = $shortened;
                    $link->user_id = $_SESSION["user_id"];

                    $id = $link->save();
                    $link->id = $id;
                    redirect('index');
                } else {
                    $_SESSION["error"][] =["آدرس لینک تکراری است."];
                    redirect('create');
                }
            } else {
                $_SESSION["error"] = $validate->error();
                redirect('create');
            }
        }
    }

    public function edit()
    {
        if(isset($_GET['id']) && $_GET['id']) {
            $model = new Link($this->connection);
            $link = $model->getById($_GET['id']);
            if($link)
                $this->view("edit", array(
                'title' => 'ویرایش لینک',
                'link' => $link
                ));
            else redirect('index');
        } else redirect('index');
    }

    public function update()
    {
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        if (!$token || $token !== $_SESSION['token']) {
            header('Location: ' .  $_SERVER['SCRIPT_NAME']);
            exit;
        } else {
            $rules = [
                'url' => ['required', 'url'],
                'shortened' => ['shortened', 'minLen' => 6,'maxLen' => 6, 'alpha']
            ];

            $validate = new Validator();
            $validate->validate($_POST, $rules);

            if(!$validate->error() && isset($_POST["id"])) {
                $model = new link($this->connection);
                $existUrl = $model->checkUniqUrl($_POST["url"]);
                $model = new link($this->connection);
                $existShortened = $model->checkUniqShortened($_POST["shortened"]);
      
                if((!$existUrl || $existUrl->id == $_POST["id"])  && (!$existShortened || $existShortened->id == $_POST["id"])) {
                    $link = new Link($this->connection);
                    $link->id = $_POST["id"];
                    $link->url = $_POST["url"];
                    $link->shortened = $_POST["shortened"];
                    $save = $link->update();
                    redirect('index');

                } else {
                    $_SESSION["error"][] = ["آدرس  لینک یا لینک کوتاه شده تکراری است!"];
                    redirect('edit?&id='.$_POST["id"]);
                }
            } else {
                $_SESSION["error"] = $validate->error();
                redirect('edit?&id='.$_POST["id"]);
            }
        }
    }

    public function destroy()
    {
        if(isset($_POST["id"])) {
            $link = new Link($this->connection);
            $link->deleteById($_POST["id"]);
        }
        redirect('index');
    }

    public function view($view, $data=array())
    {
        $data = $data;
        require_once  __DIR__ . "/../../views/Admin/" . $view . ".php";
    }
}
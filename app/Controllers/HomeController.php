<?php
namespace App\Controllers;

use App\Models\User;
use core\Connector;
use App\helpers\Validator;

class HomeController {
	private $connector;
	private $connection;

	public function __construct()
	{
		require_once  __DIR__ . "/../../Core/Connector.php";

		$this->connector = new Connector();
		$this->connection = $this->connector->Connection();		
	}

	public function index()
	{
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
			redirect('admin/links/index');
		} else {
			$this->view("index");
		}
	}

	public function register()
	{
		$rules = [
		    'name' => ['required', 'minLen' => 6,'maxLen' => 150, 'string'],
		    'email' => ['required', 'email'],
		    'password' => ['required', 'minLen' => 8]
		];

		$validate = new Validator();
		$validate->validate($_POST, $rules);

		if(!$validate->error()) {
			$model = new User($this->connection);
			$existEmail = $model->checkUniqEmail($_POST["email"]);

			if(!$existEmail) {
				$user = new User($this->connection);
				$user->name = $_POST["name"];
				$user->email = $_POST["email"];
				$hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
				$user->password = $hash;
				$id = $user->save();
				$_SESSION['token'] = md5(uniqid(mt_rand(), true));
				$_SESSION["loggedIn"] = true;
				$_SESSION["user_id"] = $id;
				$_SESSION["email"] = $user->email;
				redirect('admin/links/index');
			} else {
				$_SESSION["error"][] = ["آدرس ایمیل تکاری است."];
				redirect('index.php');
			}
		} else {
			// $_SESSION["error"] = "فیلدهای خالی را پر کنید.";
			$_SESSION["error"] = $validate->error();
			redirect('index.php');
		}
	}

	public function loginPage()
	{
		$this->view("login");
	}

	public function login()
	{
		$rules = [
		    'email' => ['required'],
		    'password' => ['required']
		];

		$validate = new Validator();
		$validate->validate($_POST, $rules);

		if(!$validate->error()) {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$model = new User($this->connection);

			$user = $model->checkUser($email, $password);
			
			if ($user) {
				$_SESSION['token'] = md5(uniqid(mt_rand(), true));
				$_SESSION["loggedIn"] = true;
				$_SESSION["user_id"] = $user->id;
				$_SESSION["email"] = $email;
				redirect('admin/links/index');
			} else {

				$_SESSION["loggedIn"] = false;

				$_SESSION["error"][] = ["اطلاعات نادرست است."];
				redirect('loginPage');
			}
		} else {
			// $_SESSION["error"] = "فیلدهای خالی را پر کنید.";
			$_SESSION["error"] = $validate->error();
			redirect('loginPage');
		}
	}

	public function logOut()
	{
		session_unset();
		session_destroy();
		redirect('index.php');
		exit;
	}

	public function view($view, $data=array()){
		$data = $data;
		require_once  __DIR__ . "/../../views/" . $view . ".php";
	}
}
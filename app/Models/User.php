<?php
namespace App\Models;

class User {
	private $table = "users";
	private $connection;
	private $id;
	private $name;
	private $email;
	private $password;

	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	public function __get($property)
	{
	    if (property_exists($this, $property)) {
	      return $this->$property;
	    }
	}

	public function __set($property, $value)
	{
	    if (property_exists($this, $property)) {
	      $this->$property = $value;
	    }
	    return $this;
	}

	public function save(){
		$consultation = $this->connection->prepare("INSERT INTO " . $this->table . " (name,email,password)
		VALUES (:name,:email,:password)");
		$result = $consultation->execute(array(
			"name" => $this->name,
			"email" => $this->email,
			"password" => $this->password
		));
		$id = $this->connection->lastInsertId();
		$this->connection = null;

		return $id;
	}

	public function checkUser($email, $password)
	{
		$consultation = $this->connection->prepare("SELECT *
		FROM " . $this->table . "  WHERE email = :email");
		$consultation->execute(array(
			"email" => $email
		));

		$result = $consultation->fetchObject();
		$this->connection = null; 
		if(password_verify($password, $result->password))
			return $result;
	}

	public function checkUniqEmail($email)
	{
		$consultation = $this->connection->prepare("SELECT *
		FROM " . $this->table . "  WHERE email = :email");
		$consultation->execute(array(
			"email" => $email
		));

		$result = $consultation->fetchObject();
		$this->connection = null;
		return $result;
	}
}
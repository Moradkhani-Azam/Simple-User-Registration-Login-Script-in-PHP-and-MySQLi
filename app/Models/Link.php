<?php
namespace App\Models;

class Link {
	private $table = "links";
	private $connection;
	private $id;
	private $url;
	private $shortened;

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

	public function getAll()
	{
		$consultation = $this->connection->prepare("SELECT id,url,shortened FROM " . $this->table);
		$consultation->execute();
		$resultados = $consultation->fetchAll();
		$this->connection = null;
		return $resultados;
	}


	public function save()
	{
		$consultation = $this->connection->prepare("INSERT INTO " . $this->table . " (url,shortened,user_id)
		VALUES (:url,:shortened,:user_id)");
		$result = $consultation->execute(array(
			"url" => $this->url,
			"shortened" => $this->shortened,
			"user_id" => $this->user_id
		));
		$id = $this->connection->lastInsertId();
		$this->connection = null;

		return $id;
	}

	public function update()
	{
		$consultation = $this->connection->prepare("
		UPDATE " . $this->table . "
		SET
			url = :url,
			shortened = :shortened
		WHERE id = :id 
		");

		$result = $consultation->execute(array(
			"id" => $this->id,
			"url" => $this->url,
			"shortened" => $this->shortened
		));

		$this->connection = null;
		return $result;
	}

	public function getById($id)
	{
		$consultation = $this->connection->prepare("SELECT * FROM " . $this->table . "  WHERE id = :id");
		$consultation->execute(array(
			"id" => $id
		));

		$result = $consultation->fetchObject();
		$this->connection = null;
		return $result;
	}


	public function deleteById($id)
	{
		try {
			$consultation = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
			$consultation->execute(array(
				"id" => $id
			));
			$connection = null;
		} catch (Exception $e) {
			echo 'Failed DELETE (deleteById): ' . $e->getMessage();
			return -1;
		}
	}

	public function checkUniqUrl($url)
	{
		$consultation = $this->connection->prepare("SELECT * FROM " . $this->table . "  WHERE url = :url");
		$consultation->execute(array(
			"url" => $url
		));

		$result = $consultation->fetchObject();
		$this->connection = null;
		return $result;
	}

	public function checkUniqShortened($shortened)
	{
		$consultation = $this->connection->prepare("SELECT * FROM " . $this->table . "  WHERE shortened = :shortened");
		$consultation->execute(array(
			"shortened" => $shortened
		));

		$result = $consultation->fetchObject();
		$this->connection = null;
		return $result;
	}
}
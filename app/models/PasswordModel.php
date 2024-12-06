<?php
include("./app/config/database.php");

class PasswordModel extends database{
    private $id;
    private $user;
    private $name;
    private $password;
    private $description;
    private $date;


    // Constructor con valores por defecto NULL
    public function __construct($id = NULL, $user = NULL, $name = NULL, $password = NULL, $description = NULL, $date = NULL) {
        $this->id = $id;
        $this->user = $user;
        $this->name = $name;
        $this->password = $password;
        $this->description = $description;
        $this->date = $date;
        $this->connect();
    }

    // Getter y Setter para 'id'
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter y Setter para 'user'
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    // Getter y Setter para 'name'
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Getter y Setter para 'password'
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Getter y Setter para 'date'
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }
    
    public function getAllByUser(string $user)
    {
        $sql = 'SELECT * FROM password WHERE user = :user';
        $parametros = array(":user" => $user) ;

        return $response = $this->query($sql, $parametros);
    }

    public function createPassword($user, $name, $password, $description)
    {
        $sql = "INSERT INTO password (user, name, password, description, date) 
                VALUES (:user, :name, :password, :description, :date)";

        $parametros = array(':user' => $user, ':name' => $name, ':password' => $password, ":description" => $description, ":date" => date('Y-m-d'));
        return $this->query($sql, $parametros);
    }

    public function deletePasswordById($id)
    {
        $sql = "DELETE FROM password WHERE id = :id";
        return $this->query($sql, [':id' => $id]);
    }

    public function updatePassword($id, $name, $password, $password_description)
    {
        $sql = "UPDATE password SET name = :name, password = :password, description = :description
                WHERE id = :id";

        $parametros = array(":id"=> $id, ':name' => $name, ':password' => $password, ':description' => $password_description);
        return $this->query($sql, $parametros);
    }
}
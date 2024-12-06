<?php

require_once("app/config/database.php");

class UserModel extends database
{
    private $id;
    private $name;
    private $username;
    private $password;
    private $db;

    public function __construct(){
        $this->connect();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter y Setter para $name
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // Getter y Setter para $username
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    // Getter y Setter para $password
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function authenticate(string $username, string $password)
    {
        $sql = 'SELECT * FROM user WHERE username = :username AND password = :password';
        $parametros = array(":username" => $username, "password" => $password) ;
        return $response = $this->query($sql, $parametros);
    }

    public function createUser(string $username, string $password)
    {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $parametros = array(':username' => $username, ':password' => password_hash($password, PASSWORD_DEFAULT));
        return $this->query($sql, $parametros);
    }

    public function deleteUserById(int $id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->query($sql, [':id' => $id]);
    }
}

<?php
namespace NeyShiKu\CleanlyGo\Models;

abstract class Users {
    protected int $idUser;
    protected string $email;
    protected string $password;

    public function __construct(int $idUser) {
        $this->idUser = $idUser;
    }

    public function getIdUser(): int {
        return $this->idUser;
    }
       
}
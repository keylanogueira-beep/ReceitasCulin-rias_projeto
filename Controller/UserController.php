<?php

namespace Controller;

use Model\User;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    private function validateEmptyFields(string $name, string $email, string $password): bool
    {
        if (empty($name) or empty($email) or empty($password)) {
            return false;
        }

        return true;
    }

    private function validateUserEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function passwordValidation(string $password): bool
    {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,33}$/';

        return (bool) preg_match($pattern, $password);
    }

    private function hashPassword(string $password): string
    {
        $options = [
            "memory_cost" => 1 << 17,
            "time_cost" => 4,
            "threads" => 2
        ];

        return password_hash($password, PASSWORD_ARGON2ID, $options);
    }

    public function getUserData(int $id): array|bool
    {
        return $this->userModel->getUserInfo($id);
    }

    public function createUser(string $name, string $email, string $password): bool
    {
        if (!$this->validateEmptyFields($name, $email, $password)) {
            return false;
        }

        if (!$this->validateUserEmail($email)) {
            return false;
        }

        if (!$this->passwordValidation($password)) {
            return false;
        }

        $hashedPassword = $this->hashPassword($password);

        return $this->userModel->registerUser($name, $email, $hashedPassword);
    }

    public function checkUserByEmail(string $email): bool
    {
        return (bool) $this->userModel->getUserByEmail($email);
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userModel->getUserByEmail($email);

        if (!$user or !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        return true;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }
}

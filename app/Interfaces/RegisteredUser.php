<?php
namespace App\Interfaces;
interface RegisteredUser
{
    public function getId(): int;
    public function getFirstName(): string;
    public function getLastName(): string;
}

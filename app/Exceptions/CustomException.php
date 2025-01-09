<?php

namespace App\Exceptions;

interface CustomException
{
    public function getResponseCode(): int;
}

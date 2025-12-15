<?php

namespace common\domain\Apple\Exception;

final class CannotEatRottenAppleException extends AppleDomainException
{
    protected $message = 'Съесть нельзя: яблоко испортилось';
}

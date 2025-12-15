<?php

namespace common\domain\Apple\Exception;

final class InvalidEatPercentException extends AppleDomainException
{
    protected $message = 'Процент должен быть от 1 до 100';
}

<?php

namespace common\domain\Apple\Exception;

final class CannotEatMoreThanLeftException extends AppleDomainException
{
    protected $message = 'Нельзя съесть больше, чем осталось';
}

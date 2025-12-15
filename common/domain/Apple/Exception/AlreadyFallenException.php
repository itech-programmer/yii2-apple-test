<?php

namespace common\domain\Apple\Exception;

final class AlreadyFallenException extends AppleDomainException
{
    protected $message = 'Яблоко уже упало';
}

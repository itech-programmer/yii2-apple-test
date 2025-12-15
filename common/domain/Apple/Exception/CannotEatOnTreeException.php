<?php

namespace common\domain\Apple\Exception;

final class CannotEatOnTreeException extends AppleDomainException
{
    protected $message = 'Съесть нельзя: яблоко висит на дереве';
}

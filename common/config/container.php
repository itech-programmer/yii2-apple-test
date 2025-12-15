<?php

use common\contracts\Apple\AppleFactoryInterface;
use common\contracts\Apple\AppleRepositoryInterface;
use common\contracts\Apple\AppleServiceInterface;
use common\repositories\Apple\AppleRepository;
use common\services\Apple\AppleFactory;
use common\services\Apple\AppleService;

return [
    AppleRepositoryInterface::class => AppleRepository::class,
    AppleFactoryInterface::class => AppleFactory::class,
    AppleServiceInterface::class => AppleService::class,
];

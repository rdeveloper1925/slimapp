<?php
use function DI\create;
use function DI\autowire;
use App\Interfaces\DatabaseInterface;
use App\Repositories\Database;
use App\Repositories\DB;

return [
    //DatabaseInterface::class => autowire(Database::class),
    DatabaseInterface::class => autowire(DB::class),

    // Manually define how Database class should be constructed
    // App\Database::class => create()
    //     ->constructor(
    //         DI\get('db.host'),
    //         DI\get('db.user'),
    //         DI\get('db.pass')
    //     ),

    // // Let PHP-DI autowire UserService and inject the Database
    // App\UserService::class => autowire(),
];

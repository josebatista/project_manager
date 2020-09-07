<?php

use APP\Events\UsersCreated;

$container['events']->attach('created.users', new UsersCreated);

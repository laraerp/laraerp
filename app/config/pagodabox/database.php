<?php

return array(
    'default' => 'mysql',
    'connections' => array(
        'mysql' => array(
            'driver' => 'mysql',
            'host' => getenv("DB1_HOST"),
            'database' => getenv("DB1_NAME"),
            'username' => getenv("DB1_USER"),
            'password' => getenv("DB1_PASS"),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ),
    ),
);

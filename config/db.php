<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=kate',
    'username' => 'root',
    'password' => '0*M#cS)kX243E',
    'charset' => 'utf8',
    'enableSchemaCache' => true,

    // Продолжительность кеширования схемы.
    'schemaCacheDuration' => 3600,

    // Название компонента кеша, используемого для хранения информации о схеме
    'schemaCache' => 'cache',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

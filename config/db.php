<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:@app/db/cc_prod',
//    'dsn' => 'sqlite:@app/db/cc',
    'charset' => 'utf8',
    'on afterOpen' => function ($event) {
        /** @var \yii\db\Connection $dbConnection */
        $dbConnection = $event->sender;
        $dbConnection->createCommand()->checkIntegrity(true)->execute();
    },
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

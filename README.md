# yii2-thingsboard-php-sdk

PHP SDK for communicating with the ThingsBoard REST API


## configure in yii2

```php
// Configurazione di Yii2
return [
    // Altre configurazioni
    'components' => [
        'thingsBoardAuthService' => [
            'class' => 'ThingsBoard\Auth\AuthService',
            'baseUrl' => 'https://thingsboard.example.com'
        ],
        'thingsBoardClient' => [
            'class' => 'ThingsBoard\Http\Client',
            'authService' => 'thingsBoardAuthService'
        ],
        'deviceController' => [
            'class' => 'ThingsBoard\Controllers\DeviceController',
            'client' => 'thingsBoardClient'
        ],
        // Altri controller
    ],
];
```

## How to use

```php
// Autenticazione
Yii::$app->thingsBoardAuthService->authenticate('username', 'password');

// Utilizzo del DeviceController
$deviceController = Yii::$app->deviceController;
$device = $deviceController->getDevice('deviceId');
```

# thingsboard-php-sdk

PHP SDK for communicating with the ThingsBoard REST API

## How to use

```php
/// Inizializza AuthService con il base URL
$authService = new AuthService('https://thingsboard.example.com');

// Autenticazione
$authService->authenticate('username', 'password');

// Inizializza il controller dei dispositivi
$deviceController = new DeviceController($authService);

// Ottieni un dispositivo
$device = $deviceController->getDevice('deviceId');

// Ottieni la Lista dei Dispositivi;
$devices = $deviceController->getAllDevices();

```

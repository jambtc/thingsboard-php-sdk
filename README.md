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


// crea un tenant
$tenantController = new TenantController($authService);

$tenantData = [
    "title" => "title",
    "name" => "description",
    "region" => "default",
    "tenantProfileId" => [
        "id" => "tenant_profile_uuid",
        "entityType" => "TENANT_PROFILE"
    ],
];

$tenant = $tenantController->createTenant($tenantData);

// crea un utente 
$userController = new UserController($authService);

$userData = [
    "tenantId" => [
        "id" => "tenant_uuid",
        "entityType" => "TENANT"
    ],
    "email" => "example@mail.com",
    "name" => "example@mail.com",
    "authority" => "TENANT_ADMIN",
    "firstName" => "first Name",
    "lastName" => "last Name",
];

$user = $userController->createTenant($userData);
```

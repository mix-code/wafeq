# Daftra Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mix-code/daftra-client.svg?style=flat-square)](https://packagist.org/packages/mix-code/daftra-client)
[![Total Downloads](https://img.shields.io/packagist/dt/mix-code/daftra-client.svg?style=flat-square)](https://packagist.org/packages/mix-code/daftra-client)
![GitHub Actions](https://github.com/mix-code/daftra-client/actions/workflows/main.yml/badge.svg)

A Laravel package for interacting with the Daftra API, supporting **clients, products, invoice creation, and invoice payments**.

## 🚀 Features

-   Manage **clients** (list, show, create, update, delete)
-   Manage **products** (list, show, create, update, delete)
-   **Create invoices** and **make invoice payments**
-   **Simple API wrapper** with Laravel's HTTP Client
-   Supports **facade usage** for convenience

## ‼️ Requirments

-   PHP 8.2
-   Laravel 10 or Above

## 📦 Installation

```bash
composer require mix-code/daftra-client
```

## ⚙️ Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=daftra-client
```

Then update your `.env` file:

```env
DAFTRA_API_KEY=your_api_key_here
DAFTRA_ENDPOINT=https://api.daftra.com/v2
```

## 🛠️ Usage

### 1️⃣ Daftra Client Directly

You can inject `DaftraClient` directly anywhere:

```php
use MixCode\DaftraClient\DaftraClient;

class ClientController
{

    public function listClients()
    {
        $daftraClient = new DaftraClient();

        return $daftraClient->listClients();
    }
}
```

### 2️⃣ Using the Facade

You can also use the `DaftraClient` facade:

```php
use MixCode\DaftraClient\DaftraClientFacade as Daftra;

$clients = Daftra::listClients();
```

### 3️⃣ Using Dependency Injection

You can inject `DaftraClient` directly into your controllers or services:

```php
use MixCode\DaftraClient\DaftraClient;

class ClientController
{
    public function __construct(private DaftraClient $daftraClient) {}

    public function listClients()
    {
        return $this->daftraClient->listClients();
    }
}
```

## 📚 API Methods

### 🔹 Clients

#### List Clients

```php
$clients = $daftraClient->listClients();
```

#### Show Client

```php
$client = $daftraClient->showClient($clientId);
```

#### Create Client

```php
use MixCode\DaftraClient\Payloads\ClientPayload;

$payload = new ClientPayload(
    name: 'John Doe',
    email: 'john@example.com'
);

$response = $daftraClient->createClient($payload);
```

#### update Client

```php
use MixCode\DaftraClient\Payloads\ClientPayload;

$payload = new ClientPayload(
    name: 'John Doe',
    email: 'john@example.com'
);

$response = $daftraClient->updateClient($payload);
```

#### Delete Client

```php
$response = $daftraClient->deleteClient($clientId);
```

### 🔹 Products

#### List Products

```php
$products = $daftraClient->listProducts();
```

#### Show Product

```php
$product = $daftraClient->showProduct($productId);
```

#### Create Product

```php
use MixCode\DaftraClient\Payloads\ProductPayload;

$payload = new ProductPayload(
    name: 'Sample Product',
    price: 100.00
);

$response = $daftraClient->createProduct($payload);
```

#### Update Product

```php
use MixCode\DaftraClient\Payloads\ProductPayload;

$payload = new ProductPayload(
    name: 'Sample Product',
    price: 100.00
);

$response = $daftraClient->updateProduct($payload);
```

#### Delete Product

```php
$product = $daftraClient->deleteProduct($productId);
```

### 🔹 Invoices

#### Create an Invoice

```php
use MixCode\DaftraClient\Payloads\InvoicePayload;
use MixCode\DaftraClient\Payloads\InvoiceItemPayload;

$items = [
    new InvoiceItemPayload(productId: 1, quantity: 2, price: 50.00)
];

$invoicePayload = new InvoicePayload(
    clientId: 123,
    date: now()->toDateString(),
    items: $items
);

$invoice = $daftraClient->createInvoice($invoicePayload);
```

#### Pay an Invoice

```php
use MixCode\DaftraClient\Payloads\InvoicePaymentPayload;

$paymentPayload = new InvoicePaymentPayload(
    invoiceId: $invoice->id,
    amount: 100.00,
    paymentMethod: 'credit_card'
);

$payment = $daftraClient->payInvoice($paymentPayload);
```

#### Create and Pay an Invoice

```php
use MixCode\DaftraClient\Payloads\InvoicePayload;
use MixCode\DaftraClient\Payloads\InvoiceItemPayload;

$items = [
    new InvoiceItemPayload(productId: 1, quantity: 2, price: 50.00)
];

$invoicePayload = new InvoicePayload(
    clientId: 123,
    date: now()->toDateString(),
    items: $items
);

$response = $daftraClient->createAndPayInvoice($invoicePayload, 100.00, 'credit_card');
```

## ✅ Testing

```bash
vendor/bin/pest
```

## 📜 License

This package is open-source and available under the [MIT License](LICENSE).

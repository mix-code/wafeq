# Wafeq Integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mix-code/wafeq.svg?style=flat-square)](https://packagist.org/packages/mix-code/wafeq)
[![Total Downloads](https://img.shields.io/packagist/dt/mix-code/wafeq.svg?style=flat-square)](https://packagist.org/packages/mix-code/wafeq)
![GitHub Actions](https://github.com/mix-code/wafeq/actions/workflows/main.yml/badge.svg)

A Laravel package for interacting with the Wafeq API, supporting **projects, contacts, accounts**.

## 🚀 Features

-   Manage **projects** (list, show, create, update, delete)
-   Manage **contacts** (list, show, create, update, delete)
-   Manage **accounts** (list)
-   **Simple API wrapper** with Laravel's HTTP Client
-   Supports **facade usage** for convenience

## ‼️ Requirments

-   PHP 8.2
-   Laravel 10 or Above

## 📦 Installation

```bash
composer require mix-code/wafeq
```

## ⚙️ Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=wafeq
```

Then update your `.env` file:

```env
WAFEQ_API_KEY=your_api_key_here
WAFEQ_ENDPOINT=https://api.wafeq.com/v1
```

## 🛠️ Usage

### 1️⃣ Project Directly

You can inject `Project` directly anywhere:

```php
use MixCode\Wafeq\Project;

class ProjectController
{

    public function listProjects()
    {
        $projectService = new Project();

        return $projectService->list();
    }
}
```

### 2️⃣ Using the Facade

You can also use the `Project` facade:

```php
use MixCode\Wafeq\ProjectFacade as Project;

$projects = Project::list();
```

### 3️⃣ Using Dependency Injection

You can inject `Project` directly into your controllers or services:

```php
use MixCode\Wafeq\Project;

class ProjectController
{
    public function __construct(private Project $project) {}

    public function listProjects()
    {
        return $this->project->list();
    }
}
```

## 📚 API Methods

### 🔹 Projects Use `Project.php` class, in namespace `MixCode\Wafeq\Project`

#### List Projects

```php
$project = new Project();
$projects = $project->list();
```

#### Show Project

```php
$project = new Project();
$project = $project->show($projectId);
```

#### Create Project

```php
use MixCode\Wafeq\Payloads\ProjectPayload;

$payload = new ProjectPayload(
    name: 'Project Name',
);

$project = new Project();

$response = $project->create($payload);
```

#### update Project

```php
use MixCode\Wafeq\Payloads\ProjectPayload;

$payload = new ProjectPayload(
    name: 'John Doe',
);

$project = new Project();

$response = $project->update($payload);
```

#### Delete Project

```php
$project = new Project();

$response = $project->delete($projectId);
```
### 🔹 Contacts Use `Contact.php` class, in namespace `MixCode\Wafeq\Contact`

#### List Contacts

```php
$contact = new Contact();
$contacts = $contact->list();
```

#### Show Contact

```php
$contact = new Contact();
$contact = $contact->show($contactId);
```

#### Create Contact

```php
use MixCode\Wafeq\Payloads\ContactPayload;

$payload = new ContactPayload(
    name: 'Contact Name',
    email: 'contact@example.com',
    phone: '+1234567890'
);

$contact = new Contact();
$response = $contact->create($payload);
```

#### Update Contact

```php
use MixCode\Wafeq\Payloads\ContactPayload;

$payload = new ContactPayload(
    name: 'Contact Name Updated',
    email: 'contact@example.com',
    phone: '+1234567890'
);

$contact = new Contact();
$response = $contact->update($payload);
```

#### Delete Contact

```php
$contact = new Contact();
$contact = $contact->delete($contactId);
```

### 🔹 Accounts Use `Account.php` class, in namespace `MixCode\Wafeq\Account`

#### List Accounts

```php
$account = new Account();
$accounts = $account->list();
```

## ✅ Testing

```bash
vendor/bin/pest
```

## 📜 License

This package is open-source and available under the [MIT License](LICENSE).

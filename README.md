# khalyomede/monad

Maybe, Option and Result monads for PHP.

## Summary

- [About](#about)
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Examples](#examples)
- [API](#api)

## About

I published on [reddit](https://www.reddit.com/r/PHP/comments/oxcmw9/rfc_proposal_enums_constructor/) an RFC proposal for what I called "enums constructor" (which happened to be an existing concept called "tagged unions"). Out of [one comment](https://www.reddit.com/r/PHP/comments/oxcmw9/rfc_proposal_enums_constructor/h7qgo1n?utm_source=share&utm_medium=web2x&context=3), I shown how to chain calls to various ADT outcomes, in order to reduces pyramidal matches.

This got me into wanting to use more monads right now on my next projects. After searching on packagist.org, I did not found something that fits what I expected, so I decided to make my own version of how I think monads should look like in PHP.

## Features

- Supports theses monads:
  - Option
  - Maybe
  - Result
- PHPStan and static analyzers friendly

## Prerequisites

- PHP 8+ installed

## Installation

```bash
composer require khalyomede/monad
```

## Examples

- [1. Getting a file content](#1-getting-a-file-content)
- [2. Get users from an SQL table](#2-get-users-from-an-sql-table)

### 1. Getting a file content

In this example, we will use the Maybe monad as result, and use it in our main code.

```php
use Khalyomede\Monad\Maybe;

function getFileContent(string $filePath): Maybe
{
  $content = file_get_contents($filePath);

  return $content === false ? Maybe::nothing() : Maybe::just($content);
}

// main
$content = getFileContent("data.txt")
  ->then(fn (string $data): string => $data)
  ->catch(fn (): string => "N/A");

echo $content;
```

### 2. Get users from an SQL table

In this example, we will use the Result monad to return the list of users or an error from PDO.

```php
use Khalyomede\Monad\Result;

function getUsers(): Result
{
  $pdo = new PDO("sqlite::memory:");

  $statement = $pdo->prepare("SELECT * FROM users");

  if ($statement === false) {
    $message = $pdo->errorInfo()[2];

    return Result::error($message);
  }

  $result = $statement->execute();

  if ($result === false) {
    $message = $statement->errorInfo()[2];

    return Result::error($message);
  }

  return Result::ok($statement->fetchAll());
}

// main
$users = getUsers()
  ->then(fn (array $records): array => $records)
  ->catch(function (string $error): array {
    error_log($error);

    return [];
  });
```

## API

For a list of all possible functions, see the _tests\unit_ folder.

## Tests

```bash
composer run test
composer run mutate
composer run analyse
composer run check
composer outdated --direct
```

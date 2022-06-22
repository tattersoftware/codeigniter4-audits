# Tatter\Audits
Lightweight object logging for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-audits/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-audits/actions/workflows/phpunit.yml)
[![](https://github.com/tattersoftware/codeigniter4-audits/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-audits/actions/workflows/phpstan.yml)
[![](https://github.com/tattersoftware/codeigniter4-audits/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-audits/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-audits/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-audits?branch=develop)

## Quick Start

1. Install with Composer: `> composer require tatter/audits`
2. Update the database: `> php spark migrate --all`
3. Set up your models:

```php
use Tatter\Audits\Traits\AuditsTrait;

class JobModel extends Model
{
	use AuditsTrait;
	protected $afterInsert = ['auditInsert'];
	protected $afterUpdate = ['auditUpdate'];
	protected $afterDelete = ['auditDelete'];
```

## Features

Provides ready-to-use object logging for CodeIgniter 4

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
```console
> composer require tatter/audits
```

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

Once the files are downloaded and included in the autoload, run any library migrations
to ensure the database is setup correctly:
```console
> php spark migrate --all
```

## Configuration (optional)

The library's default behavior can be altered by extending its config file. Copy
**examples/Audits.php** to **app/Config/Audits.php** and follow the instructions in the
comments. If no config file is found in **app/Config** the library will use its own.

## Usage

Once the library is included all the resources are ready to go and you just need to
specify which models and events to audit. Use AuditsTrait to add support to any models
you would like tracked:

```php
use Tatter\Audits\Traits\AuditsTrait;

class JobModel extends Model
{
	use AuditsTrait;
```

Then specify which events you want audited by assigning the corresponding audit methods
for those events:

```php
	protected $afterInsert = ['auditInsert'];
	protected $afterUpdate = ['auditUpdate'];
	protected $afterDelete = ['auditDelete'];
```

The Audits library will create basic logs of each event in the `audits` table, for example:

```
| id | source | source_id | user_id | event  | summary  |          created_at |
+----+--------+-----------+---------+--------+----------+---------------------+
| 10 | sites  |        27 |       9 | create | 2 rows   | 2019-04-05 15:58:40 |
| 11 | jobs   |        10 |       9 | update | 5 rows   | 2019-04-05 16:01:35 |
```

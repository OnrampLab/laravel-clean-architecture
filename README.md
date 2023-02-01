# laravel-clean-architecture

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![CircleCI](https://circleci.com/gh/OnrampLab/laravel-clean-architecture.svg?style=shield)](https://circleci.com/gh/OnrampLab/laravel-clean-architecture)
[![Total Downloads](https://img.shields.io/packagist/dt/onramplab/laravel-clean-architecture.svg?style=flat-square)](https://packagist.org/packages/onramplab/laravel-clean-architecture)

Package to simply setup a Clean Architecture Application in Laravel.

## Requirements

- PHP >= 7.4;
- composer.

## Installation

```bash
composer require onramplab/laravel-clean-architecture
```

## Features

### UseCase

The `UseCase` class combines both DTO and business logic into single class in order to reduce the number of files since the DTO usually is tight to a specific use case. Here are the features when creating your own `UseCase` classes:

- Define a DTO
  - Define fields with validation rules (You can create your own validation attributes).
- Define the business logic.

### Usefull logs

By using our exception handler, you will have better logging and API error response (We follows [JSON API Spec](https://jsonapi.org/format/)). It will include more contexts.

Here is the example of api error response:

```json
{
  "errors": [
    {
      "title": "Fake Domain Exception",
      "detail": "A fake message",
      "status": 400
    }
  ]
}
```

Here is the example of error log context:

```json
{
  "detail": "A fake message",
  "adapter": {
    "type": "API",
    "route": "test-route",
    "method": "GET",
    "url": "http://localhost/test-route",
    "input": []
  },
  "errors": [
    {
      "title": "Unable To Do Something",
      "detail": "A fake message",
      "exception_class": "OnrampLab\\CleanArchitecture\\Exceptions\\UseCaseException",
      "stacktrace": [
        "## /var/www/html/tests/Unit/Exceptions/HandlerTest.php(149)",
        "#0 /var/www/html/vendor/phpunit/phpunit/src/Framework/TestCase.php(1548): OnrampLab\\CleanArchitecture\\Tests\\Unit\\Exceptions\\HandlerTest->handleUseCaseException2()"
      ]
    },
    {
      "title": "Fake Domain Exception",
      "detail": "A fake message",
      "exception_class": "OnrampLab\\CleanArchitecture\\Tests\\Unit\\Exceptions\\FakeDomainException",
      "stacktrace": [
        "## /var/www/html/tests/Unit/Exceptions/HandlerTest.php(146)",
        "#0 /var/www/html/vendor/phpunit/phpunit/src/Framework/TestCase.php(1548): OnrampLab\\CleanArchitecture\\Tests\\Unit\\Exceptions\\HandlerTest->handleUseCaseException2()"
      ]
    }
  ]
}

```

### Exception Architecture for clean architecture

- `GeneralException`
  - Domain Layer
    - `DomainException`
    - `CustomDomainException`
  - Application Layer
    - `UseCaseException`
    - `InternalServerException`
  - Adapter Layer
    - Low level exception

## How To

### How to create an use case

```php
namespace App\UseCases;

use OnrampLab\CleanArchitecture\UseCase;
use Spatie\LaravelData\Attributes\Validation\Url;

class DoSomethingUseCase extends UseCase
{
    #[Url()]
    public string $url;

    public function handle(): string
    {
        return 'do something';
    }
}
```

And then in your controller:

```php
use App\Http\Controllers\Controller;
use App\UseCases\DoSomethingUseCase;
use Illuminate\Http\Request;

class DoSomethingController extends Controller
{
    public function doSomething(Request $request)
    {
        $result = DoSomethingUseCase::perform([
            'url' => $request->input('url'),
        ]);

        return response()->json([
            'result' => $result,
        ]);
    }
}

```

### How to replace exception handler

Make your Laravel default handler to extend our Handler. For example:

```php
namespace App\Exceptions;

use OnrampLab\LaravelExceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
   // ...
}
```

### How to add custom validation attributes

You can follow the document in [Creating your validation attribute](https://spatie.be/docs/laravel-data/v2/advanced-usage/validation-attributes#content-creating-your-validation-attribute).

## Useful Tools

## Running Tests:

    php vendor/bin/phpunit

 or

    composer test

## Code Sniffer Tool:

    php vendor/bin/phpcs --standard=PSR2 src/

 or

    composer psr2check

## Code Auto-fixer:

    composer psr2autofix
    composer insights:fix
    rector:fix

## Building Docs:

    php vendor/bin/phpdoc -d "src" -t "docs"

 or

    composer docs

## Changelog

To keep track, please refer to [CHANGELOG.md](https://github.com/Onramplab/laravel-clean-architecture/blob/master/CHANGELOG.md).

## Contributing

1. Fork it.
2. Create your feature branch (git checkout -b my-new-feature).
3. Make your changes.
4. Run the tests, adding new ones for your own code if necessary (phpunit).
5. Commit your changes (git commit -am 'Added some feature').
6. Push to the branch (git push origin my-new-feature).
7. Create new pull request.

Also please refer to [CONTRIBUTION.md](https://github.com/Onramplab/laravel-clean-architecture/blob/master/CONTRIBUTION.md).

## Folder Structure

This will create a basic project structure for you:

* **/build** is used to store code coverage output by default;
* **/src** is where your codes will live in, each class will need to reside in its own file inside this folder;
* **/tests** each class that you write in src folder needs to be tested before it was even "included" into somewhere else. So basically we have tests classes there to test other classes;
* **.gitignore** there are certain files that we don't want to publish in Git, so we just add them to this fle for them to "get ignored by git";
* **CHANGELOG.md** to keep track of package updates;
* **CONTRIBUTION.md** Contributor Covenant Code of Conduct;
* **LICENSE** terms of how much freedom other programmers is allowed to use this library;
* **README.md** it is a mini documentation of the library, this is usually the "home page" of your repo if you published it on GitHub and Packagist;
* **composer.json** is where the information about your library is stored, like package name, author and dependencies;
* **phpunit.xml** It is a configuration file of PHPUnit, so that tests classes will be able to test the classes you've written;
* **.travis.yml** basic configuration for Travis CI with configured test coverage reporting for code climate.

## Tech Features

- PSR-4 autoloading compliant structure;
- PSR-2 compliant code style;
- Unit-Testing with PHPUnit 6;
- Comprehensive guide and tutorial;
- Easy to use with any framework or even a plain php file;
- Useful tools for better code included.


## License

Please refer to [LICENSE](https://github.com/Onramplab/laravel-clean-architecture/blob/master/LICENSE).

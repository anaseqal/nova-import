# Nova Import

Import data to resources.

![Screenshot](https://i.imgur.com/szKmLGf.gif)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require anaseqal/nova-import
```

Register the tool in your `app/Providers/NovaServiceProvider.php`:

```php
use Anaseqal\NovaImport\NovaImport;

// ...

public function tools()
{
    return [
        new NovaImport,
        // ...
    ];
}

```

## Usage

To use this tool, you need to create two things:

1. Create an import class for your resource using [Laravel Excel](https://docs.laravel-excel.com/3.1/imports/).

2. Create a custom Nova Action file:

```php
<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Anaseqal\NovaImport\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\File;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportUsers extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnIndex = true;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name() {
        return __('Import Users');
    }

    /**
     * @return string
     */
    public function uriKey() :string
    {
        return 'import-users';
    }

    /**
     * Perform the action.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {
        Excel::import(new UsersImport, $fields->file);

        return Action::message('It worked!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('File')
                ->rules('required'),
        ];
    }
}
```

3. Register the action into your resource:

```php
/**
 * Get the actions available for the resource.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
public function actions(Request $request)
{
    return [new Actions\ImportUsers];
}

```

Action Name must use the Format of `Import{ResourceName}`, for example `ImportUsers` or `ImportCountries`.

Please note that it extends `Anaseqal\NovaImport\Actions\Action` not normal Nova Actions because it doesn't applies on models!


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

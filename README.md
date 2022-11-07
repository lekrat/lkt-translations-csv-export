# LKT Translations to CSV

## Installation

```shell
composer require lkt/translations-to-csv
```

## Usage

### All translations

```php
use Lkt\Translations\TranslationsToCSV;

$spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
$writer = TranslationsToCSV::getAllTranslationsCSV($spreadsheet);
TranslationsToCSV::writeToOutput($writer);
```

### Missed translations

```php
use Lkt\Translations\TranslationsToCSV;

$spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
$writer = TranslationsToCSV::getMissedTranslationsCSV($spreadsheet);
TranslationsToCSV::writeToOutput($writer);
```

### Translations not translated

```php
use Lkt\Translations\TranslationsToCSV;

$spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
$writer = TranslationsToCSV::getTranslationsNotTranslatedCSV($spreadsheet);
TranslationsToCSV::writeToOutput($writer);
```
# Numbers

PHP value-objects for various identification numbers used in Poland:

- PESEL (national identification number)
- REGON (taxpayer identification number)
- NIP (VAT identification number)

## Usage

```php
use Kminek\Numbers\PESEL;

$pesel = PESEL::create('00261503191'); // will throw exception for incorrect PESEL

$pesel->getGender(); // 'male'
$pesel->getSerialNumber(); // '0319'
$pesel->getDate(); // DateTime object
$pesel->getChecksum(); // 1
```

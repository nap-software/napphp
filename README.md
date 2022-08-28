# napphp

A collection of functions that always throw an error in case something went wrong.

## Usage

```php
<?php
$napphp = require "/path/to/src/__load.php";

# Create random identifier of length 10
echo $napphp::util_randomIdentifier(10)."\n";
```

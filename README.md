# napphp

A collection of functions that always throw an error in case something went wrong.

## Usage

```php
<?php
$napphp = require "/path/to/src/__load.php";

# Create random identifier of length 10
echo $napphp::util_randomIdentifier(10)."\n";
```

## Configuration

| Key | Default | Description |
| --- | --- | --- |
| `tmp_dir` | (not set) | Path to a directory where to place created temporary objects. |
| `terminate_on_warning` | false | Terminate application when a warning is emitted. |
| `warning_print_trace` |  false | Print debug stack trace when emitting a warning. |

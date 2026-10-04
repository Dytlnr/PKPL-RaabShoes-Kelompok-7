# PHPStan Results

This folder contains the PHPStan configuration and the before/after analysis reports for the Raab Shoes Laravel application.

## Run the analysis

From the repository root:

```bash
./vendor/bin/phpstan analyse -c testing/phpstan/phpstan.neon --memory-limit=1G --no-progress
```

If PHPStan cannot start its parallel worker in the local environment, add `--debug` to run without parallel workers.

## Results

| Stage | Report | Result |
|---|---|---|
| Baseline, before PHPStan fixes | `../baseline/hasil-phpstan-sebelum.txt` | 13 errors across the analyzed source |
| After PHPStan fixes | `hasil-phpstan-sesudah.txt` | No errors; 23 files analyzed |
| Regression tests | `composer test` | 37 tests passed, 249 assertions |

## Changes made

- Added generic relation return types for `Customer::orders()` and `Order::customer()` so Laravel model relationships are inferred correctly.
- Removed null-coalescing checks for array keys guaranteed by the order formatter.
- Made nullable user checks explicit before passing them to `abort_unless()`.
- Removed impossible null checks for `service_price`, which is an integer cast and a non-null database column.

Place terminal screenshots for the baseline and final scan in `testing/phpstan/screenshots/`. Do not commit `.env` files or SonarQube tokens.

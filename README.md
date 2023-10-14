Fee Calculator
==========

This repository contains execution of the test task.


Running the code from CLI console
---------

Do not forget to execute `composer install` command.

Use the following command from repository root:
`./bin/console app:calculate-fees transactions.jsonl`

**Please note that `https://api.exchangeratesapi.io/latest` requires API key. Do not forget to enter your
EXCHANGE_RATES_API_ACCESS_KEY in your env file.**

Also, check and change, if needed, TRANSACTIONS_FOLDER_PATH value in env file. 


Running tests
---------

To run the tests run the following command from repository root:
`./vendor/bin/codecept run`


Implementation notes:
----------

Task implemented using default base symfony skeleton https://symfony.com/doc/current/setup.html configuration.
The only library was added - `codeception` for testing.

Time spent on the task is around 8 hours at the first day and 2 hours more on the next day.

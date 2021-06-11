# Flow PHP SDK

> :warning: This is an alpha release; functionality may change.

This is a Laravel PHP package that allows you to interact with the Flow blockchain by using the [Flow CLI](https://github.com/onflow/flow-cli).

In the future we'll mnake a full integration with the GRPC interface, but for now it's just a wrapper around the [Flow CLI](https://github.com/onflow/flow-cli).

At the moment, the SDK includes the following features:
- [x] Wrapper around [Flow CLI](https://github.com/onflow/flow-cli) for basic scripts, transactions, events and block calls.
- [ ] _Communication with the [Flow Access API](https://docs.onflow.org/access-api) over gRPC (coming soon)_
- [ ] _Transaction preparation and signing (coming soon)_
- [ ] _Events parsing (coming soon)_

# Installation

## Composer
To add this SDK to your project using Composer, use the following:

```
composer require mayvenstudios/flow-php-sdk
```

## Environment variables

After this, you should add the following variables in your .env file.
This example shows the default Flow CLI path for macOS if you're using Homebrew, but on a Linux server it will likely be `~/.local/bin`

```
FLOW_PATH=/opt/homebrew/bin/
FLOW_NETWORK=testnet
```

## Cadence folder

It's very important that you put all your flow.json config file and the contracts, scripts and transactions in a folder called `cadence` in the root directory of your project.
This folder will be used as the base path to run the `flow` command, so that it will be able to read all the necessary Flow configurations.

## Config file (optional)
If you're using Laravel you can also run this command to publish the config files if you need.

```
php artisan vendor:publish
```

## Install the grpc extension (optional)
This is only needed if you want to help develop the full GRPC version.
```
$ [sudo] pecl install grpc
```

# Example Usage

Once you have added the package via Composer and setup the environment variables, you can use the Flow Facade in the following ways.

Please remember to import the class at the beginning of your PHP with `use Flow;`

All the output will be returned as PHP Object parsed from the JSON returned by the Flow CLI.

##Get the latest Block

```
Flow::getLatestBlock();
```

##Get the latest Block by ID

```
Flow::getBlock(123456);
```

##Get Events within a range of Blocks (250 max)

```
Flow::event('event_name_with_address_goes_here')->minBlock(1)->maxBlock(100)->run();
```

##Run a script

```
Flow::script('path_to_cadence_script_file')->run();
```

##Execute a transaction

```
Flow::transaction('path_to_cadence_transaction_file')->run();
```

# Arguments

You can easily pass arguments to the script and transactions by using the following methods

##Integer (UInt64)

```
Flow::transaction('path_to_cadence_transaction_file')->argInt(100)->run();
```

###Fix (UFix64)

```
Flow::transaction('path_to_cadence_transaction_file')->argFix(9.99)->run();
```

##String

```
Flow::transaction('path_to_cadence_transaction_file')->argString('something')->run();
```

##Address

```
Flow::transaction('path_to_cadence_transaction_file')->argAddress('0x711eba2a0d39d21a')->run();
```

##Bool

```
Flow::transaction('path_to_cadence_transaction_file')->argBool(true)->run();
```

##DictionaryString (Dictionary of {String:String})

```
Flow::transaction('path_to_cadence_transaction_file')->argDictionaryString(['key' => 'value'])->run();
```

# Contribution

Project is in the very early phase, all contributions are welcomed.

Read the [contributing guide](https://github.com/mayvenstudios/flow-php-sdk/blob/main/CONTRIBUTING.md) to get started.

# Dependencies

[Protobuf-PHP](https://github.com/drslump/Protobuf-PHP)
[Illuminate-Support](https://github.com/illuminate/support)

# License

[Apache License 2.0](http://www.apache.org/licenses/)
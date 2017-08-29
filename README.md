## Installation

Install globally:

```bash
composer global require teamleader/onesky-cli
```

Or install locally:

```bash
composer require teamleader/onesky-cli
```

## Configuration

Your project needs a `onesky.yml`, file which can be generate:

```bash
onesky init
```

Then edit this file and your api key, secret and project id.

## Usage

You can check all available commands using:

```bash
onesky list
```

#### Uploading translations

Arguments:
- source locale
- source file name

```bash
onesky upload nl-BE nl/app.json
```

#### Downloading translations

Arguments:
- target locale
- target file path
- source file name

```bash
onesky download fr-BE fr/app.json app.json
```

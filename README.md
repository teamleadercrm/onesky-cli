## Usage

This project builds a docker image called `teamleader/onesky`. To pull the image on your local machine:

```bash
docker pull teamleader/onesky
```

## Configuration

Your project needs a `onesky.yml`, file which can be generate:

```bash
docker run teamleader/onesky init
```

Then edit this file and your api key, secret and project id.

## Usage

You can check all available commands using:

```bash
docker run teamleader/onesky list
```

#### Uploading translations

Arguments:
- source locale
- source file name

```bash
docker run teamleader/onesky upload nl-BE nl/app.json
```

#### Downloading translations

Arguments:
- target locale
- target file path
- source file name

```bash
docker run teamleader/onesky download fr-BE fr/app.json app.json
```

## Usage

This project builds a docker image called `teamleader/onesky`. To pull the image on your local machine:

```bash
docker pull teamleader/onesky
```

To use it, run the docker container with your current working directory to the `/project` folder.

```bash
docker run -v $(pwd):/project teamleader/onesky
```

## Configuration

Your project needs a `onesky.yml`, file which can be generated using:

```bash
docker run -v $(pwd):/project teamleader/onesky init
```

Then edit this file and your api key, secret and project id.

## Usage

You can check all available commands using:

```bash
docker run -v $(pwd):/projectteamleader/onesky list
```

#### Uploading translations

Arguments:
- source locale
- source file name

```bash
docker run -v $(pwd):/projectteamleader/onesky upload nl-BE nl/app.json
```

#### Downloading translations

Arguments:
- target locale
- target file path
- source file name

```bash
docker run -v $(pwd):/projectteamleader/onesky download fr-BE fr/app.json app.json
```

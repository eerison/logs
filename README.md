# L1 Challenge Devbox

## Summary

- Dockerfile & Docker-compose setup with PHP8.1 and MySQL
- Symfony 5.4 installation with a /healthz endpoint and a test for it
- After the image is started the app will run on port 9002 on localhost. You can try the existing
  endpoint: http://localhost:9002/healthz
- The default database is called `database` and the username and password are `root` and `root`
  respectively
- Makefile with some basic commands

# Usage

### Access the container

```shell
make new-cointainer

#OR

make enter
```
### Run consumer

```shell
#Run this in a new container: "make new-cointainer"
composer queue:consume
```

I didn't configure the [supervisor](https://symfony.com/doc/current/messenger.html#supervisor-configuration), then it needs to run manually

### Import logs

```
bin/console app:import-logs tests/Resources/logs.txt
```

### Populate Elastic search

```
bin/console fos:elastica:populate
```

- it can be handled automatically By fos elastica, But I didn't invest time trying to configure it.

### Test on Browser

- url to test: `http://localhost:9002/log/count?serviceName=USER-SERVICE&startDate=2021-02-08&endDate=2021-08-18&httpStatusCode=400`

```shell
make consume
```

## Installation

```
  make run && make install
```

## Run commands inside the container

```
  make enter
```

## Run tests

```
  make test
```

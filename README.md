# Document validation rules

Simple symfony console application to Document validation rules

## Requirements
- Docker version 19.03.4, build 9013bf5
- docker-compose version 1.24.1, build 4667896b
- docker-machine version 0.16.2, build bd45ab13

# How to run #

Dependencies:

  * Docker engine v1.13 or higher. Your OS provided package might be a little old, if you encounter problems, do upgrade. See [https://docs.docker.com/engine/installation](https://docs.docker.com/engine/installation)
  * Docker compose v1.12 or higher. See [docs.docker.com/compose/install](https://docs.docker.com/compose/install/)

Once you're done, simply `cd` to your project and run docker-compose up -d. This will initialise and start all the containers, then leave them running in the background.
## Examples

### Enter command
```
$ for run code: 
docker-compose exec php-fpm bin/console identification-requests:process input.csv
 file on the root directory to run the application
- $ For Unit testing : docker-compose exec php-fpm ./vendor/bin/simple-phpunit
- $ exit 
to exit the bash shell
```

### List available commands
```
$ docker-compose exec php-fpm bin/console list
```

### Run command
```
$ docker-compose exec php-fpm bin/console identification-requests:process input.csv
   file on the root directory to run the application
```

### Run tests command
```
$ docker-compose exec php-fpm ./vendor/bin/simple-phpunit

```

### Delete container
```
$ docker-compose down
```

 
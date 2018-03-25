# Testing TheiaLive

Here are some instructions to get started testing the website [TheiaLive](https://www.theialive.com).

## Setting up Docker image

We're using [Docker](https://www.docker.com) to execute our testing tools. In order to get started, we need to build our own PHP image that we'll use to execute our testing tools.

```
docker build -t in2it/theialive_qa:5.6 .
```

## Execute Testing Tools

### Running PHPUnit

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/phpunit
```

### Running PHP Copy/Paste Detection

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/phpcpd application
```

### Running PHP_CodeSniffer

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/phpcs
```

### Running PHP Mess Detection

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/phpmd application text cleancode,codesize,controversial,design,naming,unusedcode
```

### Executing PHP Depend

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/pdepend --jdepend-chart=build/chart.svg --overview-pyramid=build/pyramid.svg application
```

### Running PHP Dead Code Detection

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/phpdcd -n application
```

### Executing SensioLabs PHP Security Checker

```
docker run --rm --name phpqa -v "$PWD":/home/phpunit -w /home/phpunit in2it/theialive_qa:5.6 ./vendor/bin/security-checker -n security:check
```

### Performing Performance Tests

You can use [Apache Bench](https://httpd.apache.org/docs/2.4/programs/ab.html) for testing the performance of the website, or [Joe Dog Siege](https://www.joedog.org/siege-home/), or [JMeter](https://jmeter.apache.org/) for more advanced performance testing.

Here's an example to test the website with 100 concurrent users for a 1000 requests:

```
ab -c 100 -n 1000 https://www.theialive.com/
```

You can also post content to a form that way

```
ab -c 10 -n 1000 -C "THEID=rm6r6l7jba69esqdc2teu1mc84" -e post.csv -g post.tsv -H "Accept-Encoding: gzip,deflate" -p post-comment.txt -T "application/x-www-form-urlencoded" https://www.theialive.com/index/contact
``` 

Where the contents of `post-comment.txt` is just the form values you want to post

```
name=Apache%20Benchmark&email=ab%40apache.org&token=e4eafe745833c1d40ce2103fe4b269e3&send=Send%20message&comment=This%20is%20an%20automated%20comment%20posted%20by%20Apache%20Bench
```

# Supermetrics Coding Challenge

## Installation

To start this application, you need to do following steps:

```
git clone git@github.com:cpkgroup/supermetrics.git
```

- Run from the project root:

```
docker-compose build
docker-compose run php composer install
```

- Run from the project root:

```
docker-compose up -d
```

## Tests

- Run from the project root:

```
docker-compose run php /www/vendor/bin/phpunit
```

- Run this to see the unit-test coverage:

```
docker-compose run php /www/vendor/bin/phpunit --coverage-html /www/var/coverage
```

See the results in var/coverage/index.html

## See Test Results:

- Average character length of posts per month
    - [http://localhost/?action=averageLengthOfPostsPerMonth](http://localhost/?action=averageLengthOfPostsPerMonth)

- Longest post by character length per month
    - [http://localhost/?action=longestPostLengthPerMonth](http://localhost/?action=longestPostLengthPerMonth)

- Total posts split by week number
    - [http://localhost/?action=totalPostsByWeekNumber](http://localhost/?action=totalPostsByWeekNumber)

- Average number of posts per user per month
    - [http://localhost/?action=averageNumberOfPostsPerUserPerMonth](http://localhost/?action=averageNumberOfPostsPerUserPerMonth)


## Coding Style
- This project follows [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

## Technologies
- Docker
- PHP 7.4
- Nginx

## External libraries
- Guzzle
- Phpunit

## Author
- [Mohamad Habibi](https://www.linkedin.com/in/habibimh) 

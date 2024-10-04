## The Water Jug Challenge

This project is based in the Water Pouring Puzzle (https://en.wikipedia.org/wiki/Water_pouring_puzzle).
I will design a solution and create an API that can compute the steps required to measure exactly Z gallons using two jugs of capacities X and Y gallons. The backend should process this problem efficiently and return the solution steps in JSON format through a RESTful API.

## Installation

You need to have a functional Docker installation in your local environment.
To install, clone the project, set the environment (create .env, install composer dependencies, and generate app key), and start the sail:

```
git clone git@github.com:socratesldduarte/wjc.git
cd wjc

cp ./.env.example ./.env
composer install
php artisan key:generate

./vendor/bin/sail up 
```
Be sure to have the "wjc.test" entry in your etc/hosts file, to access the endpoints from the Postman collection.

## Testing

You can run the test suite from the terminal, running:

```
./vendor/bin/phpunit 
```

## Usage

A postman collection (WJC.postman_collection.json) was added in the root folder.
You can  import this collection to your postman client and do requests to the evaluate endpoint, with a json pauload like:

```
{
    "x_capacity":  2,
    "y_capacity": 10,
    "z_amount_wanted": 4
}
```
The above request will generate the response:
```
{
    "solution": [
        {
            "step": 1,
            "bucketX": 2,
            "bucketY": 0,
            "action": "Fill bucket X"
        },
        {
            "step": 2,
            "bucketX": 0,
            "bucketY": 2,
            "action": "Transfer from bucket X to bucket Y"
        },
        {
            "step": 3,
            "bucketX": 2,
            "bucketY": 2,
            "action": "Fill bucket X"
        },
        {
            "step": 4,
            "bucketX": 0,
            "bucketY": 4,
            "action": "Transfer from bucket X to bucket Y",
            "status": "solved"
        }
    ]
}
```

The response will be stored in the Redis server - and a new request with the same payload will be returned faster than the first one.
For example, a request:
```
{
    "x_capacity":  1,
    "y_capacity": 10000,
    "z_amount_wanted": 5005
}
```
was processed (first time) in 13.47s (9,990 steps). After caching it, a new request was returned in 55 ms.

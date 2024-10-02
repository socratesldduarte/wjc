## The Water Jug Challenge

This project is based in the Water Pouring Puzzle (https://en.wikipedia.org/wiki/Water_pouring_puzzle).
I will design a solution and create an API that can compute the steps required to measure exactly Z gallons using two jugs of capacities X and Y gallons. The backend should process this problem efficiently and return the solution steps in JSON format through a RESTful API.

## Installation

You need to have a functional Docker installation in your local environment.
To install, clone the project and start the sail:

```
git clone git@github.com:socratesldduarte/wjc.git
cd wjc
./vendor/bin/sail up 
```
Be sure to have the "wjc.test" entry in your etc/hosts file, to access the endpoints from the Postman collection.

## Description

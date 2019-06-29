# Welcome to my API WEB SERVICE using Symfony 4.3

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d5c900a0b0ba435094f42fc9acc9bd40)](https://app.codacy.com/app/jlbokass/P7-BileMo?utm_source=github.com&utm_medium=referral&utm_content=jlbokass/P7-BileMo&utm_campaign=Badge_Grade_Dashboard)

This API WEB SERVICE .

This work is done as part of my PHP web developer training with Openclassroom - project 7.

## Installation

1. First, download the framework, either directly or by cloning the repo.
1. Run **composer update** to install the project dependencies.
1. Configure your web server to have the **public** folder as the web root.
1. Open [.env.dist](.env.dist) and enter your database configuration data.
1. Run the web server:
> $ php bin/console server:run
1. Register a new user (you can use postman of corse) :
> $ curl -X POST http://localhost:8000/register -d _username=johndoe -d _password=test
  -> User johndoe successfully created 
1. Get a JWT token:
> $ curl -X POST -H "Content-Type: application/json" http://localhost:8000/login_check -d '{"username":"johndoe","password":"test"}'
  -> { "token": "[TOKEN]" }  
1. Access a secured route:
> $ curl -H "Authorization: Bearer [TOKEN]" http://localhost:8000/api
  -> Logged in as johndoe      

See below for more details.

## Bundles

build with :
* symfony 4.3       
* friendsofsymfony/rest-bundle: 2.5
* gesdinet/jwt-refresh-token-bundle": 0.6.2
* jms/serializer-bundle: 2.4,
* lexik/jwt-authentication-bundle: 2.6
* nelmio/api-doc-bundle: 3.4
* php-http/guzzle6-adapter: 2.0
* sensio/framework-extra-bundle: 5.3
* white-october/pagerfanta-bundle: 1.2
* willdurand/hateoas-bundle: 1.4
---
Thank you :)
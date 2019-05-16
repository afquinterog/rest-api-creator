# Project Title

Simple resource manager

## Getting Started

This project allows to add simple CRUD operations to mysql tables following the RESTful APIs guidelines.

### Prerequisites

The only requeriment to run the project is PHP.

## Database configuration

Database connection can be configured editing the config.php.sample and renaming as config.php

## Adding resources

Resources can be added to the system using the resources.php file

## Running the tests

If your application contains a contacts table then after adding to the resources.php file you can execute common CRUD operations

For example to get all the results on the table execute:

GET -> /contacts

To get a specific resource
GET -> /contacts/1

If the contacts table has a emails related table then you can get the contact emails for the contact with id 1 using:

GET -> /contacts/1/emails


## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Andres Quintero** - *Initial work* 


## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

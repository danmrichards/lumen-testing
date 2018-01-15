# Lumen Testing
An example of unit testing with Lumen with an in-memory sqlite database.

## Usage
The repository provides a containerised PHP + MySQL stack running a Lumen microservice. The
microservice itself uses the MySQL instance as it's storage backend. Spin up the app like so:

```bash
$ docker-compose up -d
```

The service can then be accessed at http://localhost. The endpoints for the service are:

* POST /users - Creates a new random user
* GET /users - Lists all users 

## Testing
The tests for the service are powered by PHP Unit; which in this case has been configured to
use an [in memory sqlite](https://www.sqlite.org/inmemorydb.html) database. This means that unit
and integration tests can be run without the need for additional containers and for example within
a CI/CD pipeline.

To run the tests execute the following command:

```bash
$ make test
```

This is made possible by the `testing` database connection that Lumen provides. Note that the 
`DB_CONNECTION` variable is set to `testing` in the `phpunit.xml` file
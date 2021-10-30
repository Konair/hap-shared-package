# Hexagonal Architecture Playground: Shared package

## What is it?
This is a package that contains all the common data that the other packages use in this project.

## Documentation

### Requirements
- docker

### Install
`composer require konair/hap-shared-package`

### Test with docker
1. `composer docker-build`
2. `composer docker`
3. `composer test`

### More information
- see in the [composer.json](composer.json) file
- see in the [Dockerfile](Dockerfile) file

## License
[GPLv3](LICENSE)
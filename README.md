S3 Extension
============

Uploads generated content by carew to amazon S3.

Installation
------------

    composer require carew/plugin-s3

Configuration
-------------

Add the following configuration to your `config.yml` file:

    engine:
        extensions:
            - S3Extension

    aws:
        bucket: bucket name
        key: key
        secret: secret

It's recommended to use an IAM with the following configuration:

Usage
-----

    bin/carew deploy

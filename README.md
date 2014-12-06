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
        bucket: <BUCKET_NAME>
        key: <KEY>
        secret: <SECRET>

It's recommended to use an IAM with the following configuration:


    {
      "Version": "2012-10-17",
      "Statement": [
        {
          "Sid": "Stmt1407400884000",
          "Effect": "Allow",
          "Action": [
            "s3:*"
          ],
          "Resource": [
            "arn:aws:s3:::<BUCKET_NAME>",
            "arn:aws:s3:::<BUCKET_NAME>/*"
          ]
        }
      ]
    }

Usage
-----

    bin/carew deploy

<?php

use Aws\S3\S3Client;
use Aws\S3\Sync\UploadSyncBuilder;
use Carew\Carew;
use Carew\ExtensionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class S3Extension implements ExtensionInterface
{
    public function register(Carew $carew)
    {
        $container = $carew->getContainer();
        if (!array_key_exists('aws', $container['config'])) {
            throw new \LogicException('The key "aws" does not exist in the config.yml file');
        }
        $awsConf = $container['config']['aws'];
        foreach (array('bucket', 'key', 'secret') as $key) {
            if (!array_key_exists($key, $awsConf)) {
                throw new \LogicException(sprintf('The key "%s" does not exist in the config.yml file', $key));

            }
        }
        $carew->register('deploy')
            ->setDescription('Deploy the website')
            ->setCode(function (InputInterface $input, OutputInterface $output) use ($awsConf) {
                $client = S3Client::factory(array(
                    'key' => $awsConf['key'],
                    'secret' => $awsConf['secret'],
                ));

                $webDir = sprintf('%s/web', $input->getOption('base-dir'));
                if (!is_dir($webDir)) {
                    throw new \InvalidArgumentException(sprintf('The web directory "%s" does not exist.', $webDir));
                }

                UploadSyncBuilder::getInstance()
                    ->setClient($client)
                    ->setBucket($awsConf['bucket'])
                    ->enableDebugOutput()
                    ->setAcl('public-read')
                    ->uploadFromDirectory($webDir)
                    ->build()
                    ->transfer()
                ;
            })
        ;
    }
}

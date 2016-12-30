<?php

namespace Wame\Core\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wame\Utils\File\FileHelper;

class ClearCacheCommand extends Command
{
    /** {@inheritDoc} */
    protected function configure()
    {
        $this
            ->setName('nette:clear-cache:all')
            ->setDescription('Clear Nette cache.')
            ->addOption('cache', null, InputOption::VALUE_OPTIONAL, 'Clear cache folder');
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            FileHelper::emptyDir(TEMP_PATH . '/cache');
            FileHelper::emptyDir(TEMP_PATH . '/entities');
            FileHelper::emptyDir(TEMP_PATH . '/proxies');

            $output->writeln('Cache successfully cleared');

            return 0; // zero return code means everything is ok
        } catch (\Exception $exc) {
            $output->writeln("<error>{$exc->getMessage()}</error>");

            return 1; // non-zero return code means error
        }
    }

}
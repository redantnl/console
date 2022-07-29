<?php
namespace Console\App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RedAnt\Console\Helper\SelectHelper;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class MenuCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('menu')
            ->setDescription('Select favorite food');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getHelperSet()->set(new SelectHelper(), 'select');

        $helper = $this->getHelper('select');
        $value = $helper->select(
            $input,
            'What is your favorite food?',
            [
                'hamburger' => 'Hamburger',
                'pizza'     => 'Pizza',
                'sushi'     => 'Sushi',
                'poke'      => 'Poké bowl'
            ]
        );

        var_dump($value);

        return Command::SUCCESS;
    }

}

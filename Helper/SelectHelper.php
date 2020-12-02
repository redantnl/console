<?php

namespace RedAnt\Console\Helper;

use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use RedAnt\Console\MenuItem\ValueItem;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;

/**
 * The SelectHelper class provides a menu to interact with the user.
 *
 * @author Gert Wijnalda <gert@redant.nl>
 */
class SelectHelper extends Helper
{
    /**
     * @var ValueItem
     */
    private $selectedItem;

    /**
     * Asks the user to select an option from an interactive menu.
     *
     * @param InputInterface $input   An InputInterface instance
     * @param string         $title   The menu title
     * @param array          $options The array of options
     *
     * @return string|null The user answer (one of the keys of options, or null if canceled)
     *
     */
    public function select(InputInterface $input, $title, array $options)
    {
        if (!$input->isInteractive()) {
            return current($options);
        }

        if (!$this->isValidTty()) {
            throw new RuntimeException("No valid tty terminal available to create interactive menu.");
        }

        return $this->doSelect($title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'select';
    }

    /**
     * Asks the user to select one of the options.
     *
     * @param string $title
     * @param array  $options
     *
     * @return string
     */
    private function doSelect($title, array $options)
    {
        $builder = new CliMenuBuilder();

        foreach ($options as $value => $text) {
            $builder->addMenuItem(new ValueItem($value, strval($text), function (CliMenu $menu) {
                $this->selectedItem = $menu->getSelectedItem();
                $menu->close();
            }));
        }

        $menu = $builder
            ->setTitle(strval($title))
            ->addLineBreak(' ')
            ->setTitleSeparator('-')
            ->setWidth(80)
            ->setExitButtonText('Cancel')
            ->build();

        $this->selectedItem = null;
        $menu->open();

        return ($this->selectedItem === null) ? null : $this->selectedItem->getValue();
    }

    /**
     * Returns whether terminal is a valid tty.
     *
     * @return bool
     */
    private function isValidTty()
    {
        return function_exists('posix_isatty') && @posix_isatty(STDOUT);
    }
}

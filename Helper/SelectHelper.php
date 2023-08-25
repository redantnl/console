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
     * @param array          $choices The array of options
     * @param null|callable  $builder callable to add extra functionality to the builder
     *
     * @return string|null The user answer (one of the keys of options, or null if canceled)
     *
     */
    public function select(InputInterface $input, string $title, array $choices, ?callable $builder = null)
    {
        if (!$input->isInteractive()) {
            return current($choices);
        }

        if (!$this->isValidTty()) {
            throw new RuntimeException("No valid tty terminal available to create interactive menu.");
        }

        return $this->doSelect($title, $choices, $builder);
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
     * @param string        $title
     * @param array         $choices
     * @param null|callable $builderCallable
     *
     * @return string
     */
    private function doSelect($title, array $choices, ?callable $builderCallable)
    {
        $builder = new CliMenuBuilder();

        foreach ($choices as $value => $text) {
            $builder->addMenuItem(new ValueItem($value, strval($text), function (CliMenu $menu) {
                $this->selectedItem = $menu->getSelectedItem();
                $menu->close();
            }));
        }

        $builder
            ->setTitle(strval($title))
            ->addLineBreak(' ')
            ->setTitleSeparator('-')
            ->setWidth(80)
            ->setExitButtonText('Cancel')
        ;

        if ($builderCallable) {
            $builderCallable($builder);
        }

        $menu = $builder->build();

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

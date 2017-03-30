<?php

namespace RedAnt\Console\MenuItem;

use PhpSchool\CliMenu\MenuItem\SelectableItem;

/**
 * Class ValueItem
 *
 * @package RedAnt\Console\MenuItem
 * @author  Gert Wijnalda <gert@redant.nl>
 */
class ValueItem extends SelectableItem
{
    private $value;

    /**
     * @param string   $value
     * @param string   $text
     * @param callable $selectAction
     * @param bool     $showItemExtra
     * @param bool     $disabled
     */
    public function __construct($value, $text, callable $selectAction, $showItemExtra = false, $disabled = false)
    {
        parent::__construct($text, $selectAction, false, false);
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

}
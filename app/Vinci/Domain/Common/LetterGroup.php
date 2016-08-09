<?php
namespace Vinci\Domain\Common;

class LetterGroup
{

    public $letter;

    public $items;

    public function __construct($letter, $items)
    {

        $this->letter = $letter;
        $this->items = $items;

    }
}
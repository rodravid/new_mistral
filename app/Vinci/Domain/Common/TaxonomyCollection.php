<?php

namespace Vinci\Domain\Common;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TaxonomyCollection extends Collection
{
    public function getAvailableLetters()
    {
        $availableLetters = [];

        foreach ($this->items as $item) {

            $firstLetter = $this->getFirstLetter($item);

            if (!isset($availableLetters[$firstLetter])) {
                $availableLetters[$firstLetter] = $firstLetter;
            }

        }

        asort($availableLetters);

        return $availableLetters;
    }

    public function groupByLetter($letter)
    {
        $items = [];

        foreach ($this->items as &$item) {

            $firstLetter = $this->getFirstLetter($item);

            if ($firstLetter == $this->sanitizeLetter($letter)) {
                $items[] = $item;
            }

        }

        usort($items, function($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return new LetterGroup($letter, new static($items));
    }

    public function groupByLetters()
    {
        $letters = $this->getAvailableLetters();

        $data = [];

        foreach ($letters as $letter) {

            $data[] = $this->groupByLetter($letter);

        }

        return new static($data);
    }

    protected function getFirstLetter(&$item)
    {
        return $this->sanitizeLetter($item->getName())[0];
    }

    protected function sanitizeLetter($letter)
    {
        return strtolower(Str::ascii($letter));
    }
}
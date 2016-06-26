<?php

namespace Vinci\Domain\Search\Suggester;

class SuggesterOption
{

    protected $text;

    protected $score;

    protected $payload;

    public function __construct()
    {
        $this->payload = [];
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    public function getPayload($key = null)
    {
        if (! empty($key)) {
            return array_get($this->payload, $key);
        }

        return $this->payload;
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
        return $this;
    }

}
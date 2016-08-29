<?php

namespace Vinci\Domain\Order\Strategy;

use Closure;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Pipeline\Pipeline;
use Vinci\Domain\Order\OrderCreationStrategy;

abstract class PipelineBasedOrderCreationStrategy implements OrderCreationStrategy
{

    protected $container;

    protected $finisherHandler;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute(array $data)
    {
        try {

            $pipeline = $this->makeNewPipeline();

            $pipeline
                ->send($data)
                ->through($this->getSteps())
                ->then($this->getFinisherHandler());

        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getSteps()
    {
        if (property_exists($this, 'steps') && is_array($this->steps)) {
            return $this->steps;
        }

        throw new Exception('You must define the steps of order creation strategy.');
    }

    public function getFinisherHandler()
    {
        return $this->finisherHandler;
    }

    public function setFinisherHandler(Closure $handler)
    {
        $this->finisherHandler = $handler;
        return $this;
    }

    protected function makeNewPipeline()
    {
        return new Pipeline($this->container);
    }

}
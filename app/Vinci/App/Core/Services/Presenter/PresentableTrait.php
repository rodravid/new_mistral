<?php

namespace Vinci\App\Core\Services\Presenter;

use Vinci\App\Core\Services\Presenter\Exceptions\PresenterException;

trait PresentableTrait
{

    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (! property_exists($this, 'presenter') || ! $this->presenter or ! class_exists($this->presenter))
        {
            throw new PresenterException('Please set the $presenter property to your presenter path.');
        }

        if ( ! $this->presenterInstance)
        {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }

    public function getPresenter()
    {
        return $this->present();
    }

}
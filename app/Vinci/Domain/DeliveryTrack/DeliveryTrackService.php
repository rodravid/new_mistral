<?php

namespace Vinci\Domain\DeliveryTrack;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Vinci\App\Core\Services\Sanitizer\Contracts\Sanitizer;

class DeliveryTrackService
{
    private $repository;

    private $entityManager;

    private $validator;

    private $lineValidator;
    /**
     * @var Sanitizer
     */
    private $sanitizer;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeliveryTrackRepository $repository,
        DeliveryTrackValidator $validator,
        LineValidator $lineValidator,
        Sanitizer $sanitizer
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->lineValidator = $lineValidator;
        $this->sanitizer = $sanitizer;
    }

    public function create(array $data)
    {
        $this->sanitize($data);
        $this->validate($data);

        return $this->saveDeliveryTrack($data, function($data) {
            $deliveryTrack = new DeliveryTrack;
            $deliveryTrack->fill($data);
            return $deliveryTrack;
        });
    }

    public function update(array $data, $id)
    {
        $this->sanitize($data);
        $this->validate($data, $id);

        return $this->saveDeliveryTrack($data, function($data) use ($id) {

            $deliveryTrack = $this->repository->find($id);
            $deliveryTrack->fill($data);

            return $deliveryTrack;
        });
    }

    protected function saveDeliveryTrack($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $deliveryTrack = $method($data);

            $this->syncLines($deliveryTrack, $data['line']);

            $this->repository->save($deliveryTrack);

            $this->entityManager->commit();

            return $deliveryTrack;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    protected function syncLines(DeliveryTrack $deliveryTrack, array $lines)
    {
        $deliveryTrack->getLines()->clear();

        foreach ($lines as $line) {
            $deliveryTrack->addLine(Line::make($line));
        }

    }

    protected function validate(array $data, $id = null)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();
        $this->lineValidator->with($data)->passesOrFail();
    }

    protected function sanitize(&$data)
    {
        $this->sanitizer->sanitize([
            'title' => 'trim'
        ], $data);

        foreach ($data['line'] as &$line) {
            $this->sanitizer->sanitize([
                'initial_track' => 'trim|only_numbers',
                'final_track' => 'trim|only_numbers'
            ], $line);
        }

    }

}
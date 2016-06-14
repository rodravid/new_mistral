<?php

namespace Vinci\Domain\Newsletter;

use Doctrine\ORM\EntityManagerInterface;

class NewsletterService
{

    protected $repository;

    protected $validator;

    protected $entityManager;

    public function __construct(NewsletterRepository $repository, NewsletterValidator $validator, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->entityManager = $em;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        $newsletter = $this->getNewsletterInstanceWithData($data);

        $this->repository->save($newsletter);
    }

    public function getNewsletterInstanceWithData(array $data)
    {
        $newsletter = new Newsletter();

        $newsletter->setName(ucwords($data['name']));
        $newsletter->setEmail($data['email']);

        return $newsletter;
    }
}
<?php

namespace Vinci\Infrastructure\Newsletter;

use Vinci\Domain\Newsletter\Newsletter;
use Vinci\Domain\Newsletter\NewsletterRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineNewsletterRepository extends DoctrineBaseRepository implements NewsletterRepository
{

    public function create(array $data)
    {
        $news = Newsletter::make($data);
        $this->_em->persist($news);
        $this->_em->flush();
        return $news;
    }

    public function getAll()
    {
        return $this->createQueryBuilder('o')->getQuery()->getResult();
    }

    public function countNewsletters()
    {
        return (int) $this->createQueryBuilder('n')->select('count(n.id)')->getQuery()->getSingleScalarResult();
    }
}
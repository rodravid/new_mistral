<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Vinci\Domain\Payment\CreditCard;

class ClearCreditCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'creditcards:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear credit cards';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Clearing creditcards...');

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('c')
            ->from(CreditCard::class, 'c')
            ->where($qb->expr()->lte('c.createdAt', $qb->expr()->literal(Carbon::now()->subMonths(3)->format('Y-m-d H:i:s'))))
            ->andWhere($qb->expr()->eq('c.clean', 0));

        $iterableResult = $qb->getQuery()->iterate();

        $batchSize = 20;
        $i = 0;

        while (($row = $iterableResult->next()) !== false) {

            $card = $row[0];

            $number = $card->getNumber();

            $end = substr($number, -4);

            $card->setNumber(sprintf('XXXX-XXXX-XXXX-%s', $end));
            $card->setSecurityCode('XXX');
            $card->setClean(true);

            $this->em->persist($card);

            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();
            }

            ++$i;
        }

        $this->em->flush();

        $this->info('Done!');

    }

}
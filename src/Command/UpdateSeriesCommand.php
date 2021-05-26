<?php

namespace App\Command;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateSeriesCommand extends Command
{
    protected static $defaultName = 'app:update-series';
    protected static $defaultDescription = 'Add a short description for your command';

    private $entityManager;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /*$arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }*/

        $io->success('Bravo!');
        $io->error("Oops cest loupé!");
        $io->writeln("je vais procéder à la suppression des series de plus de deux ans :");

        $serieRepository = $this->entityManager->getRepository(Serie::class);
        $series = $serieRepository->findAll();

        $date = new \DateTime();
        $date->modify('-2 years');

        $deletedSeries = 0;

        /** @var Serie $serie */
        foreach ($series as $serie) {
            if ($serie->getLastAirDate() < $date) {
                $this->entityManager->remove($serie);
                $deletedSeries++;
            }
        }
        $this->entityManager->flush();


            $io->success($deletedSeries.' were deleted');

        return Command::SUCCESS;
    }
}

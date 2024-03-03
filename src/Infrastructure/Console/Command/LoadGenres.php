<?php

declare(strict_types=1);

namespace App\Infrastructure\Console\Command;

use App\Domain\ValueObject\GenreEnum;
use App\Infrastructure\Database\Entity\Genre;
use Cycle\ORM\EntityManager;
use Cycle\ORM\ORM;
use DI\Attribute\Inject;
use DI\Container;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-genres',
    description: 'Load genres from enum \App\Domain\ValueObject\GenreEnum',
)]
class LoadGenres extends Command
{
    #[Inject]
    protected Container $container;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $orm = $this->container->make(ORM::class);
        $em = new EntityManager($orm);

        $genres = [];

        /** @var Genre $genreEntity */
        foreach ($orm->getRepository(Genre::class)->findAll() as $genreEntity) {
            $genres[$genreEntity->getAbbreviation()] = $genreEntity;
        }

        foreach (GenreEnum::cases() as $genre) {
            $abbreviation = $genre->value;
            $description = $genre->description();

            if (array_key_exists($abbreviation, $genres)) {
                $genreEntity = $genres[$abbreviation];

                if ($description !== $genreEntity->getDescription()) {
                    $genreEntity->setDescription($description);
                    $em->persist($genreEntity)->run();

                    $output->writeln("<comment>Updated</comment> description for the <info>$abbreviation</info> genre.");
                } else {
                    $output->writeln("The <info>$abbreviation</info> genre already exists, no changes are needed.");
                }
            } else {
                $genreEntity = new Genre($abbreviation, $description);
                $em->persist($genreEntity)->run();

                $output->writeln("The <info>$abbreviation</info> genre has been <comment>added</comment>.");
            }
        }

        return Command::SUCCESS;
    }
}

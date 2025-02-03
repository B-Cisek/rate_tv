<?php

declare(strict_types=1);

namespace App\RateTv\Shared\Infrastructure\Symfony\Cli;

use App\RateTv\Shared\Application\Event\EventBus;
use App\RateTv\Shared\Domain\DomainEvent;
use App\RateTv\Shared\Infrastructure\Doctrine\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

#[AsCommand(
    name: 'rate-tv:shared:process-events',
    description: 'Fetch events from database and send them to event bus.'
)]
final class ProcessEvents extends Command
{
    use LockableTrait;

    private const int DEFAULT_LIMIT = 50;

    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventBus $eventBus,
        private readonly SerializerInterface $serializer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'limit',
            'l',
            InputOption::VALUE_OPTIONAL,
            'tenant applications count limit of one launch, default 50'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (! $this->lock()) {
            $output->writeln('This command is already used by another process.');

            return Command::SUCCESS;
        }

        $io = new SymfonyStyle($input, $output);

        $limit = $input->getOption('limit') ? (int) $input->getOption('limit') : self::DEFAULT_LIMIT;
        $count = 0;
        try {
            foreach ($this->eventRepository->findUnsent($limit) as $eventEntity) {
                /** @var DomainEvent $event */
                $event = $this->serializer->deserialize(
                    json_encode($eventEntity->getPayload()),
                    $eventEntity->getType(),
                    'json'
                );

                $this->eventBus->dispatch($event);

                $eventEntity->sent();
                $this->entityManager->flush();

                $count++;
            }
        } catch (Throwable $exception) {
            $io->success(sprintf('Processed %d events.', $count));

            throw $exception;
        }

        $io->success(sprintf('Processed %d events.', $count));

        $this->release();

        return Command::SUCCESS;
    }
}

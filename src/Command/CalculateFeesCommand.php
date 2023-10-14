<?php

declare(strict_types=1);

namespace App\Command;

use App\Generator\FromFileJsonLineGeneratorInterface;
use App\Transaction\Factory\TransactionFactoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Calculates fees for given transactions.
 */
#[AsCommand('app:calculate-fees', 'Calculates fees for the given transactions.')]
final class CalculateFeesCommand extends Command
{
    /**
     * Constructor.
     *
     * @param TransactionFactoryInterface $transactionFactory Transaction factory
     * @param FromFileJsonLineGeneratorInterface $generator Generator
     * @param string $transactionsFolderPath Transaction factory
     */
    public function __construct(
        private readonly TransactionFactoryInterface $transactionFactory,
        private readonly FromFileJsonLineGeneratorInterface $generator,
        private readonly string $transactionsFolderPath,
    ) {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->addArgument(
            'file-name',
            InputArgument::REQUIRED,
            'File name.',
        );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generator->readFile($this->transactionsFolderPath . $input->getArgument('file-name'));
        foreach ($this->generator as $transactionData) {
            $transaction = $this->transactionFactory->createFromArray($transactionData);
            $output->writeln(sprintf('Transaction fee: %s', $transaction->getFee()));
        }

        return Command::SUCCESS;
    }
}

<?php


namespace App\Command;


use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAccount extends Command
{
    protected static $defaultName = 'app:import-accounts';

    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to file for import')
            ->setDescription('Creates a new account')
            ->setHelp("This command allows you to create an account");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
       // $filePath = 'import/accounts.csv';
        $filePath = $input->getArgument("filePath");

        try {
            $rows   = array_map('str_getcsv', file($filePath));
            foreach($rows as $row) {
                $data = explode(";",$row[0]);
                $account = new Account();

                $account
                    ->setUid($data[0])
                    ->setBalance($data[1]);
                $this->entityManager->persist($account);
            }

            $this->entityManager->flush();

        } catch (ORMException $exception) {
            $output->writeln("error writing accounts to db");
            $output->writeln($exception->getMessage());
            exit;
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            exit;
        }


        $output->writeln("accounts successfully added!");

        return 0;
    }


}



<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:list-users',
    description: 'Lists all the existing users',
    aliases: ['app:users']
)]
class ListUsersCommand extends Command
{
    public function __construct(
        private MailerInterface $mailer,
        private string $emailSender,
        private UserRepository $users
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setHelp(
                <<<'HELP'
                The <info>%command.name%</info> command lists all the users registered in the application:

                  <info>php %command.full_name%</info>

                By default the command only displays the 50 most recent users. Set the number of
                results to display with the <comment>--max-results</comment> option:

                  <info>php %command.full_name%</info> <comment>--max-results=2000</comment>

                In addition to displaying the user list, you can also send this information to
                the email address specified in the <comment>--send-to</comment> option:

                  <info>php %command.full_name%</info> <comment>--send-to=fabien@symfony.com</comment>
                HELP
            )
            ->addOption('max-results', null, InputOption::VALUE_OPTIONAL, 'Limits the number of users listed', 50)
            ->addOption('send-to', null, InputOption::VALUE_OPTIONAL, 'If set, the result is sent to the given email address');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $maxResults = $input->getOption('max-results');
        $allUsers = $this->users->findBy([], ['id' => 'DESC'], $maxResults);

        $usersAsPlainArrays = array_map(static function (User $user) {
            return [
                $user->getId(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getUsername(),
                $user->getEmail(),
                implode(', ', $user->getRoles()),
            ];
        }, $allUsers);

        $bufferedOutput = new BufferedOutput();
        $io = new SymfonyStyle($input, $bufferedOutput);
        $io->table(
            ['ID', 'First Name', 'Last Name', 'Username', 'Email', 'Roles'],
            $usersAsPlainArrays
        );

        $usersAsATable = $bufferedOutput->fetch();
        $output->write($usersAsATable);

        if (null !== $email = $input->getOption('send-to')) {
            $this->sendReport($usersAsATable, $email);
        }

        return Command::SUCCESS;
    }

    private function sendReport(string $contents, string $recipient): void
    {
        $email = (new Email())
            ->from($this->emailSender)
            ->to($recipient)
            ->subject(sprintf('app:list-users report (%s)', date('Y-m-d H:i:s')))
            ->text($contents);

        $this->mailer->send($email);
    }
}

<?php


namespace App\Command;

use App\Sockets\LiveStrawpoll;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Change the namespace according to your bundle
use App\live;
use Symfony\Component\Serializer\SerializerInterface;

class StartLive extends Command
{
    private $serializer;
    private $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entity_manager, ?string $name = null)
    {
        $this->serializer = $serializer;
        $this->em = $entity_manager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('sockets:start-chat')
            // the short description shown while running "php bin/console list"
            ->setHelp("Starts the chat socket demo")
            // the full command description shown when running the command with
            ->setDescription('Starts the chat socket demo')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void|null
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Chat socket',// A line
            '============',// Another line
            'Starting chat, open your browser.',// Empty line
        ]);

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new LiveStrawpoll($this->serializer, $this->em)
                )
            ),
            8090
        );

        $server->run();
    }
}
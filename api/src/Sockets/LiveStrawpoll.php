<?php

namespace App\Sockets;

use App\Entity\StrawpollOption;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class LiveStrawpoll
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class LiveStrawpoll implements MessageComponentInterface
{
    protected $clients;
    protected $serializer;
    protected $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entity_manager) {
        $this->serializer = $serializer;
        $this->em = $entity_manager;
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        $rep = $this->em->getRepository(StrawpollOption::class);

        /** @var StrawpollOption $starpoll_option */
        $starpoll_option = $rep->findOneBy(['id' => $msg]);
        $starpoll_option->vote();

        foreach ($this->clients as $client) {
            $client->send(
                $this->serializer->serialize(
                    $starpoll_option->getStrawpoll(),
                    'json',
                    ['groups' => 'group']
                )
            );
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
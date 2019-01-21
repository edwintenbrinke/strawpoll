<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class StrawpollOption
 *
 * @ORM\Table(name="strawpoll_option")
 * @ORM\Entity()
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class StrawpollOption
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("group")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Groups("group")
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Groups("group")
     */
    private $votes;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Entity\Strawpoll", inversedBy="options")
     */
    private $strawpoll;

    /**
     * @param $name
     * @param \App\Entity\Strawpoll $strawpoll
     * @return $this
     */
    public function create($name, Strawpoll $strawpoll)
    {
        $this->name = $name;
        $this->votes = 0;
        $this->strawpoll = $strawpoll;

        return $this;
    }

    public function vote()
    {
        $this->votes++;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getVotes(): int
    {
        return $this->votes;
    }

    /**
     * @return mixed
     */
    public function getStrawpoll()
    {
        return $this->strawpoll;
    }
}
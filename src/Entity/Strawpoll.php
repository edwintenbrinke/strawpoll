<?php


namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Strawpoll
 *
 * @ORM\Table(name="strawpoll")
 * @ORM\Entity()
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class Strawpoll
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
     * @var string
     * @ORM\Column(type="string")
     * @Groups("group")
     */
    private $url_key;

    /**
     * @var \App\Entity\StrawpollOption[]
     * @ORM\OneToMany(targetEntity="App\Entity\StrawpollOption", mappedBy="strawpoll", cascade={"persist"})
     * @Groups("group")
     */
    private $options;

    /**
     * @param $data
     * @return \App\Entity\Strawpoll
     */
    public function create($data)
    {
        $this->name = $data['name'];

        $this->url_key = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);

        foreach($data['options'] as $option)
        {
            $strawpoll_option = new StrawpollOption();
            $this->options[] = $strawpoll_option->create($option, $this);;
        }

        return $this;
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
     * @return string
     */
    public function getUrlKey(): string
    {
        return $this->url_key;
    }

    /**
     * @return \App\Entity\StrawpollOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }


}
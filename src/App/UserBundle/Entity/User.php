<?php

namespace App\UserBundle\Entity;

use App\IMBundle\Entity\Message;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\App\IMBundle\Entity\Chat", mappedBy="users")
     */
    private $chats;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="\App\IMBundle\Entity\Message")
     * @ORM\JoinTable(name="unseen")
     */
    private $unseens;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->unseens = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add chats
     *
     * @param \App\IMBundle\Entity\Chat $chats
     * @return User
     */
    public function addChat(\App\IMBundle\Entity\Chat $chats)
    {
        $this->chats[] = $chats;
    
        return $this;
    }

    /**
     * Remove chats
     *
     * @param \App\IMBundle\Entity\Chat $chats
     */
    public function removeChat(\App\IMBundle\Entity\Chat $chats)
    {
        $this->chats->removeElement($chats);
    }

    /**
     * Get chats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChats()
    {
        return $this->chats;
    }

    /**
     * Add unseens
     *
     * @param \App\IMBundle\Entity\Message $unseens
     * @return User
     */
    public function addUnseen(\App\IMBundle\Entity\Message $unseens)
    {
        $this->unseens[] = $unseens;
    
        return $this;
    }

    /**
     * Remove unseens
     *
     * @param \App\IMBundle\Entity\Message $unseens
     */
    public function removeUnseen(\App\IMBundle\Entity\Message $unseens)
    {
        $this->unseens->removeElement($unseens);
    }

    /**
     * Get unseens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnseens()
    {
        return $this->unseens;
    }
}
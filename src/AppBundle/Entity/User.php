<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    const USER_ROLE = 'admin';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="Privilege", mappedBy="userId")
     * @ORM\OneToMany(targetEntity="Course", mappedBy="userId")
     * @ORM\OneToMany(targetEntity="Download", mappedBy="userId")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="transcriptId", type="integer", unique=true)
     */
    private $transcriptId;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastActivity", type="datetime", nullable=true)
     */
    private $lastActivity;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set transcriptId
     *
     * @param integer $transcriptId
     *
     * @return User
     */
    public function setTranscriptId($transcriptId)
    {
        $this->transcriptId = $transcriptId;

        return $this;
    }

    /**
     * Get transcriptId
     *
     * @return int
     */
    public function getTranscriptId()
    {
        return $this->transcriptId;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastActivity
     *
     * @param \DateTime $lastActivity
     *
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return \DateTime
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }
}

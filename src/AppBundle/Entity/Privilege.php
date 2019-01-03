<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Privilege
 *
 * @ORM\Table(name="privilege")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrivilegeRepository")
 */
class Privilege
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="clearanceLevel", type="boolean", nullable=true)
     */
    private $clearanceLevel;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="privileges")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    private $file;


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
     * Set clearanceLevel
     *
     * @param boolean $clearanceLevel
     *
     * @return Privilege
     */
    public function setClearanceLevel($clearanceLevel)
    {
        $this->clearanceLevel = $clearanceLevel;

        return $this;
    }

    /**
     * Get clearanceLevel
     *
     * @return bool
     */
    public function getClearanceLevel()
    {
        return $this->clearanceLevel;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return Privilege
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set file
     *
     * @param integer $file
     *
     * @return Privilege
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return int
     */
    public function getFile()
    {
        return $this->file;
    }
}

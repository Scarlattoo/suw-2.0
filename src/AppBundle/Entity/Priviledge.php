<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Priviledge
 *
 * @ORM\Table(name="priviledge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriviledgeRepository")
 */
class Priviledge
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
     *
     * @ORM\Column(name="userId", type="integer")
     * @ORM\OneToOne(targetEntity="User", inversedBy="PriviledgeUser")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="fileId", type="integer")
     * @ORM\OneToOne(targetEntity="File", inversedBy="PriviledgeFile")
     * @ORM\JoinColumn(name="fileId", referencedColumnName="id")
     */
    private $fileId;


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
     * @return Priviledge
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Priviledge
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set fileId
     *
     * @param integer $fileId
     *
     * @return Priviledge
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * Get fileId
     *
     * @return int
     */
    public function getFileId()
    {
        return $this->fileId;
    }
}

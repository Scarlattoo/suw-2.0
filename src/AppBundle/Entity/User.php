<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="transcriptId", message="Użytkownik o podanym numerze już istnieje.")
 */
class User implements UserInterface, \Serializable
{
    public function __toString()
    {
        return (string) $this->getUsername();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="transcriptId", type="integer", unique=true)
     * @Assert\NotBlank
     * @Assert\Type(type="integer", message="Numer indeksu musi być liczbą.", groups={"default"})
     */
    private $transcriptId;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=4096)
     * @RollerworksPassword\PasswordRequirements(requireLetters=true, requireNumbers=true, requireCaseDiff=true, minLength=7,
     *     tooShortMessage = "Twoje hasło musi posiadać co najmniej {{length}} znaków.",
     *     missingLettersMessage = "Twoje hasło musi posiadać co najmniej jedną literę.",
     *     requireCaseDiffMessage = "Twoje hasło musi posiadać małe i duże litery.",
     *     missingNumbersMessage = "Twoje hasło musi posiadać co najmniej jedną cyfrę.",
     * )
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100)
     */
    private $password;


    /**
     * @var string
     * @ORM\Column(name="lectures_password", type="string", length=100)
     * @Assert\Length(max=100, maxMessage="Hasło zbyt długie", min="7", minMessage="Hasło powinno mieć przynajmniej 7 znaków")
     * @Assert\NotBlank(message="Hasło nie może być puste")
     */
    private $LecturesPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastActivity", type="datetime")
     */
    private $lastActivity;

    /**
     * @var array
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="user")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="userId")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="Download", mappedBy="user")
     */
    private $downloads;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Privilege", mappedBy="user")
     */
    private $privileges;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->downloads = new ArrayCollection();
        $this->privileges = new ArrayCollection();
    }

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
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
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
     * @return string
     */
    public function getLecturesPassword()
    {
        return $this->LecturesPassword;
    }

    /**
     * @param string $Lecturespassword
     */
    public function setLecturesPassword($LecturesPassword)
    {
        $this->LecturesPassword = $LecturesPassword;
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

    /**
     * @return ArrayCollection|Course[]
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @return ArrayCollection|File[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return ArrayCollection|Download[]
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
     * @return ArrayCollection|Privilege[]
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->transcriptId,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->transcriptId,
            $this->password
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function setRoles($roles) {
        $this->roles = array_unique(array_merge($roles, $this->getRoles()));
    }
    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->transcriptId;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

}
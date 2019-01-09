<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File
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
     * @var string
     * @Assert\Length(max=255, maxMessage="Tytuł jest za długi, max 255 znaków.", groups={"default"})
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @Assert\Length(max=255, maxMessage="Opis jest za długi, max 255 znaków.", groups={"default"})
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var string
     * @Assert\Length(max=255, maxMessage="Typ jest za długi, max 255 znaków.", groups={"default"})
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     * @Assert\Length(max=255, maxMessage="Nazwa pliku jest za długa, max 255 znaków.", groups={"default"})
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="Proszę wybrać kurs.", groups={"default"})
     */
    private $course;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="files")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $userId;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Proszę wybrać plik PDF do wysłania.", groups={"newFile"})
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     maxSizeMessage = "Plik powinien być mniejszy niż {{ limit }}{{ suffix }}",
     *     uploadIniSizeErrorMessage = "Plik powinien być mniejszy niż {{ limit }}{{ suffix }}",
     *     uploadFormSizeErrorMessage = "Plik powinien być mniejszy niż {{ limit }}{{ suffix }}",
     *     mimeTypesMessage = "Proszę wybrać plik typu PDF",
     *     disallowEmptyMessage = "Plik nie może być pusty",
     *     groups={"default"}
     *     )
     */
    private $lectureFile;

    /**
     *
     * @return mixed
     */
    public function getLectureFile()
    {
        return $this->lectureFile;
    }

    /**
     * @param string $lectureFile
     */
    public function setLectureFile($lectureFile)
    {
        $this->lectureFile = $lectureFile;
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
     * Set title
     *
     * @param string $title
     *
     * @return File
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return File
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return File
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return File
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set course
     *
     * @param integer $course
     *
     * @return File
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return int
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set user
     *
     * @param integer $userId
     *
     * @return File
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function __toString()
    {
        return (string) $this->getFilename();
    }
}

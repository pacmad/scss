<?php
namespace SCSS\CourseBundle\Traits;

trait RequirementTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(type="string")
     * @Assert\MaxLength(250)
     * @var string
     */
    protected $name;

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
     * Set name
     *
     * @param string $name name
     *
     * @return Requirement
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

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
     * Set description
     *
     * @param string $description string
     *
     * @return Requirement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="SCSS\CourseBundle\Entity\Requirement", inversedBy="requirement")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent = '';

    /**
     * Get parent
     *
     * @return Requirement
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set requirement
     *
     * @param Requirement $parent parent
     *
     * @return Requirement
     */
    public function setParent(Requirement $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="SCSS\CourseBundle\Entity\Course", inversedBy="requirement")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course = '';

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set course
     *
     * @param Course $course course
     *
     * @return Requirement
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Optional
     *
     * @param  boolean        $optional optional
     * @return boolean|Course
     */
    protected $optional;

    /**
     * Is optional
     * @param  boolean|null        $optional optional
     * @return boolean|Requirement
     */
    public function isOptional($optional = null)
    {
        if (null != $optional && is_bool($optional)) {
            $this->optional = $optional;

            return $this;
        }

        return $this->optional;
    }
}

<?php
namespace SCSS\CourseBundle\Entity;

use SCSS\UtilityBundle\Traits\SluggableTrait;
use SCSS\UtilityBundle\Traits\TimestampableTrait;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="SCSS\CourseBundle\Repository\SCSSClassRepository")
 * @ORM\Table(name="scss_class")
 */
class SCSSClass
{
    use SluggableTrait;
    use TimestampableTrait;
    

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
     * @Assert\Length(
     *      min = "1",
     *      max = "250",
     *      minMessage = "Name must be at least {{ limit }} characters length",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters length"
     * )
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
     * @return Class
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="SCSS\CourseBundle\Entity\FacilityCourse", inversedBy="class")
     * @ORM\JoinColumn(name="facility_course_id", referencedColumnName="id")
     */
    protected $facilityCourse = '';

    /**
     * Get facility course
     *
     * @return FacilityCourse
     */
    public function getFacilityCourse()
    {
        return $this->facilityCourse;
    }

    /**
     * Set facility course
     *
     * @param  FacilityCourse $facilityCourse faciltiy course
     * @return FacilityCourse
     */
    public function setFacilityCourse(FacilityCourse $facilityCourse)
    {
        $this->facilityCourse = $facilityCourse;

        return $this->facilityCourse;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->facilityCourse->getCourse();
    }

    /**
     * @ORM\ManyToOne(targetEntity="SCSS\FacilityBundle\Entity\Department", inversedBy="class")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    protected $department = '';

    /**
     * Get department
     *
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set department
     *
     * @param Department $department department
     *
     * @return Class
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="SCSS\FacilityBundle\Entity\Faculty", inversedBy="class")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     */
    protected $faculty = '';

    /**
     * Get faculty
     *
     * @return Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param Faculty $faculty faculty
     *
     * @return Class
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $capacity;

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set capacity
     *
     * @param  integer $capacity capacity
     * @return Course
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Enabled
     *
     * @param  boolean        $enabled enabled
     * @return boolean|Course
     */
    protected $enabled;

    public function isEnabled($enabled = null)
    {
        if (null != $enabled && is_bool($enabled)) {
            $this->enabled = $enabled;

            return $this;
        }

        return $this->enabled;
    }
}

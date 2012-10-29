<?php
namespace Scss\FacilityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Scss\FacilityBundle\Entity\Faculty;

class FacultyType extends AbstractType {
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('borthdate', 'birthday');
    $builder->add('title');
    $builder->add('facility');
    
  }
  
  public function getName() {
    return 'faculty';
  }
}
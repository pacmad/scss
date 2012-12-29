<?php
namespace Scss\OrganizationBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Scss\OrganizationBundle\Entity\Passel;

class FactionRepository extends EntityRepository
{
    public function filterByPassel( $passel )
    {
        if( $passel instanceof Passel )
        {
            $passel = $passel->getId();
        }
        elseif( ( $passel === null ) || !is_numeric($passel) )
        {
            $passel = 0;
        }
        
        return $this->getEntityManager()
            ->createQuery( 'SELECT f FROM ScssOrganizationBundle:Faction f WHERE a.passel = :passel ORDER BY f.name ASC' )
            ->setParameter( 'passel', $passel )
            ->getResult();
    }   
}
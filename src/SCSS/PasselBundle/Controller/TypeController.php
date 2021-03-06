<?php
namespace SCSS\PasselBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SCSS\PasselBundle\Entity\Type;
use SCSS\PasselBundle\Form\Type\TypeType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\View\TwitterBootstrapView;

class TypeController extends Controller
{
    /**
     * @Route("/", name="scss_passel_type_index")
     * @Template("SCSSPasselBundle:Type:index.html.twig")
     */
    public function indexAction()
    {
        // get route name/params to decypher data to delimit by
        $query = $this->get('doctrine')
            ->getRepository('SCSSPasselBundle:Type')
            ->createQueryBuilder('l')
            ->orderBy('l.updated, l.name', 'ASC');

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 5));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return array(
          'types' => $pager->getCurrentPageResults(),
          'pager'  => $pager
        );
    }

    /**
     * @Route("/{slug}", name="scss_passel_type_show")
     * @Template("SCSSPasselBundle:Type:show.html.twig")
     */
    public function showAction( $slug )
    {
        $type = $this->getDoctrine()
            ->getRepository('SCSSPasselbundle:Type')
            ->findOneBySlug($slug);

        if (!$type) {
            $this->get('session')
                ->getFlashBag()->add(
                    'error',
                    'no matching type found.'
                );
            $this->redirect($this->generateUrl('scss_passel_type_index'));
        }

        return array('type' => $type);
    }


    /**
     * @Route("/new", name="scss_passel_type_new")
     * @Template("SCSSPasselbundle:Type:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $type = new Type();
        $form = $this->createForm(new TypeType(), $type);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($type);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'type created.'
                );

                return $this->render(
                    'SCSSPasselbundle:Type:show.html.twig',
                    array(
                        'type' => $type
                    )
                );
            }
        }

        return array('form' => $form->createView());
    }
}

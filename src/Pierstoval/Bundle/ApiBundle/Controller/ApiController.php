<?php

namespace Pierstoval\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{serviceName}", host="%esteren_domains.api%")
 */
class ApiController extends FOSRestController
{
    private $services;
    private $serviceName;

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function cgetAction($serviceName, Request $request)
    {
        $this->checkAsker($request);

        $service = $this->getService($serviceName);

        $datas = $this->getDoctrine()->getManager()->getRepository($service['entity'])->findAll();

        $datas = array($serviceName => $datas);

        return $this->view($datas);
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"}, defaults={"subElement"=""})
     * @Route("/{id}/{subElement}", requirements={"subElement"="([a-zA-Z0-9\._]/?)+","id"="\d+"})
     * @Method({"GET"})
     * @param string $serviceName
     * @param integer $id
     * @param string $subElement
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function getAction($serviceName, $id, $subElement = null, Request $request)
    {
        $this->checkAsker($request);

        $service = $this->getService($serviceName);

        /** @var EntityRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository($service['entity']);

        // Récupération des données
        $data = $repo->find($id);

        // La clé se voit supprimer son "s" en fin de chaîne
        $key = rtrim($serviceName, 's');

        if ($subElement) {

            $elements = explode('/', trim($subElement, '/'));

            $class = $service['entity'];
            if (count($elements)) {
                $key .= '.'.$data->getId();
            }

            foreach ($elements as $k => $element) {

                if (!$class) {
                    $class = $this->getService($element, false);
                    if ($class) {
                        $class = $class['entity'];
                    } elseif (!($data instanceof Collection)) {
                        $class = get_class($data);
                    } else {
                        $class = null;
                    }
                }

                if ($class) {
                    // Seulement à la première occurrence
                    $metadatas = $this->get('jms_serializer')->getMetadataFactory()->getMetadataForClass($class);

                    if (isset($metadatas->propertyMetadata[$element])) {
                        $subService = $this->getService($element, false);
                        if ($subService) {
                            $data = $data->{'get'.ucfirst($element)}();
                            $key .= '.'.$element;
                        } else {
                            $subService = $this->getService($element.'s', false);
                            if ($subService) {
                                $data = $data->{'get'.ucfirst($element)}();
                                $key .= '.'.$element;
                            } else {
                                throw $this->createNotFoundException('No attribute "'.$element.'" available for this object. #1');
                            }
                        }
                    } elseif (isset($metadatas->propertyMetadata[preg_replace('#s$#isUu', '', $element)])) {
                        $element = preg_replace('#s$#isUu', '', $element);
                        $subService = $this->getService($element, false);
                        if ($subService) {
//                            $subEntity = new $subService['entity']();
                            $data = $data->{'get'.ucfirst($element)}();
                            $key .= '.'.$element;
                        } else {
                            throw $this->createNotFoundException('No attribute "'.$element.'" available for this object. #2');
                        }
                    } else {
                        if (method_exists($data, 'get'.ucfirst($element))) {
                            $data = $data->{'get'.ucfirst($element)}();
                        } elseif (method_exists($data, 'get'.preg_replace('#s$#isUu','',ucfirst($element)))) {
                            $data = $data->{'get'.preg_replace('#s$#isUu','',ucfirst($element))}();
                        } else {
                            throw $this->createNotFoundException('No attribute "'.$element.'" available for this object. #3');
                        }
                    }
                } elseif (is_numeric($element)) {
                    $element = (int) $element;
                    if ($data instanceof Collection) {

                        $data = $data->filter(
                            function($entry) use ($element) {
                               return $entry->getId() == $element;
                            }
                        );
                        $data = $data->first();
                        $key .= '.'.$element;
                    } else {
                        throw $this->createNotFoundException('Elements not found');
                    }
                } else {
                    throw $this->createNotFoundException('No attribute "'.$element.'" available for this object. #4');
                }
                $class = null;
            }
        }

        $data = array($key => $data);

        return $this->view($data);
    }

    /**
     * @Route("/")
     * @Method({"PUT"})
     */
    public function putAction($serviceName, $id, Request $request)
    {
        $this->checkAsker($request);
    }

    /**
     * @Route("/{id}")
     * @Method({"POST"})
     */
    public function postAction($serviceName, $id, Request $request)
    {
        $this->checkAsker($request);
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction($serviceName, $id, Request $request)
    {
        $this->checkAsker($request);
    }


    /*--------------------------------------------------
    ----------------- MÉTHODES PRIVÉES -----------------
    --------------------------------------------------*/

    /**
     * @param Request $request
     * @throws AccessDeniedException
     */
    private function checkAsker(Request $request)
    {
        $this->container->get('pierstoval.api.originChecker')->checkRequest($request);
    }

    /**
     * @param string $serviceName
     * @param bool $throwException
     * @return null
     */
    private function getService($serviceName, $throwException = true) {
        if (!$this->services) {
            $this->services = $this->container->getParameter('pierstoval_api.services');
        }
        if (isset($this->services[$serviceName])) {
            $this->serviceName = $serviceName;
            return $this->services[$serviceName];
        }
        if ($throwException) {
            throw $this->createNotFoundException("Service \"$serviceName\" not found in the API.\nDid you forget to specify it in your configuration ?\nAvailable services : ".implode(', ',array_keys($this->services)));
        }
        return null;
    }

    /**
     * @param mixed $data
     * @param integer $statusCode
     * @param array $headers
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    protected function view($data = NULL, $statusCode = NULL, array $headers = Array()) {
        $view = parent::view($data, $statusCode, $headers);
        $view->setFormat($this->container->getParameter('pierstoval_api.format'));
        $view->setHeader('Content-type', 'application/json; charset=utf-8');

        return $this->handleView($view);
    }
}

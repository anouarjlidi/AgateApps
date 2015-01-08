<?php

namespace Pierstoval\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/", requirements={"serviceName":"([a-zA-Z0-9\._]?)+"})
 */
class ApiController extends FOSRestController
{
    private $services;
    private $serviceName;

    /**
     * @Route("/{serviceName}")
     * @Method({"GET"})
     * @Cache(maxage=0, expires="yesterday")
     *
     * @param $serviceName
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction($serviceName, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $service = $this->getService($serviceName);

        $datas = $this->getDoctrine()->getManager()->getRepository($service['entity'])->findAll();

        $datas = array($serviceName => $datas);

        return $this->view($datas);
    }

    /**
     * @Route("/{serviceName}/{id}", requirements={"id": "\d+"}, defaults={"subElement": ""}, name="pierstoval_api_api_get")
     * @Route("/{serviceName}/{id}/{subElement}", requirements={"subElement": "([a-zA-Z0-9\._]/?)+", "id": "\d+"}, name="pierstoval_api_api_get_subrequest")
     * @Method({"GET"})
     * @Cache(maxage=0, expires="yesterday")
     *
     * @param string $serviceName
     * @param integer $id
     * @param string $subElement
     * @param Request $request
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function getAction($serviceName, $id, $subElement = null, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

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
                $key .= '.' . $data->getId();
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
                    $metadatas = $this->container->get('jms_serializer')->getMetadataFactory()->getMetadataForClass($class);

                    if (isset($metadatas->propertyMetadata[$element])) {
                        $subService = $this->getService($element, false);
                        if ($subService) {
                            $data = $data->{'get' . ucfirst($element)}();
                            $key .= '.' . $element;
                        } else {
                            $subService = $this->getService($element . 's', false);
                            if ($subService) {
                                $data = $data->{'get' . ucfirst($element)}();
                                $key .= '.' . $element;
                            } else {
                                throw $this->createNotFoundException('No attribute "' . $element . '" available for this object. #1');
                            }
                        }
                    } elseif (isset($metadatas->propertyMetadata[preg_replace('#s$#isUu', '', $element)])) {
                        $element = preg_replace('#s$#isUu', '', $element);
                        $subService = $this->getService($element, false);
                        if ($subService) {
//                            $subEntity = new $subService['entity']();
                            $data = $data->{'get' . ucfirst($element)}();
                            $key .= '.' . $element;
                        } else {
                            throw $this->createNotFoundException('No attribute "' . $element . '" available for this object. #2');
                        }
                    } else {
                        if (method_exists($data, 'get' . ucfirst($element))) {
                            $data = $data->{'get' . ucfirst($element)}();
                        } elseif (method_exists($data, 'get' . preg_replace('#s$#isUu', '', ucfirst($element)))) {
                            $data = $data->{'get' . preg_replace('#s$#isUu', '', ucfirst($element))}();
                        } else {
                            throw $this->createNotFoundException('No attribute "' . $element . '" available for this object. #3');
                        }
                    }
                } elseif (is_numeric($element)) {
                    $element = (int)$element;
                    if ($data instanceof Collection) {

                        $data = $data->filter(
                            function ($entry) use ($element) {
                                return method_exists($element, 'getId') && $entry->getId() == $element;
                            }
                        );
                        $data = $data->first();
                        $key .= '.' . $element;
                    } else {
                        throw $this->createNotFoundException('Elements not found');
                    }
                } else {
                    throw $this->createNotFoundException('No attribute "' . $element . '" available for this object. #4');
                }
                $class = null;
            }
        }

        $data = array($key => $data);

        return $this->view($data);
    }

    /**
     * @Route("/{serviceName}", name="pierstoval_api_api_put")
     * @Method({"PUT"})
     * @param $serviceName
     * @param Request $request
     * @return false|\Symfony\Component\HttpFoundation\Response
     */
    public function putAction($serviceName, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }
    }

    /**
     * @Route("/{serviceName}/{id}", requirements={"id": "\d+"}, name="pierstoval_api_api_post")
     * @Method({"POST"})
     * @param $serviceName
     * @param $id
     * @param Request $request
     * @return false|\Symfony\Component\HttpFoundation\Response
     */
    public function postAction($serviceName, $id, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }
        $service = $this->getService($serviceName);

        $serviceName = rtrim($serviceName, 's');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($service['entity']);

        $object = $repo->createQueryBuilder('o')
            ->where('o.id = :id')
            ->getQuery()
            ->setParameter('id', $id)
            ->getOneOrNullResult(Query::HYDRATE_ARRAY);

        if (!$object) {
            return $this->createNotFoundException();
        }

        // Merge
        $userObject = array_merge($object, $request->request->all());

        // Serialize POST and deserialize to get full object
        $serializer = $this->container->get('serializer');
        $json = $serializer->serialize($userObject, 'json');
        $userObject = $serializer->deserialize($json, $service['entity'], 'json');

        $errors = $this->get('validator')->validate($userObject);

        if (!count($errors)) {

            $em->merge($userObject);
            $em->flush();

            $userObject = $repo->find($id);

            $datas = array(
                'old'.ucfirst($serviceName) => $object,
                'new'.ucfirst($serviceName) => $userObject,
            );

        } else {
            $datas = array(
                'error' => true,
                'msg' => $this->get('translator')->trans('Invalid form, please re-check.'),
                'errors' => $errors,
            );
        }

        return $this->view($datas);
    }

    /**
     * @Route("/{serviceName}/{id}", requirements={"id": "\d+"}, name="pierstoval_api_api_delete")
     * @Method({"DELETE"})
     * @param $serviceName
     * @param $id
     * @param Request $request
     * @return false|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($serviceName, $id, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }
    }

    /*--------------------------------------------------
    ----------------- MÉTHODES PRIVÉES -----------------
    --------------------------------------------------*/

    /**
     * @param Request $request
     * @return false|Response
     * @throws AccessDeniedException
     */
    private function checkAsker(Request $request)
    {
        try {
            $this->container->get('pierstoval.api.originChecker')->checkRequest($request);
            return false;
        } catch (AccessDeniedException $e) {
            return new Response($e->getMessage(), 403);
        }
    }

    /**
     * @param string $serviceName
     * @param bool $throwException
     * @return null
     */
    private function getService($serviceName, $throwException = true)
    {
        if (!$this->services) {
            $this->services = $this->container->getParameter('pierstoval_api.services');
        }
        if (isset($this->services[$serviceName])) {
            $this->serviceName = $serviceName;
            return $this->services[$serviceName];
        }
        if ($throwException) {
            throw $this->createNotFoundException("Service \"$serviceName\" not found in the API.\nDid you forget to specify it in your configuration ?\nAvailable services : " . implode(', ',
                    array_keys($this->services)));
        }
        return null;
    }

    /**
     * @param mixed $data
     * @param integer $statusCode
     * @param array $headers
     * @return \FOS\RestBundle\View\View|\Symfony\Component\HttpFoundation\Response
     */
    protected function view($data = null, $statusCode = null, array $headers = Array())
    {
        $view = parent::view($data, $statusCode, $headers);
        $view->setFormat($this->container->getParameter('pierstoval_api.format'));
        $view->setHeader('Content-type', 'application/json; charset=utf-8');

        return $this->handleView($view);
    }
}

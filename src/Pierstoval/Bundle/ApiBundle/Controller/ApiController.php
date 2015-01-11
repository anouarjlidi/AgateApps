<?php

namespace Pierstoval\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/", requirements={"serviceName":"([a-zA-Z0-9\._]?)+"}, defaults={"_format":"json"})
 */
class ApiController extends FOSRestController
{
    private $services;
    private $serviceName;

    /**
     * @Route("/{serviceName}", defaults={"_format": "json"}, name="pierstoval_api_cget")
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
        if ($service instanceof Response) {
            return $service;
        }

        $datas = $this->getDoctrine()->getManager()->getRepository($service['entity'])->findAll();

        $datas = array($serviceName => $datas);

        return $this->view($datas);
    }

    /**
     * @Route("/{serviceName}/{id}", requirements={"id": "\d+"}, defaults={"subElement": ""}, name="pierstoval_api_get")
     * @Route("/{serviceName}/{id}/{subElement}", requirements={"subElement": "([a-zA-Z0-9\._]/?)+", "id": "\d+"}, name="pierstoval_api_get_subrequest")
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
        $this->checkAsker($request);

        $service = $this->getService($serviceName);

        /** @var EntityRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository($service['entity']);

        // Récupération des données
        $data = $repo->find($id);

        // La clé se voit supprimer son "s" en fin de chaîne
        $key = rtrim($serviceName, 's');

        if ($subElement) {
            $this->fetchSubElement($subElement, $service, $key, $data);
        }

        $data = array($key => $data);

        return $this->view($data);
    }

    /**
     * @Route("/{serviceName}", name="pierstoval_api_put")
     * @Method({"PUT"})
     * @param $serviceName
     * @param Request $request
     * @return false|\Symfony\Component\HttpFoundation\Response
     */
    public function putAction($serviceName, Request $request)
    {
        $this->checkAsker($request);
    }

    /**
     * @Route("/{serviceName}/{id}.{_format}", requirements={"id": "\d+"}, defaults={"_format":"json"}, name="pierstoval_api_post")
     * @Method({"POST"})
     * @param $serviceName
     * @param $id
     * @param Request $request
     * @return false|\Symfony\Component\HttpFoundation\Response
     */
    public function postAction($serviceName, $id, Request $request)
    {
        $this->checkAsker($request);

        $datas = array();

        $serializer = $this->container->get('serializer');
        $service = $this->getService($serviceName);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($service['entity']);

        // Get full item from database
        $object = $repo->find($id);

        if (!$object) {
            throw $this->createNotFoundException('Object of type "'.$serviceName.'" not found.');
        }

        $post = $request->request;

        // The user object has to be the "json" parameter
        $userObject = $post->has('json') ? $post->get('json') : null;

        if (!$userObject) {
            return $this->error('You must specify the "%param%" parameter.', array('%param%' => 'json'));
        }
        if (is_string($userObject)) {
            // Allows either JSON string or array
            $userObject = json_decode($post->get('json'), true);
            if (!$userObject) {
                return $this->error('Error while parsing json.');
            }
        }

        if ($post->get('mapping')) {
            $object = $this->container->get('pierstoval_api.entity_merger')->merge($object, $userObject, $post->get('mapping'));
        } else {
            // Transform the full item recursively into an array
            $object = $serializer->deserialize($serializer->serialize($object, 'json'), 'array', 'json');
            $requestObject = json_decode($request->get('json'), true);

            // Merge the two arrays with request parameters
            $userObject = array_merge($object, $requestObject);

            // Serialize POST and deserialize to get full object
            $json = $serializer->serialize($userObject, 'json');
            $object = $serializer->deserialize($json, $service['entity'], 'json');
        }

        $errors = $this->get('validator')->validate($object);

        if (!count($errors)) {

            $em->merge($object);
            $em->flush();

            $datas['newObject'] = $repo->find($id);
        } else {
            return $this->view(array(
                'error' => true,
                'message' => $this->get('translator')->trans('Invalid form, please re-check. Errors', array(), 'pierstoval_api.exceptions'),
                'errors' => $errors,
            ), 500);
        }

        return $this->view($datas);
    }

    /**
     * @Route("/{serviceName}/{id}", requirements={"id": "\d+"}, name="pierstoval_api_delete")
     * @Method({"DELETE"})
     * @param $serviceName
     * @param $id
     * @param Request $request
     * @return View
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
     * @return false|Response
     * @throws AccessDeniedException
     */
    private function checkAsker(Request $request)
    {
        $this->container->get('pierstoval.api.originChecker')->checkRequest($request);
    }

    /**
     * Retrieves a service name depending
     * @param string $serviceName
     * @param bool $throwException
     * @throws \InvalidArgumentException
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
            if ($this->container->get('kernel')->getEnvironment() === 'prod') {
                throw new \InvalidArgumentException($this->get('translator')->trans('Unrecognized service %service%', array('%service%' => $serviceName,)),1);
            } else {
                throw new \InvalidArgumentException($this->get('translator')->trans(
                    "Service \"%service%\" not found in the API.\n" .
                    "Did you forget to specify it in your configuration ?\n" .
                    "Available services : %services%",
                    array('%service%' => $serviceName, '%services%' => implode(', ', array_keys($this->services)),)
                ), 1);
            }
        }
        return null;
    }

    /**
     * @param mixed $data
     * @param integer $statusCode
     * @param array $headers
     * @return \FOS\RestBundle\View\View
     */
    protected function view($data = null, $statusCode = null, array $headers = Array())
    {
        $view = parent::view($data, $statusCode, $headers);
        $view->setFormat($this->container->getParameter('pierstoval_api.format'));
        $view->setHeader('Content-type', 'application/json; charset=utf-8');

        return $this->handleView($view);
    }

    /**
     * Handles a classic error (not an exception).
     * The difference between this method and an exception is that with this method you can specify HTTP code.
     * @param string $message
     * @param array $messageParams
     * @param int $code
     * @return \FOS\RestBundle\View\View
     */
    protected function error($message = '', $messageParams = array(), $code = 404) {
        $message = $this->get('translator')->trans($message, $messageParams, 'pierstoval_api.exceptions');

        return $this->view(array(
            'error' => true,
            'message' => $message,
        ), $code);
    }

    /**
     * Parse the subelement request from "get" action in to get a fully "recursive" parameter check.
     *
     * @param array $subElement
     * @param array $service
     * @param string $key
     * @param mixed $data
     */
    private function fetchSubElement($subElement, $service, &$key, &$data) {

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
                            throw $this->createNotFoundException('No attribute "' . $element . '" available for "'.$subService.'" object. #1');
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
                throw $this->createNotFoundException('No attribute "' . $element . '" available for "'.$class.'" object. #4');
            }
            $class = null;
        }
    }
}

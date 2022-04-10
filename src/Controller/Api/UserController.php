<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\Type\UserFormType;
use App\Model\Exception\UserNotFound;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/user")
     * @Rest\View(serializerGroups={"user"},serializerEnableMaxDepthChecks=true)
     */
    public function getAction(UserRepository $userRepository)
    {
        return $userRepository->findBy(['deletedAt' => NULL]);
    }

    /**
     * @Rest\Get("/user/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"},serializerEnableMaxDepthChecks=true)
     */
    public function getSingleAction(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        if (!$user) {
            UserNotFound::throwException();
        }
        return $user;
    }

    /**
     * @Rest\Post("/user")
     * @Rest\View(serializerGroups={"user"},serializerEnableMaxDepthChecks=true)
     */
    public function postAction(UserRepository $userRepository, Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return $userRepository->save($user);
        }

        return $form;
    }

    /**
     * @Rest\Put("/user/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"},serializerEnableMaxDepthChecks=true)
     */
    public function putAction(int $id, UserRepository $userRepository, Request $request)
    {

        $user = $userRepository->find($id);
        if (!$user) {
            UserNotFound::throwException();
        }
        $form = $this->createForm(UserFormType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return $userRepository->update($user);
        }

        return $form;
    }

    /**
     * @Rest\Delete("/user/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"},serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        if (!$user) {
            UserNotFound::throwException();
        }
        return $userRepository->delete($user);
    }
}

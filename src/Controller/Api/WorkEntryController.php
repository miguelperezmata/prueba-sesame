<?php

namespace App\Controller\Api;

use App\Entity\WorkEntry;
use App\Form\Type\WorkEntryFormType;
use App\Model\Exception\UserNotFound;
use App\Model\Exception\WorkEntryException;
use App\Repository\UserRepository;
use App\Repository\WorkEntryRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkEntryController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/work_entry/user/{userId}", requirements={"userId"="\d+"})
     * @Rest\View(serializerGroups={"work", "user"},serializerEnableMaxDepthChecks=true)
     */
    public function getByUserAction(int $userId, WorkEntryRepository $workEntryRepository, UserRepository $userRepository)
    {
        $user = $userRepository->findBy([
            'deletedAt' => null
        ]);
        if (!$user) {
            UserNotFound::throwException();
        }
        return $workEntryRepository->findBy(['userId' => $user, 'deletedAt' => null]);
    }

    /**
     * @Rest\Get("/work_entry/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"work", "user"},serializerEnableMaxDepthChecks= true)
     */
    public function getSingleAction(int $id, WorkEntryRepository $workEntryRepository)
    {
        $workEntry = $workEntryRepository->find($id);
        if (!$workEntry) {
            WorkEntryException::throwException();
        }
        return $workEntry;
    }

    /**
     * @Rest\Post("/work_entry")
     * @Rest\View(serializerGroups={"work", "user"},serializerEnableMaxDepthChecks=true)
     */
    public function postAction(WorkEntryRepository $workEntryRepository, Request $request)
    {
        $workEntry = new WorkEntry();
        $form = $this->createForm(WorkEntryFormType::class, $workEntry);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($workEntry->getStartDate()<=$workEntry->getEndDate()){
                return $workEntryRepository->save($workEntry);
            }else{
                WorkEntryException::throwExceptionDate();
            }
        }

        return $form;
    }

    /**
     * @Rest\Put("/work_entry/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"work", "user"},serializerEnableMaxDepthChecks=true)
     */
    public function putAction(int $id, WorkEntryRepository $workEntryRepository, Request $request)
    {

        $workEntry = $workEntryRepository->find($id);
        if (!$workEntry) {
            WorkEntryException::throwException();
        }
        $form = $this->createForm(WorkEntryFormType::class, $workEntry, ['method' => 'PUT']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return $workEntryRepository->update($workEntry);
        }
        return $form;
    }

    /**
     * @Rest\Delete("/work_entry/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"work", "user"},serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(int $id, WorkEntryRepository $workEntryRepository)
    {
        $workEntry = $workEntryRepository->find($id);
        if (!$workEntry) {
            WorkEntryException::throwException();
        }
        return $workEntryRepository->delete($workEntry);
    }
}

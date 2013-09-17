<?php

namespace ParamountHOA\ParamountHoaApiBundle\Controller;
use ParamountHOA\ParamountHoaApiBundle\Config;
use ParamountHOA\ParamountHoaApiBundle\Enum;
use ParamountHOA\ParamountHoaApiBundle\Helper\ParameterParser;
use ParamountHOA\ParamountHoaEntityBundle\Entity\Admin;
use ParamountHOA\ParamountHoaEntityBundle\Entity\User;

/**
 * Class AdminController
 * @package ParamountHOA\ParamountHoaApiBundle\Controller
 * @author  Kenneth Howe <knnth.howe@gmail.com>
 */
class AdminController extends ApiController {

    /**
     * Create an admin
     *
     * @param $propertyId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction($propertyId)
    {
        if(! ($values = ParameterParser::parseParameters($this->getRequest(), Enum\AdminParams::get(), Config\AdminParams::get()))) {
            return $this->returnError('Required parameters missing.');
        }

        extract($values);

        $admin = new Admin();
        $admin->setUser(new User());

        $admin
            ->setIsSuperAdmin($isSuperAdmin);

        $admin->getUser()
            ->setIsActive($isActive)
            ->setEmailAddress($emailAddress)
            ->setPassword($password)
            ->setProperty($propertyId)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
        } catch (\Exception $e) {
            return $this->returnError('Unable to save administrator: ' . $e->getMessage());
        }

        return $this->returnResponse($admin->getSerialized(), 'New admin has been created.');
    }

    /**
     * Update an admin
     *
     * @param $propertyId
     * @param $adminId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction($propertyId, $adminId)
    {
        return $this->returnResponse([]);
    }

    /**
     * Get an admin
     *
     * @param $propertyId
     * @param $adminId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction($propertyId, $adminId)
    {
        return $this->returnResponse([]);
    }

    /**
     * Get all admins for a property
     *
     * @param $propertyId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllAction($propertyId)
    {
        return $this->returnResponse([]);
    }

}
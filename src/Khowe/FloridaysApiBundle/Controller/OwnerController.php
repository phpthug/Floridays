<?php

namespace Khowe\FloridaysApiBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Khowe\FloridaysEntityBundle;

/**
 * Class OwnerController
 * @package Khowe\FloridaysApiBundle\Controller
 * @author  Kenneth Howe <knnthhowe@gmail.com>
 */
class OwnerController extends Controller{

    /**
     * Get a single owner by property
     *
     * @param $propertyId
     * @param $ownerId
     *
     * @return JsonResponse
     */
    public function getAction($propertyId, $ownerId)
    {
        $owner = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Owner')->find($ownerId);
        return new JsonResponse($this->processOwner($owner));
    }

    /**
     * Retrieve a list of matching owners from the provided query data
     *
     * @param $propertyId
     *
     * @return JsonResponse
     */
    public function searchAction($propertyId)
    {
        $lastName = $this->getRequest()->query->get('lastName');
        $emailAddress = $this->getRequest()->query->get('emailAddress');
        $unitNumber = $this->getRequest()->query->get('unitNumber');

        $owners = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Owner')
            ->findBySearchCriteria($lastName, $emailAddress, $unitNumber, $propertyId);

        $data = [];

        foreach($owners as $owner) {
            $data[$owner->getId()] = $this->processOwner($owner);
        }

        return new JsonResponse($data);
    }

    /**
     * Create a new owner
     *
     * @param $propertyId
     *
     * @return JsonResponse
     */
    public function createAction($propertyId)
    {
        $requiredParams = [
            'firstName' => $this->getRequest()->request->get('firstName'),
            'lastName' => $this->getRequest()->request->get('lastName'),
            'emailAddress' => $this->getRequest()->request->get('emailAddress'),
            'password' => $this->getRequest()->request->get('password'),
            'street' => $this->getRequest()->request->get('street'),
            'suite' => $this->getRequest()->request->get('suite'),
            'city' => $this->getRequest()->request->get('city'),
            'state' => $this->getRequest()->request->get('state'),
            'zipCode' => $this->getRequest()->request->get('zipCode'),
            'country' => $this->getREquest()->request->get('country'),
            'unitNumber' => $this->getRequest()->request->get('unitNumber'),
            'unitContract' => $this->getRequest()->request->get('unitContract'),
            'phoneNumber' => $this->getRequest()->request->get('phoneNumber'),
        ];

        foreach($requiredParams as $param => $value) {
            if($value == '') {
                return new JsonResponse(['success' => false, 'message' => 'Missing required parameter ' . $param], 400);
            }
        }

        extract($requiredParams);
        
        $owner = new FloridaysEntityBundle\Entity\Owner();
        $owner->setUser(new FloridaysEntityBundle\Entity\User());
        $owner->setAddress(new FloridaysEntityBundle\Entity\Address());

        $owner->getUser()
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmailAddress($emailAddress)
            ->setProperty($propertyId)
            ->setPassword($password);

        $owner->getAddress()
            ->setStreet($street)
            ->setSuite($suite)
            ->setCity($city)
            ->setState($state)
            ->setZipCode($zipCode)
            ->setCountry($country);

        $owner->setPhoneNumber($phoneNumber);

        $unit = new FloridaysEntityBundle\Entity\Unit();

        $owner->addUnit($unit->setContractNumber($unitContract)->setUnitNumber($unitNumber)->setProperty($propertyId));

        $em = $this->getDoctrine()->getManager();
        $em->persist($owner);
        $em->flush();

        return new JsonResponse(array_merge(['success' => true], $this->processOwner($owner)));
    }

    /**
     * @param FloridaysEntityBundle\Entity\Owner $owner
     *
     * @return array
     */
    private function processOwner(FloridaysEntityBundle\Entity\Owner $owner) {
        return [
            'id' => $owner->getId(),
            'units' => $this->processOwnerUnits($owner->getUnits()),
            'address' => $this->processOwnerAddress($owner->getAddress()),
            'name' => [
                'first' => $owner->getUser()->getFirstName(),
                'last' => $owner->getUser()->getLastName(),
            ],
            'emailAddress' => $owner->getUser()->getEmailAddress()
        ];
    }

    /**
     * Process units for an owner
     *
     * @param PersistentCollection $units
     *
     * @return array
     */
    private function processOwnerUnits($units)
    {
        $data = [];

        foreach($units as $unit) {
            $data[$unit->getId()] = [
                'unitNumber' => $unit->getUnitNumber(),
                'contract' => $unit->getContractNumber()
            ];
        }

        return $data;
    }

    /**
     * @param FloridaysEntityBundle\Entity\Address $address
     *
     * @return array
     */
    private function processOwnerAddress(FloridaysEntityBundle\Entity\Address $address)
    {
        $data = [
            'street' => $address->getStreet(),
            'suite' => $address->getSuite(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'zipCode' => $address->getZipCode(),
            'country' => $address->getCountry()
        ];

        return $data;
    }

}
<?php

namespace Khowe\FloridaysApiBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use Khowe\FloridaysApiBundle\Enum\OwnerParams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Khowe\FloridaysEntityBundle;

/**
 * Class OwnerController
 * @package Khowe\FloridaysApiBundle\Controller
 * @author  Kenneth Howe <knnthhowe@gmail.com>
 */
class OwnerController extends ApiController{

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
        if(! $owner) {
            return $this->returnError('Owner with ID ' . $ownerId . ' not found for property ID ' . $propertyId);
        }
        return $this->returnResponse($this->processOwner($owner));
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

        return $this->returnResponse($data);
    }

    /**
     * Process the value submitted for an owner and return all fields as an array
     *
     * @return array|bool
     */
    private function getOwnerSubmittedValues()
    {
        $data = [];

        $ownerParams = OwnerParams::get();
        $ownerParamsConfig = \Khowe\FloridaysApiBundle\Config\OwnerParams::get();

        foreach($ownerParams as $param => $value) {
            if($ownerParamsConfig[$value]['required'] && $this->getRequest()->request->get($value, null) == null) {
                return false;
            }

            $data[$value] = $this->getRequest()->request->get($value, '');
        }

        return $data;
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

        $firstName = $lastName = $emailAddress = $password = $street = $suite = $city = $state = $zipCode = $country = $phoneNumber = '';
        $unit = [];

        if(! ($values = $this->getOwnerSubmittedValues())) {
            return $this->returnError('Required parameters missing');
        }

        extract($this->getOwnerSubmittedValues());

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

        foreach($unit as $u) {
            $unitObject = new FloridaysEntityBundle\Entity\Unit();
            if($u['contractNumber'] == '' || $u['unitNumber'] == '') {
                return $this->returnError('Unit/contract information seems to be incomplete. Please try again.');
            }
            $owner->addUnit(
                $unitObject->setContractNumber($u['contractNumber'])
                ->setUnitNumber($u['unitNumber'])
                ->setProperty($propertyId)->setOwner($owner)
            );
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($owner);
            $em->flush();
        } catch(\Exception $e) {
            return $this->returnError("Error: " . $e->getMessage());
        }

        return $this->returnResponse($this->processOwner($owner));
    }

    /**
     * Update a given owner
     *
     * @param $propertyId
     * @param $ownerId
     *
     * @return JsonResponse
     */
    public function updateAction($propertyId, $ownerId)
    {
        $firstName = $lastName = $emailAddress = $password = $street = $suite = $city = $state = $zipCode = $country = $phoneNumber = '';
        $unit = [];

        $ownerId = (int) $ownerId;

        $owner = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Owner')
            ->findById($propertyId, $ownerId);

        if(! $owner) {
            return $this->returnError('Owner with ID ' . $ownerId . ' not found for property ' . $propertyId);
        }

        if(! ($values = $this->getOwnerSubmittedValues())) {
            return $this->returnError('Required parameters missing');
        }

        extract($values);

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

        //Order n^2, but due to small amoutn of units per owner, not a huge deal
        foreach($owner->getUnits() as $ownerUnit) {
            foreach($unit as $key => $u) {
                if(isset($u['id']) && $u['id'] == $ownerUnit->getId()) {
                    //If both fields are empty, let's remove the unit from the owner
                    //If ONE is empty, we should probably throw an error
                    if ($u['contractNumber'] == '' && $u['unitNumber'] == '') {
                        $owner->removeUnit($ownerUnit);
                    } elseif ($u['contractNumber'] == '' || $u['unitNumber'] == '') {
                        return $this->returnError('The information for a unit seems to be partial or missing. Please try again.');
                    }
                    $ownerUnit->setContractNumber($u['contractNumber']);
                    $ownerUnit->setUnitNumber($u['unitNumber']);
                    unset($unit[$key]);
                }
            }
        }

        foreach($unit as $u) {
            $unitObject = new FloridaysEntityBundle\Entity\Unit();
            $unitObject
                ->setContractNumber($u['contractNumber'])
                ->setUnitNumber($u['unitNumber'])
                ->setProperty($propertyId)
                ->setOwner($owner);
            $owner->addUnit(
                $unitObject
            );
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        } catch(\Exception $e) {
            return $this->returnError("Error: " . $e->getMessage());
        }

        return $this->returnResponse($this->processOwner($owner));
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
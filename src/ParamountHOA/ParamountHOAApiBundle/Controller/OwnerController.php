<?php

namespace ParamountHOA\ParamountHoaApiBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use ParamountHOA\ParamountHoaApiBundle\Enum\OwnerParams;
use ParamountHOA\ParamountHoaApiBundle\Config;
use ParamountHOA\ParamountHoaApiBundle\Helper\ParameterParser;
use ParamountHOA\ParamountHoaEntityBundle\Entity\Address;
use ParamountHOA\ParamountHoaEntityBundle\Entity\Owner;
use ParamountHOA\ParamountHoaEntityBundle\Entity\Unit;
use ParamountHOA\ParamountHoaEntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OwnerController
 * @package ParamountHOA\ParamountHoaApiBundle\Controller
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
        $owner = $this->getDoctrine()->getRepository('ParamountHoaEntityBundle:Owner')->find($ownerId);
        if(! $owner) {
            return $this->returnError('Owner with ID ' . $ownerId . ' not found for property ID ' . $propertyId);
        }
        return $this->returnResponse($owner->getSerialized());
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

        $owners = $this->getDoctrine()->getRepository('ParamountHoaEntityBundle:Owner')
            ->findBySearchCriteria($lastName, $emailAddress, $unitNumber, $propertyId);

        $data = [];

        foreach($owners as $owner) {
            $data[$owner->getId()] = $owner->getSerialized();
        }

        return $this->returnResponse($data);
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

        if(! ($values = ParameterParser::parseParameters($this->getRequest(), OwnerParams::get(), Config\OwnerParams::get()))) {
            return $this->returnError('Required parameters missing');
        }

        extract($values);

        $owner = new Owner();
        $owner->setUser(new User());
        $owner->setAddress(new Address());

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
            $unitObject = new Unit();
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

        return $this->returnResponse($owner->getSerialized());
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

        $owner = $this->getDoctrine()->getRepository('ParamountHoaEntityBundle:Owner')
            ->findById($propertyId, $ownerId);

        if(! $owner) {
            return $this->returnError('Owner with ID ' . $ownerId . ' not found for property ' . $propertyId);
        }

        if(! ($values = ParameterParser::parseParameters($this->getRequest(), OwnerParams::get(), Config\OwnerParams::get()))) {
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
            $unitObject = new Unit();
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

        return $this->returnResponse($owner->getSerialized());
    }

}
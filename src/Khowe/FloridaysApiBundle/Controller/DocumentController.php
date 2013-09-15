<?php

namespace Khowe\FloridaysApiBundle\Controller;

use Khowe\FloridaysApiBundle\Enum;
use Khowe\FloridaysApiBundle\Config;
use Khowe\FloridaysApiBundle\Helper\ParameterParser;
use Khowe\FloridaysEntityBundle\Entity\Document;

/**
 * Class DocumentController
 * @package Khowe\FloridaysApiBundle\Controller
 * @author  Kenneth Howe <knnth.howe@gmail.com>
 */
class DocumentController extends ApiController {

    /**
     * Create a new document in the DB
     *
     * @param $propertyId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction($propertyId) {

        if(! ($values = ParameterParser::parseParameters($this->getRequest(), Enum\DocumentParams::get(), Config\DocumentParams::get()))) {
            return $this->returnError('Required parameters missing.');
        }

        extract($values);

        $document = new Document();
        $document->setPath($path);
        $document->setDescription($description);
        $document->setCreatedAt(new \DateTime());
        $document->setLastUpdated(new \DateTime());
        $document->setProperty($propertyId);

        // @todo: Validate type
        $document->setType($type);
        $document->setArchived($archived);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();
        } catch (\Exception $e) {
            return $this->returnError('There was an error saving your document: ' . $e->getMessage());
        }

        return $this->returnResponse(['id' => $document->getId()], 'Your document was successfully saved.');
    }

    public function updateAction($propertyId, $documentId) {

    }

    /**
     * Get all documents by type
     *
     * @param $propertyId
     * @param $documentType
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getByTypeAction($propertyId, $documentType) {
        $data = [];
        $repository = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Document');

        $documents = $repository->getDocumentsByType($propertyId, $documentType);

        foreach($documents as $document) {
            if (!isset($data[$document->getType()])) {
                $data[$document->getType()] = [];
            }

            $data[$document->getType()][$document->getId()] = [
                'description' => $document->getDescription(),
                'archived' => $document->getArchived(),
                'created' => $document->getCreatedAt(),
                'updated' => $document->getLastUpdated()
            ];
        }

        return $this->returnResponse($data);
    }

    /**
     * Get all documents organized by type
     *
     * @param $propertyId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllAction($propertyId) {
        $data = [];
        $repository = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Document');

        $documents = $repository->getAllDocuments($propertyId);

        foreach($documents as $document) {
            if (!isset($data[$document->getType()])) {
                $data[$document->getType()] = [];
            }

            $data[$document->getType()][$document->getId()] = [
                'description' => $document->getDescription(),
                'archived' => $document->getArchived(),
                'created' => $document->getCreatedAt(),
                'updated' => $document->getLastUpdated()
            ];
        }

        return $this->returnResponse($data);
    }

    public function getAction($propertyId, $documentId) {

    }

}
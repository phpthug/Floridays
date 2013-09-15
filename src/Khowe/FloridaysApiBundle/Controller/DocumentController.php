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

    /**
     * Update a document
     *
     * @param $propertyId
     * @param $documentId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction($propertyId, $documentId) {

        $repository = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Document');

        $document = $repository->getDocumentById($propertyId, $documentId);

        if(! $document) {
            return $this->returnError('The requested document was not found.');
        }

        if(! ($values = ParameterParser::parseParameters($this->getRequest(), Enum\DocumentParams::get(), Config\DocumentParams::get()))) {
            return $this->returnError('Required parameters missing.');
        }

        extract($values);

        $document->setPath($path);
        $document->setDescription($description);
        $document->setProperty($propertyId);
        // @todo: Validate type
        $document->setType($type);
        $document->setArchived($archived);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        } catch(\Exception $e) {
            return $this->returnError("Error: " . $e->getMessage());
        }

        return $this->returnResponse([
            'description' => $document->getDescription(),
            'archived' => $document->getArchived(),
            'created' => $document->createdAt,
            'updated' => $document->lastUpdated,
            'path' => $document->getPath(),
            'type' => $document->getType()
        ], 'Document was saved successfully.');
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
                'updated' => $document->getLastUpdated(),
                'path' => $document->getPath()
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
                'updated' => $document->getLastUpdated(),
                'path' => $document->getPath()
            ];
        }

        return $this->returnResponse($data);
    }

    /**
     * Get a document by document id
     *
     * @param $propertyId
     * @param $documentId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction($propertyId, $documentId) {

        $repository = $this->getDoctrine()->getRepository('FloridaysEntityBundle:Document');

        $document = $repository->getDocumentById($propertyId, $documentId);

        if(! $document) {
            return $this->returnError('The requested document was not found.');
        }

        return $this->returnResponse([
            'description' => $document->getDescription(),
            'archived' => $document->getArchived(),
            'created' => $document->getCreatedAt(),
            'updated' => $document->getLastUpdated(),
            'path' => $document->getPath(),
            'type' => $document->getType()
        ]);

    }

}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reviews;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ReviewNormalizerController implements NormalizerInterface
{
   
    public function normalize($object, $format = null, array $context = [])
    {
        
        return [
            'id' => $object->getId(),
            'nom' => $object->getNom(),
            'description' => $object->getDescription(),
            'date' => date_format($object->getDate(),"Y-m-d"),
            'score' => $object->getScore(),
            'utilisateur_id' => $object->getUtilisateur()->getId(),
            'hidden' => $object->getHidden(),
            'event_id' =>$object->getEvent()->getId()
        ];
    }
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Reviews;
    }
}

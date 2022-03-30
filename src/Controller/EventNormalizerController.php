<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EventNormalizerController implements NormalizerInterface
{
   
    public function normalize($object, $format = null, array $context = [])
    {
        
        return [
            'id' => $object->getId(),
            'nom' => $object->getNom(),
            'description' => $object->getDescription(),
            'image' => $object->getImage(),
            'participants' => $object->getParticipants(),
            'utilisateur_id' => $object->getUtilisateur()->getId(),
            'date' => date_format   ($object->getDate(),"Y-m-d")
        ];
    }
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Event;
    }
}

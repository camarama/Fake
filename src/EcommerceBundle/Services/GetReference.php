<?php
namespace EcommerceBundle\Services;


use Doctrine\ORM\EntityManager;
use EcommerceBundle\Entity\Commandes;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetReference
{
    private $em;
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function reference()
    {
        $reference = $this->em->getRepository(Commandes::class)->findOneBy(array('valider' => 1), array('id' => 'DESC'), 1, 1);

        if (!$reference)
            return 1;
        else
            return $reference->getReference() +1;
    }
}
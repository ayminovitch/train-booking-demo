<?php

namespace App\EventListener\ReferenceCode;

use App\Entity\ReferenceCodeInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;
use function random_int;

class ReferenceCodeListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof ReferenceCodeInterface) {
            if ($entity->getReferenceCode()) {
                return;
            }

            try {
                $referenceCode = $this->generateCode($args);
                $entity->setReferenceCode($referenceCode);
                $em = $args->getObjectManager();
                $em->persist($entity);
                $em->flush();
            } catch (\Exception $e) {
                $this->logger->error(
                    'Unable to generate reference number: ' .
                        $e->getMessage()
                );
            }
        }
    }

    private function generateCode(LifecycleEventArgs $args): string
    {
        $entity = $args->getObject();
        $suffixVars = explode('\\', get_class($entity));
        $suffix = end($suffixVars)[0];
        $randomNumber = random_int(1000000000, 9999999999);
        $referenceCode = sprintf('%s-%s', $suffix, $randomNumber);
        $repository = $args->getObjectManager()->getRepository(get_class($args->getObject()));

        if ($repository->findOneBy(['referenceCode' => $referenceCode])) {
            return $this->generateCode($args);
        }

        return $referenceCode;
    }
}

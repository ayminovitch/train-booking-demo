<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ReferenceCodeTrait
{
    #[ORM\Column(type: 'string')]
    private ?string $referenceCode = '';

    public function getReferenceCode(): ?string
    {
        return $this->referenceCode;
    }

    public function setReferenceCode(?string $referenceCode): self
    {
        $this->referenceCode = $referenceCode;

        return $this;
    }
}

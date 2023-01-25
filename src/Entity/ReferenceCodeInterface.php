<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Mon Jan 16 2023
 */

namespace App\Entity;

interface ReferenceCodeInterface
{
    public function getReferenceCode(): ?string;

    public function setReferenceCode(string $referenceNo);
}

<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class BandDTO
{
   public function __construct(
      #[Assert\NotBlank]
      public readonly string $name,

      public readonly string $description,

      public readonly string $coverImage,

      public readonly string $embedLink
   ){}
}
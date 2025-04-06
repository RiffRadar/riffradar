<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BandDTO
{
   public function __construct(
      #[Assert\NotBlank]
      public string $name,

      public string $description,

      public string $coverImage,

      public string $embedLink
   ){}
}
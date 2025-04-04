<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

class BarDTO
{
   public function __construct(
      #[Assert\NotBlank]
      public readonly string $name,

      #[Assert\NotBlank]
      public readonly string $description,

      #[Assert\NotBlank]
      public readonly string $address,

      #[Assert\NotBlank]
      public readonly string $postalCode,

      #[Assert\NotBlank]
      public readonly string $city,

      public readonly string $telephone,

      public readonly string $coverImage
   ){}
}
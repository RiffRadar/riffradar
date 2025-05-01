<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BarDTO
{
   public function __construct(
      #[Assert\NotBlank]
      public string $name,

      #[Assert\NotBlank]
      public string $description,

      #[Assert\NotBlank]
      public string $address,

      #[Assert\NotBlank]
      public string $postalCode,

      #[Assert\NotBlank]
      public string $city,

      public string $telephone,

      public string $coverImage
   ){}
}

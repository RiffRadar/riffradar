<?php

namespace App\DTO\Bar;

readonly class NewBarDTO
{
   public function __construct(
      public string $name,
      public string $description,
      public string $address,
      public string $postalCode,
      public string $city,
   ) {}
}

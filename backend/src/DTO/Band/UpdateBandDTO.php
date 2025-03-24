<?php

namespace App\DTO\Band;

readonly class UpdateBandDTO
{
   public function __construct(
      public string $name,
      public string $description,
   ) {}
}

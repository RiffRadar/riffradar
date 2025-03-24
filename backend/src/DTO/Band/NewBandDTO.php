<?php

namespace App\DTO\Band;

readonly class NewBandDTO
{
   public function __construct(
      public string $name,
      public string $description,
   ) {}
}

<?php

namespace App\DTO\Bar;

use Symfony\Component\Validator\Constraints as Assert;

readonly class DeleteBarDTO
{
   #[Assert\NotBlank(message: "L'id du bar est requis.")]
   #[Assert\Type(type: 'integer', message: "L'id du bar doit être un nombre entier.")]
   public int $id;

   public function __construct(int $id)
   {
      $this->id = $id;
   }
}

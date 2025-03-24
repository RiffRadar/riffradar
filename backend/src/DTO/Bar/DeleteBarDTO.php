<?php

namespace App\DTO\Bar;

use Symfony\Component\Validator\Constraints as Assert;

readonly class DeleteBarDTO
{
   #[Assert\NotBlank(message: "Bar is is required")]
   #[Assert\Type(type: 'integer', message: "Bar id must be an integer")]
   public int $id;

   public function __construct(int $id)
   {
      $this->id = $id;
   }
}

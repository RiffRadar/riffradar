<?php

namespace App\DTO\Band;

use Symfony\Component\Validator\Constraints as Assert;

readonly class DeleteBandDTO
{
   #[Assert\NotBlank(message: "Band is is required")]
   #[Assert\Type(type: 'integer', message: "Band id must be an integer")]
   public int $id;

   public function __construct(int $id)
   {
      $this->id = $id;
   }
}

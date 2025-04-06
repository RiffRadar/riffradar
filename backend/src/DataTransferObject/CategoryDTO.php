<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,

        public ?int   $category,
    )
    {
    }
}
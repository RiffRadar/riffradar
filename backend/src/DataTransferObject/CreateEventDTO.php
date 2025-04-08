<?php

namespace App\DataTransferObject;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateEventDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int               $barId,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public int               $bandId,

        #[Assert\NotBlank]
        public DateTimeInterface $dateTime
    )
    {
    }
}

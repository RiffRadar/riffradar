<?php

namespace App\Enum;

enum StatusEnum: string 
{
   case pending = 'pending';
   case declined = 'declined';
   case accepted = 'accepted';
}

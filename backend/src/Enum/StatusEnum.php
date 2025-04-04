<?php

namespace App\Enum;

enum StatusEnum: string 
{
   case pending = 'pending';
   case refused = 'refused';
   case validated = 'validated';
}

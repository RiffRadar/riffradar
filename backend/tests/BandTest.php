<?php

namespace App\Tests\Entity;

use App\Entity\Band;
use PHPUnit\Framework\TestCase;


class BandTest extends TestCase
{
   public function testCreation(): void
   {
      $band = new Band();
      $this->assertInstanceOf(Band::class, $band);
   }

   public function testName(): void
   {
      $band = new Band();
      $band->setName('testname');
      $this->assertEquals('testname', $band->getName());
   }

   public function testDescription(): void
   {
      $band = new Band();
      $band->setDescription('test description');
      $this->assertEquals('test description', $band->getDescription());
   }
}

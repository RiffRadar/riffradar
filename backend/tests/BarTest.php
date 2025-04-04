<?php

namespace App\Tests\Entity;

use App\Entity\Bar;
use PHPUnit\Framework\TestCase;


class BarTest extends TestCase
{
   public function testCreation(): void
   {
      $bar = new Bar();
      $this->assertInstanceOf(Bar::class, $bar);
   }

   public function testName(): void
   {
      $bar = new Bar();
      $bar->setName('testname');
      $this->assertEquals('testname', $bar->getName());
   }

   public function testDescription(): void
   {
      $bar = new Bar();
      $bar->setDescription('test description');
      $this->assertEquals('test description', $bar->getDescription());
   }

   public function testAddress(): void
   {
      $bar = new Bar();
      $bar->setAddress('address test');
      $this->assertEquals('address test', $bar->getAddress());
   }

   public function testPostalCode(): void
   {
      $bar = new Bar();
      $bar->setPostalCode('11111');
      $this->assertEquals('11111', $bar->getPostalCode());
   }

   public function testCity(): void
   {
      $bar = new Bar();
      $bar->setCity('testCity');
      $this->assertEquals('testCity', $bar->getCity());
   }

   public function testTelephone(): void
   {
      $bar = new Bar();
      $bar->setTelephone('0123456789');
      $this->assertEquals('0123456789', $bar->getTelephone());
   }
}

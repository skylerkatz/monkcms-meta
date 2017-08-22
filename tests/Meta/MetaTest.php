<?php

namespace Tests\Meta;

use Meta\Meta;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    /** @test */
    public function metaTagsCanBeCreated()
    {
        $meta = new Meta();

        $exptectedMetaTag = '<meta name="Test Name" content="Test Content" >'.PHP_EOL;
        $this->assertEquals($exptectedMetaTag, $meta->createMetaTag('Test Name', 'Test Content'));
    }

    /** @test */
    public function metaTagsCanBeCreatedWithPropertiesInsteadOfName()
    {
        $meta = new Meta();

        $exptectedMetaTag = '<meta property="Test Property" content="Test Content" >'.PHP_EOL;
        $this->assertEquals($exptectedMetaTag, $meta->createMetaTag('Test Property', 'Test Content', 'property'));
    }
}

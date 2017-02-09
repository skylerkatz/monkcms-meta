<?php
namespace Tests\Meta;

use PHPUnit\Framework\TestCase;
use \Meta\Module\SermonMeta;

class SermonMetaTest extends TestCase
{
    /** @test */
    public function aProperlyFormattedTitleIsReturned()
    {
        $meta = new SermonMeta('test-sermon-slug', 'Test Site Name', 'http://example.com');

        $this->assertEquals('Example Sermon Title | Test Site Name', $meta->title());
    }

    /** @test */
    public function aProperlyFormattedDescriptionIsReturned()
    {
        $meta = new SermonMeta('test-sermon-slug', 'Test Site Name', 'http://example.com');

        $this->assertEquals('Example Sermon Description', $meta->description());
    }

    /** @test */
    public function properlyFormattedKeywordsAreReturned()
    {
        $meta = new SermonMeta('test-sermon-slug', 'Test Site Name', 'http://example.com');

        $this->assertEquals('Example Sermon Keywords', $meta->keywords());
    }

    /** @test */
    public function properlyFormattedSocialTagsAreReturned()
    {
        $meta = new SermonMeta('test-sermon-slug', 'Test Site Name', 'http://example.com');

        $expectedResponse = implode([
            '<meta property="og:site_name" content="Test Site Name" >' . PHP_EOL,
            '<meta property="og:type" content="article" >' . PHP_EOL,
            '<meta property="og:title" content="Example Sermon Title | Test Site Name" >' . PHP_EOL,
            '<meta property="og:url" content="http://example.com" >' . PHP_EOL,
            '<meta property="og:image" content="http://www.placecage.com/1200/630" >' . PHP_EOL,
            '<meta property="og:image:width" content="1200" >' . PHP_EOL,
            '<meta property="og:image:height" content="630" >' . PHP_EOL,
            '<meta name="twitter:card" content="summary_large_image" >' . PHP_EOL
        ]);

        $this->assertEquals($expectedResponse, $meta->socialTags());
    }
}

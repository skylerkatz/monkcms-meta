<?php

namespace Tests\Meta;

use Meta\Module\BlogMeta;
use PHPUnit\Framework\TestCase;

class BlogMetaTest extends TestCase
{
    /** @test */
    public function aProperlyFormattedTitleIsReturnedForABlog()
    {
        // MonkCMS dynamically gets the name of the blog based on the blog slug
        $meta = new BlogMeta('Test Site Name', 'http://example.com/example-blog');

        $this->assertEquals('Example Blog | Test Site Name', $meta->title());
    }

    /** @test */
    public function aProperlyFormattedTitleIsReturnedForABlogPost()
    {
        // MonkCMS dynamically gets the name of the blog based on the blog slug
        // Passing through a fake api type for testing only
        $meta = new BlogMeta('Test Site Name', 'http://example.com/example-blog/a-blog-post-title', 'blogpost');

        $this->assertEquals('A Blog Post Title | Example Blog | Test Site Name', $meta->title());
    }

    /** @test */
    public function aProperlyFormattedDescriptionIsReturned()
    {
        $meta = new BlogMeta('test-event-slug', 'Test Site Name', 'http://example.com');

        $this->assertEquals('Example Event Description', $meta->description());
    }

    /** @test */
    public function properlyFormattedKeywordsAreReturned()
    {
        $meta = new BlogMeta('test-event-slug', 'Test Site Name', 'http://example.com');

        $this->assertEquals('Example Event Keywords', $meta->keywords());
    }

    /** @test */
    public function properlyFormattedSocialTagsAreReturned()
    {
        $meta = new BlogMeta('test-event-slug', 'Test Site Name', 'http://example.com');

        $expectedResponse = implode([
            '<meta property="og:site_name" content="Test Site Name" >'.PHP_EOL,
            '<meta property="og:type" content="article" >'.PHP_EOL,
            '<meta property="og:title" content="Example Event Title | Test Site Name" >'.PHP_EOL,
            '<meta property="og:url" content="http://example.com" >'.PHP_EOL,
            '<meta property="og:image" content="http://www.placecage.com/1200/630" >'.PHP_EOL,
            '<meta property="og:image:width" content="1200" >'.PHP_EOL,
            '<meta property="og:image:height" content="630" >'.PHP_EOL,
            '<meta name="twitter:card" content="summary_large_image" >'.PHP_EOL,
        ]);

        $this->assertEquals($expectedResponse, $meta->socialTags());
    }
}

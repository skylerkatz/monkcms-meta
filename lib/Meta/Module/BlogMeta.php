<?php

/**
 * Global Meta namespace.
 */

namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

/**
 * A class to generate HTML Meta information for the MonkCMS Blogs Module.
 *
 * @author Monk Development, Inc.
 */
class BlogMeta extends Meta implements MetaInterface
{
    /**
     * Blog/Blog Post Content.
     *
     * @var array
     */
    protected $blog;

    /**
     * Blog Header Image.
     *
     * @var array
     */
    protected $blogImage;

    /**
     * Website Name.
     *
     * @var string
     */
    protected $siteName;

    /**
     * Url of the Blog/Blog Post.
     *
     * @var string
     */
    protected $blogUrl;

    /**
     * Get the requested blog content and associated header image.
     *
     * @param string $siteName The name of the website
     * @param string $blogUrl  The current URL of the blog/blog post
     * @param string $apiType  Used during testing to simulate a blog post.
     */
    public function __construct($siteName, $blogUrl, $apiType = 'blog')
    {
        $this->blog = getContent(
            $apiType,
            'display:auto',
            "show:__imageurl width='1200' height='630'__",
            'json'
        );

        // The main blog image, not the blog post image
        $this->blogImage = getContent(
            'media',
            'display:detail',
            'label:header',
            "show:__imageurl width='1200' height='630'__",
            'json'
        );
        $this->siteName = $siteName;
        $this->blogUrl = $blogUrl;
    }

    /**
     * Title for the given module.
     *
     * @return string Title tag
     */
    public function title()
    {
        if (isset($this->blog['before_show_postlist'])) {
            return $this->sanitize(
                $this->blog['before_show_postlist']['blogtitle'].' | '.$this->siteName
            );
        }

        if (isset($this->blog['show_detail'])) {
            return $this->sanitize(
                $this->blog['show_detail']['blogposttitle'].' | '.$this->blog['show_detail']['blogtitle'].' | '.$this->siteName
            );
        }
    }

    /**
     * Description for the given module.
     *
     * @return string Description tag
     */
    public function description()
    {
        throw new \Exception('Method not implemented');
    }

    /**
     * Keywords for the given module.
     *
     * @return string Keywords tag
     */
    public function keywords()
    {
        throw new \Exception('Method not implemented');
    }

    /**
     * Social Media Meta tags for the given module.
     *
     * @return string Social Media Meta tags
     */
    public function socialTags()
    {
        throw new \Exception('Method not implemented');
    }
}

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
     * @param string $churchCallsBlog  Optional parameter for what to call a blog
     * @param string $apiType  Used during testing to simulate a blog post.
     */
    public function __construct($siteName, $blogUrl, $churchCallsBlog = 'blog', $apiType = 'blog')
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
        )['show']['imageurl'];
        $this->siteName = $siteName;
        $this->blogUrl = $blogUrl;
        $this->churchCallsBlog = $churchCallsBlog;
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
        if (isset($this->blog['before_show_postlist'])) {
            if (array_key_exists('blogdescription', $this->blog['before_show_postlist'])) {
                return $this->sanitize(
                    $this->blog['before_show_postlist']['blogdescription']
                );
            } else {
                return $this->sanitize("A {$this->churchCallsBlog} for {$this->siteName}");
            }
        }

        if (isset($this->blog['show_detail'])) {
            return $this->sanitize(
                $this->blog['show_detail']['preview']
            );
        }
    }

    /**
     * Keywords for the given module.
     *
     * @return string Keywords tag
     */
    public function keywords()
    {
        if (isset($this->blog['show_detail']['tags'])) {
            return $this->sanitize($this->blog['show_detail']['tags']);
        }

        return '';
    }

    /**
     * Social Media Meta tags for the given module.
     *
     * @return string Social Media Meta tags
     */
    public function socialTags()
    {
        $meta = [
            'name'        => $this->siteName,
            'type'        => 'article',
            'title'       => $this->title(),
            'url'         => $this->blogUrl,
            'description' => $this->description(),
        ];

        if ($this->imageExists()) {
            $meta['image'] = $this->getProperImage();
        }

        return $this->generateSocialTags($meta);
    }

    protected function imageExists()
    {
        if (isset($this->blog['show_detail']) && $this->blog['show_detail']['imageurl'] != '') {
            return true;
        }

        if (!is_null($this->blogImage)) {
            return true;
        }

        return false;
    }

    protected function getProperImage()
    {
        if (isset($this->blog['show_detail'])) {
            return $this->blog['show_detail']['imageurl'];
        }

        return $this->blogImage;
    }
}

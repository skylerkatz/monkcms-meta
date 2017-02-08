<?php

/**
 * Global Meta namespace.
 */
namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

/**
 * A class to generate HTML Meta information for the MonkCMS Pages Module
 *
 * @author Monk Development, Inc.
 */
class PageMeta extends Meta implements MetaInterface
{
    /**
     * Page Content
     * @var array
     */
    protected $page;

    /**
     * Page Header Image
     * @var array
     */
    protected $headerImage;

    /**
     * Get the requested page content and associated header image
     * @param string $pageId Page to get from MonkCMS
     * @param string $siteName The name of the website
     * @param string $pageUrl The current URL of the page
     */
    public function __construct($pageId, $siteName, $pageUrl)
    {
        $this->page = getContent("page", "display:detail", "find:{$pageId}", "json");
        $this->headerImage = getContent(
            "media",
            "display:detail",
            "find:{$pageId}",
            "label:header",
            "show:__imageurl width='1200' height='630'__",
            "json"
        );
        $this->siteName = $siteName;
        $this->pageUrl = $pageUrl;
    }

    /**
     * Get the title and add the site name
     * @return string Title tag
     */
    public function title()
    {
        if ($this->page['show']['title'] == 'INDEX') {
            return $this->siteName;
        }

        return $this->sanitize($this->page['show']['title'] . " | ". $this->siteName);
    }

    /**
     * Get the description of the page
     * If no description use the site name
     * @return string Page description
     */
    public function description()
    {
        if ($this->page['show']['description'] == '') {
            return $this->siteName;
        }

        return $this->sanitize($this->page['show']['description']);
    }

    /**
     * Get the keywords for the page
     * @return string Page keywords
     */
    public function keywords()
    {
        return $this->sanitize($this->page['show']['tags']);
    }

    /**
     * Get the Social Media Tags for the page.
     * @return string Meta tags for social media sharing
     */
    public function socialTags()
    {
        $meta = [
            'name' => $this->siteName,
            'type' => 'article',
            'title' => $this->title(),
            'url' => $this->pageUrl,
            'description' => $this->description(),
        ];
        if (isset($this->headerImage['show']['imageurl'])) {
            $meta['image'] = $this->headerImage['show']['imageurl'];
        }

        return $this->generateSocialTags($meta);
    }
}

<?php

namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

class PageMeta extends Meta implements MetaInterface
{

    protected $page;
    protected $headerImage;

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

    public function title()
    {
        if ($this->page['show']['title'] == 'INDEX') {
            return $this->siteName;
        }

        return $this->sanitize($this->page['show']['title'] . " | ". $this->siteName);
    }

    public function description()
    {
        if ($this->page['show']['description'] == '') {
            return $this->siteName;
        }

        return $this->sanitize($this->page['show']['description']);
    }

    public function keywords()
    {
        return $this->sanitize($this->page['show']['tags']);
    }

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

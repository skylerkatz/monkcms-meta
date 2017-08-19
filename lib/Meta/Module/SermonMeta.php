<?php

/**
 * Global Meta namespace.
 */
namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

/**
 * A class to generate HTML Meta information for the MonkCMS Sermons Module
 *
 * @author Monk Development, Inc.
 */
class SermonMeta extends Meta implements MetaInterface
{
    /**
     * Sermon Content
     * @var array
     */
    protected $sermon;

    /**
     * Website Name
     * @var string
     */
    protected $siteName;

    /**
     * Url of the Sermon
     * @var string
     */
    protected $eventUrl;

    /**
     * What to call Sermons (messages, homilies, sermons, speeches)
     * @var string
     */
    protected $churchCallsSermons;

    /**
     * Url of the sermon image for use in social media sharing
     * @var string
     */
    protected $sermonImage;

    /**
     * Get the sermon and associated data from the MonkCMS Api
     * @param string $sermonType         Either Auto for display:auto or the slug of the sermon to find
     * @param string $siteName           The name of the website
     * @param string $sermonUrl          The current URL of the sermon
     * @param string $churchCallsSermons Optional parameter for what to call sermons
     */
    public function __construct($sermonType, $siteName, $sermonUrl, $churchCallsSermons = 'Sermons')
    {
        $this->sermon = $this->getSermon($sermonType);

        $this->siteName = $siteName;
        $this->sermonUrl = $sermonUrl;
        $this->churchCallsSermons = $churchCallsSermons;
        $this->sermonImage = $this->determineSermonImage();
    }

    /**
     * Get the title and add the site name
     * @return string Title tag
     */
    public function title()
    {
        if (!isset($this->sermon['show']['title'])) {
            return $this->churchCallsSermons . " | " . $this->siteName;
        }

        return $this->sanitize($this->sermon['show']['title'] . " | " . $this->siteName);
    }

    /**
     * Get the description of the sermon
     * If no description use the site name
     * @return string Sermon description
     */
    public function description()
    {
        if (!isset($this->sermon['show']['summary']) || $this->sermon['show']['summary'] == '') {
            return $this->churchCallsSermons . ' by ' . $this->siteName;
        }

        return $this->sanitize($this->sermon['show']['summary']);
    }

    /**
     * Get the keywords for the sermon
     * @return string Sermon keywords
     */
    public function keywords()
    {
        if (isset($this->sermon['show']['tags'])) {
            return $this->sanitize($this->sermon['show']['tags']);
        }

        return '';
    }

    /**
     * Get the Social Media Tags for the sermon.
     * @return string Meta tags for social media sharing
     */
    public function socialTags()
    {
        $meta = [
            'name' => $this->siteName,
            'type' => 'article',
            'title' => $this->title(),
            'url' => $this->sermonUrl,
            'description' => $this->description(),
        ];

        if (! is_null($this->sermonImage)) {
            $meta['image'] = $this->sermonImage;
        }

        return $this->generateSocialTags($meta);
    }

    /**
     * Determine if there is a sermon image
     * Preference for the Sermon Image
     * Fallback to the Series image
     * @return string|null
     */
    private function determineSermonImage()
    {
        if (isset($this->sermon['show']['imageurl']) && $this->sermon['show']['imageurl'] != '') {
            return $this->sermon['show']['imageurl'];
        }

        if (isset($this->sermon['show']['seriesimage']) && $this->sermon['show']['seriesimage'] != '') {
            return $this->sermon['show']['seriesimage'];
        }

        return null;
    }

    /**
     * Get the sermon based on the type of template
     * @param  string $sermonType Either auto for display:auto or the slug of the sermon to find
     * @return array Sermon Content from the MonkCMS Api
     */
    private function getSermon($sermonType)
    {
        if ($sermonType === 'auto') {
            return getContent(
                "sermon",
                "display:auto",
                "show_detail",
                "show_detail:__imageurl  width='1200' height='630'__",
                "show_detail:__seriesimage  width='1200' height='630'__",
                "json"
            );
        }

        return getContent(
            "sermon",
            "display:detail",
            "find:{$sermonType}",
            "show:__imageurl  width='1200' height='630'__",
            "show:__seriesimage  width='1200' height='630'__",
            "json"
        );
    }
}

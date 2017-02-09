<?php

/**
 * Global Meta namespace.
 */
namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

/**
 * A class to generate HTML Meta information for the MonkCMS Events Module
 *
 * @author Monk Development, Inc.
 */
class EventMeta extends Meta implements MetaInterface
{
    /**
     * Event Content
     * @var array
     */
    protected $event;

    /**
     * Website Name
     * @var string
     */
    protected $siteName;

    /**
     * Url of the Event
     * @var string
     */
    protected $eventUrl;

    /**
     * Get the requested event content and associated header image
     * @param string $eventId Event to get from MonkCMS
     * @param string $siteName The name of the website
     * @param string $eventUrl The current URL of the event
     */
    public function __construct($eventId, $siteName, $eventUrl)
    {
        $this->event = getContent(
            "event",
            "display:detail",
            "find:{$eventId}",
            "show:__imageurl width='1200' height='630'__",
            "json"
        );
        $this->siteName = $siteName;
        $this->eventUrl = $eventUrl;
    }

    /**
     * Get the title and add the site name
     * @return string Title tag
     */
    public function title()
    {
        if ($this->event['show']['title'] == 'INDEX') {
            return $this->siteName;
        }

        return $this->sanitize($this->event['show']['title'] . " | ". $this->siteName);
    }

    /**
     * Get the description of the event
     * If no description use the site name
     * @return string Event description
     */
    public function description()
    {
        if ($this->event['show']['description'] == '') {
            return $this->siteName;
        }

        return $this->sanitize($this->event['show']['description']);
    }

    /**
     * Get the keywords for the event
     * @return string Event keywords
     */
    public function keywords()
    {
        return $this->sanitize($this->event['show']['category']);
    }

    /**
     * Get the Social Media Tags for the event.
     * @return string Meta tags for social media sharing
     */
    public function socialTags()
    {
        $meta = [
            'name' => $this->siteName,
            'type' => 'article',
            'title' => $this->title(),
            'url' => $this->eventUrl,
            'description' => $this->description(),
        ];
        if ($this->event['show']['imageurl'] != '') {
            $meta['image'] = $this->event['show']['imageurl'];
        }

        return $this->generateSocialTags($meta);
    }
}

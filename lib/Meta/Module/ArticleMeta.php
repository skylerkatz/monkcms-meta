<?php

/**
 * Global Meta namespace.
 */

namespace Meta\Module;

use Meta\Meta;
use Meta\MetaInterface;

/**
 * A class to generate HTML Meta information for the MonkCMS Articles Module.
 *
 * @author Monk Development, Inc.
 */
class ArticleMeta extends Meta implements MetaInterface
{
    /**
     * Article Content.
     *
     * @var array
     */
    protected $article;

    /**
     * Website Name.
     *
     * @var string
     */
    protected $siteName;

    /**
     * Url of the Article.
     *
     * @var string
     */
    protected $eventUrl;

    /**
     * What to call Articles (stories, blogs, newsletters, speeches).
     *
     * @var string
     */
    protected $churchCallsArticles;

    /**
     * Url of the article image for use in social media sharing.
     *
     * @var string
     */
    protected $articleImage;

    /**
     * Get the article and associated data from the MonkCMS Api.
     *
     * @param string $articleType         Either auto for display:auto or the slug of the article to find
     * @param string $siteName            The name of the website
     * @param string $articleUrl          The current URL of the article
     * @param string $churchCallsArticles Optional parameter for what to call articles
     */
    public function __construct($articleType, $siteName, $articleUrl, $churchCallsArticles = 'Articles')
    {
        $this->article = $this->getArticle($articleType);

        $this->siteName = $siteName;
        $this->articleUrl = $articleUrl;
        $this->churchCallsArticles = $churchCallsArticles;
        $this->articleImage = $this->determineArticleImage();
    }

    /**
     * Get the title and add the site name.
     *
     * @return string Title tag
     */
    public function title()
    {
        if (!isset($this->article['show']['title'])) {
            return $this->churchCallsArticles.' | '.$this->siteName;
        }

        return $this->sanitize(
            $this->article['show']['title'].' | '.$this->churchCallsArticles.' | '.$this->siteName
        );
    }

    /**
     * Get the description of the article
     * If no description use the site name.
     *
     * @return string Article description
     */
    public function description()
    {
        if (!isset($this->article['show']['summary']) || $this->article['show']['summary'] == '') {
            return $this->churchCallsArticles.' by '.$this->siteName;
        }

        return $this->sanitize($this->article['show']['summary']);
    }

    /**
     * Get the keywords for the article.
     *
     * @return string Article keywords
     */
    public function keywords()
    {
        if (isset($this->article['show']['tags'])) {
            return $this->sanitize($this->article['show']['tags']);
        }

        return '';
    }

    /**
     * Get the Social Media Tags for the article.
     *
     * @return string Meta tags for social media sharing
     */
    public function socialTags()
    {
        $meta = [
            'name'        => $this->siteName,
            'type'        => 'article',
            'title'       => $this->title(),
            'url'         => $this->articleUrl,
            'description' => $this->description(),
        ];

        if (!is_null($this->articleImage)) {
            $meta['image'] = $this->articleImage;
        }

        return $this->generateSocialTags($meta);
    }

    /**
     * Determine if there is a article image
     * Preference for the Article Image
     * Fallback to the Series image.
     *
     * @return string|null
     */
    private function determineArticleImage()
    {
        if (isset($this->article['show']['imageurl']) && $this->article['show']['imageurl'] != '') {
            return $this->article['show']['imageurl'];
        }

        if (isset($this->article['show']['seriesimage']) && $this->article['show']['seriesimage'] != '') {
            return $this->article['show']['seriesimage'];
        }
    }

    /**
     * Get the article based on the type of template.
     *
     * @param string $articleType Either auto for display:auto or the slug of the article to find
     *
     * @return array Article Content from the MonkCMS Api
     */
    private function getArticle($articleType)
    {
        if ($articleType === 'auto') {
            return getContent(
                'article',
                'display:auto',
                'show_detail',
                "show_detail:__imageurl  width='1200' height='630'__",
                "show_detail:__seriesimage  width='1200' height='630'__",
                'json'
            );
        }

        return getContent(
            'article',
            'display:detail',
            "find:{$articleType}",
            "show:__imageurl  width='1200' height='630'__",
            "show:__seriesimage  width='1200' height='630'__",
            'json'
        );
    }
}

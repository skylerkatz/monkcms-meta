<?php

/**
 * Global Meta namespace.
 */

namespace Meta;

/**
 * A class to generate HTML Meta information for the MonkCMS API.
 *
 * @author Monk Development, Inc.
 */
class Meta
{
    /**
     * Ensure content is escaped for use in meta tags.
     *
     * @param string $content String to be sanitized
     *
     * @return string Sanitized Content
     */
    protected function sanitize($content)
    {
        return trim(htmlspecialchars(strip_tags($content)));
    }

    /**
     * Generate meta tags for social media.
     *
     * @param array $meta an array of meta information
     *
     * @return string HTML String of meta tags
     */
    protected function generateSocialTags(array $meta)
    {
        $tags = $this->generateOpenGraphTags($meta);
        $tags[] = $this->generateTwitterTag($meta);
        $tags[] = $this->generateAuthorTag($meta);

        return implode(array_filter($tags));
    }

    /**
     * Create an HTML Meta tag.
     *
     * @param string $name Name of the meta tag
     * @param string $content Content of the meta tag
     * @param string $type The type of meta tag to generate
     *
     * @return string Fully formed meta tag
     */
    public function createMetaTag($name, $content, $type = 'name')
    {
        if ($content == '') {
            return PHP_EOL;
        }

        return '<meta '.$type.'="'.$name.'" content="'.$content.'" >'.PHP_EOL;
    }

    /**
     * Generate a meta tag for the Author atrribute.
     *
     * @param array $meta Meta information for the givien module
     *
     * @return string | empty Meta tag for author property
     */
    private function generateAuthorTag($meta)
    {
        if (isset($meta['author'])) {
            return $this->createMetaTag('article:author', $meta['author'], 'property');
        }
    }

    /**
     * Generate twitter specific meta tags.
     *
     * @param array $meta Meta inforamtion for the given module
     *
     * @return string Meta tag
     */
    private function generateTwitterTag($meta)
    {
        if (isset($meta['image'])) {
            return $this->createMetaTag('twitter:card', 'summary_large_image');
        }

        return $this->createMetaTag('twitter:card', 'summary');
    }

    /**
     * Generate Open Graph specific meta tags.
     *
     * @param array $meta Meta information for the given module
     *
     * @return array Open Graph meta tags
     */
    private function generateOpenGraphTags($meta)
    {
        $tags = [
            $this->createMetaTag('og:site_name', $meta['name'], 'property'),
            $this->createMetaTag('og:type', $meta['type'], 'property'),
            $this->createMetaTag('og:title', $meta['title'], 'property'),
            $this->createMetaTag('og:url', $meta['url'], 'property'),
        ];
        if (isset($meta['image'])) {
            $tags[] = $this->createMetaTag('og:image', $meta['image'], 'property');
            $tags[] = $this->createMetaTag('og:image:width', '1200', 'property');
            $tags[] = $this->createMetaTag('og:image:height', '630', 'property');
        }

        return $tags;
    }
}

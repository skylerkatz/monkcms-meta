<?php

namespace Meta;

class Meta
{

    protected function sanitize($content)
    {
        return trim(htmlspecialchars($content));
    }

    protected function generateSocialTags(array $meta)
    {
        $tags = $this->generateOpenGraphTags($meta);
        $tags[] = $this->generateTwitterTag($meta);
        $tags[] = $this->generateAuthorTag($meta);
        return implode(array_filter($tags));
    }

    public function createMetaTag($name, $content, $type = 'name')
    {
        if ($content == '') {
            return PHP_EOL;
        }
        return '<meta '. $type .'="'. $name . '" content="'. $content .'" >'. PHP_EOL;
    }

    private function generateAuthorTag($meta)
    {
        if (isset($meta['author'])) {
            return $this->createMetaTag('article:author', $meta['author'], 'property');
        }
    }

    private function generateTwitterTag($meta)
    {
        if (isset($meta['image'])) {
            return $this->createMetaTag('twitter:card', 'summary_large_image');
        }
        return $this->createMetaTag('twitter:card', 'summary');
    }

    private function generateOpenGraphTags($meta)
    {
        $tags = [
            $this->createMetaTag('og:site_name', $meta['name'], 'property'),
            $this->createMetaTag('og:type', $meta['type'], 'property'),
            $this->createMetaTag('og:title', $meta['title'], 'property'),
            $this->createMetaTag('og:url', $meta['url'], 'property')
        ];
        if (isset($meta['image'])) {
            $tags[] = $this->createMetaTag('og:image', $meta['image'], 'property');
            $tags[] = $this->createMetaTag('og:image:width', '1200', 'property');
            $tags[] = $this->createMetaTag('og:image:height', '630', 'property');
        }
        return $tags;
    }
}

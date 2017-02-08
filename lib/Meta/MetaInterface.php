<?php

/**
 * Global Meta namespace.
 */
namespace Meta;

/**
 * Functions that each module must implement
 */
interface MetaInterface
{
    /**
     * Title for the given module
     * @return string Title tag
     */
    public function title();

    /**
     * Description for the given module
     * @return string Description tag
     */
    public function description();

    /**
     * Keywords for the given module
     * @return string Keywords tag
     */
    public function keywords();

    /**
     * Social Media Meta tags for the given module
     * @return string Social Media Meta tags
     */
    public function socialTags();
}

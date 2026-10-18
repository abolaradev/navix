<?php

namespace Abolaradev\Navix\Collections;

use Illuminate\Support\Collection;

class NavixCollection extends Collection
{
    /**
     * Get the label of the navigation item.
     * 
     * @return string
     */
    public function getLabel(): string
    {
        return $this->get('label', '');
    }

    /**
     * Get the icon of the navigation item.
     * 
     * @return string
     */
    public function getIcon(): string
    {
        return $this->get('icon', '');
    }

    /**
     * Get the badge of the navigation item.
     * 
     * @return string
     */
    public function getBadge(): string
    {
        return $this->get('badge', '');
    }

    /**
     * Get the URL of the navigation item.
     * 
     * @return string
     */
    public function getUrl(): string
    {
        return $this->get('url', '');
    }

    /**
     * Get the nested navigation items.
     * 
     * @return NavixCollection
     */
    public function getSubItems(): NavixCollection
    {
        return $this->get('sub_items','');
    }

    /**
     * Determine whether the navigation item has a label.
     * 
     * @return bool
     */
    public function hasLabel(): bool
    {
        return $this->has('label');
    }

    /**
     * Determine whether the navigation item has an icon.
     * 
     * @return bool
     */
    public function hasIcon(): bool
    {
        return $this->has('icon');
    }

    /**
     * Determine whether the navigation item has a badge.
     * 
     * @return bool
     */
    public function hasBadge(): bool
    {
        return $this->has('badge');
    }

    /**
     * Determine whether the navigation item has a URL.
     * 
     * @return bool
     */
    public function hasUrl(): bool
    {
        return $this->has('url');
    }

    /**
     * Determine whether the navigation item has sub-items.
     * 
     * @return bool
     */
    public function hasSubItems(): bool
    {
        return $this->has('sub_items');
    }
}
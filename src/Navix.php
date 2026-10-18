<?php

namespace Abolaradev\Navix;

use Abolaradev\Navix\Collections\NavixCollection;
use Closure;

class Navix
{
    /**
     * The name of the currently active navigation batch.
     */
    private ?string $currentBatch;

    /**
     * All registered navigation batches.
     *
     * @var NavixCollection<string, NavixCollection>
     */
    private NavixCollection $batches;

    /**
     * The navigation item currently being configured.
     *
     * @var NavixCollection<string, mixed>
     */
    private NavixCollection $item;

    /**
     * Stack of parent navigation items used to resolve nested groups.
     *
     * @var NavixCollection<int, NavixCollection>
     */
    private NavixCollection $parentStack;

    /**
     * Create a new Navix instance.
     */
    public function __construct()
    {
        $this->currentBatch = null;
        $this->batches = navixCollect();
        $this->item = navixCollect();
        $this->parentStack = navixCollect();
    }

    /**
     * Register a navigation batch.
     *
     * @param string $batch
     * @param Closure(): void $callable
     * @return void
     */
    public function batch(string $batch, Closure $callable): void
    {
        $this->currentBatch = $batch;
        $this->batches->put($batch, navixCollect());

        $callable();

        $this->currentBatch = null;
    }

    /**
     * Set the label of the current navigation item.
     *
     * @param string $label
     * @return static
     */
    public function label(string $label): static
    {
        $this->item->put('label', $label);

        return $this;
    }

    /**
     * Set the icon of the current navigation item.
     *
     * @param string $icon
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->item->put('icon', $icon);

        return $this;
    }

    /**
     * Set the badge of the current navigation item.
     *
     * @param string|int $badge
     * @return static
     */
    public function badge(string|int $badge): static
    {
        $this->item->put('badge', $badge);

        return $this;
    }

    /**
     * Set the URL of the current navigation item.
     *
     * @param string $path
     * @param array<string, mixed> $query
     * @param array<string, mixed> $parameters
     * @return static
     */
    public function url(string $path, array $query = [], array $parameters = []): static
    {
        $this->item->put('url', url()->query(
            path: $path,
            query: $query,
            extra: $parameters
        ));

        return $this;
    }

    /**
     * Add the current navigation item to its target collection.
     *
     * @return void
     */
    public function add(): void
    {
        $this->resolveTarget()->push($this->item);

        $this->item = navixCollect();
    }

    /**
     * Create a group containing nested navigation items.
     *
     * @param Closure(): void $callable
     * @return void
     */
    public function group(Closure $callable): void
    {
        $this->item->put('sub_items', navixCollect());

        $this->resolveTarget()->push($this->item);

        $this->parentStack->push($this->item);

        $this->item = navixCollect();

        try {
            $callable();
        } finally {
            $this->parentStack->pop();
        }
    }

    /**
     * Get a navigation batch by its name.
     *
     * @param string $batch
     * @return NavixCollection
     */
    public function getBatch(string $batch , ?string $search = null): NavixCollection
    {
        $items = $this->batches->get($batch, navixCollect());

        return $this->search($items,$search);
    }

    /**
     * Resolve the collection that should receive the current navigation item.
     *
     * @return NavixCollection
     */
    private function resolveTarget(): NavixCollection
    {
        return $this->parentStack->isEmpty()
            ? $this->batches->get($this->currentBatch)
            : $this->parentStack->last()->get('sub_items');
    }

    /**
     * Search for menu items by label, including nested sub-items.
     *
     * The search is case-insensitive and preserves parent groups
     * when any of their nested items match the search term.
     */
    private function search(NavixCollection $items, ?string $search=null): NavixCollection
    {
        if(is_null($search)){
            return $items;
        }

        return $items->filter(function ($values) use ($search) {
        
            $search = strtolower($search);
            $label = strtolower($values->get('label', ''));
            
            if (str_contains($label, $search)) {
                return true;
            }

            if ($values->has('subItems')) {
                return $this->search(
                    $values->get('subItems'),
                    $search
                )->isNotEmpty();
            }

            return false;
        });
    }
}
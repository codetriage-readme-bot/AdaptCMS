<?php

namespace App\Modules\Adaptbb\Listeners;

use App\Modules\Sitemap\Events\SitemapEvent;

use App\Modules\Adaptbb\Models\Forum;

use Cache;

class SitemapListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SitemapEvent $event)
    {

    }

    /**
     * Handle the event.
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(SitemapEvent $event)
    {
        $sitemap_data = json_decode(Cache::get('sitemap_data'), true);

        $forums = Forum::all();

        foreach($forums as $forum) {
            $sitemap_data[] = [
                'url' => route('plugin.adaptbb.forums.view', [ 'slug' => $forum->slug ]),
                'date' => $forum->updated_at,
                'frequency' => 'daily',
                'importance' => '0.5'
            ];
        }

        Cache::put('sitemap_data', json_encode($sitemap_data), 5);
    }
}

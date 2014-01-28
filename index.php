<?php

require_once 'vendor/autoload.php';
use Goutte\Client;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Item;


$client = new Client();
// Go to Petrino Potami category page.
$crawler = $client->request('GET', 'http://www.cybc-media.com/video/index.php/video-on-demand?task=view&cat=64&view=xml');

// Get the latest video links in this category.
$video_links = $crawler->filter('urlset > url > video > content_loc')->each(function ($node) {
  return $node->text();
});


// Setup a feed with the new data.
$feed = new Feed();
$channel = new Channel();
$channel
    ->title("Petrino Potami Feed")
    ->description("Channel Description")
    ->url('http://blog.example.com')
    ->appendTo($feed);

// Add links to the feed.
foreach ($video_links as $video_link) {
  // Parse links to ensure they are valid.
  $url_parts = parse_url($video_link);
  // Split the path to find the filename.
  $filename = end(explode('/', $url_parts['path']));

  $item = new Item();
  $item
    ->title($filename)
    ->description("$filename videofile.")
    ->url($video_link)
    ->appendTo($channel);
}

echo $feed;

?>

<?php

require_once 'vendor/fabpot/goutte/goutte.phar';

use Goutte\Client;

$client = new Client();
// Go to Petrino Potami category page.
$crawler = $client->request('GET', 'http://www.cybc-media.com/video/index.php/video-on-demand?task=view&cat=64&view=xml');

// Get the latest video links in this category.
$video_links = $crawler->filter('urlset > url > video > content_loc')->each(function ($node) {
  return $node->text();
});

?>

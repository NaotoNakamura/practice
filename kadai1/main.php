<?php
require_once (dirname(dirname(__FILE__)) . '/vendor/autoload.php');

class YouTube
{
    const API_KEY = "";
    public $youtube;

    public function __construct()
    {
        $this->youtube = new Google_Service_YouTube($this->fetchClient());
    }

    public function fetchClient()
    {
        $client = new Google_Client();
        $client->setApplicationName("youtubeApp");
        $client->setDeveloperKey(self::API_KEY);
        return $client;
    }
 
    public function fetchVideos()
    {
        $part = [
            'snippet',
        ];
        $params = [
            'q' => 'SHOWROOM',
            'type' => 'video',
            'maxResults' => 100,
            'order' => 'date',
        ];
        $search_results = $this->youtube->search->listSearch($part, $params);
        $videos = [];
        foreach ($search_results['items'] as $search_result) {
            $videos[] = $search_result;
        }
        return $videos;
    }
}

$youtube = new YouTube();
$videos = $youtube->fetchVideos();

count($videos);
foreach ($videos as $video) {
    echo "https://www.youtube.com/watch?v=" . $video["id"]["videoId"] . "\n";
}

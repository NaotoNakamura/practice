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

    public function fetchVideos($date)
    {
        $part = [
            'snippet',
        ];
        $params = [
            'q' => 'Apex Legends',
            'type' => 'video',
            'maxResults' => 10,
            'publishedAfter' => $date,
            'order' => 'viewCount',
            'regionCode' => 'JP',
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

$date = date('Y-m-d\TH:i:s\Z', strtotime('-3 day', time()));
$videos = $youtube->fetchVideos($date);

count($videos);
foreach ($videos as $video) {
    echo $video["snippet"]["title"] . ":" . "https://www.youtube.com/watch?v=" . $video["id"]["videoId"] . "\n";
    // echo $video["snippet"]["tags"] . "\n";
}

<?php
/**
 * Include composer autoloader.
 */
include getenv('ROOT_PATH').'vendor/autoload.php';

use App\Entity\Post;
use App\Service\Cache\FileCache;
use App\Service\DataProvider\ApiDataProvider;
use App\Service\Iterator\ArrayIterator;
use App\Service\Logger\FileLogger;
use App\Service\PostStatService;
use GuzzleHttp\Client;

// input data
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'averageLengthOfPostsPerMonth':
    case 'longestPostLengthPerMonth':
    case 'totalPostsByWeekNumber':
    case 'averageNumberOfPostsPerUserPerMonth':
        $client = new Client([
            'timeout' => getenv('API_TIMEOUT'),
        ]);
        $logger = new FileLogger();
        $iterator = new ArrayIterator(Post::class);
        $cache = new FileCache($logger);

        $dataProvider = new ApiDataProvider($client, $iterator, $cache, $logger);
        $statService = new PostStatService();

        $result = $statService->$action($dataProvider->prepareData());
        break;
    default:
        $result = ['error' => 'Action not found'];
}

header('Content-Type: application/json');
echo json_encode($result);

<?php

namespace App\Tests\Service\Iterator;

use App\Entity\Post;
use App\Service\Cache\CacheInterface;
use App\Service\DataProvider\ApiDataProvider;
use App\Service\Iterator\ArrayIterator;
use App\Service\Logger\LoggerInterface;
use App\Tests\TestAsset\PostsSampleApiResult;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiDataProviderTest extends TestCase
{
    /**
     * @var Client|\PHPUnit\Framework\MockObject\MockObject
     */
    private $client;

    /**
     * @var LoggerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $logger;

    /**
     * @var CacheInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $cache;

    /**
     * @var ApiDataProvider
     */
    private $apiProvider;

    private $posts = [];

    protected function setUp(): void
    {
        $mockResponses = [];

        foreach (PostsSampleApiResult::$posts as $page => $post) {
            foreach ($post as $item) {
                $this->posts[] = $item;
            }
            $mockResponses[] = new Response(200, [], json_encode([
                'data' => [
                    'sl_token' => 'test_token',
                ],
            ]));
            $mockResponses[] = new Response(200, [], json_encode([
                'data' => [
                    'posts' => $post,
                ],
            ]));
        }

        $mock = new MockHandler($mockResponses);
        $handlerStack = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handlerStack]);

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);

        $this->apiProvider = new ApiDataProvider($this->client, $this->logger, $this->cache);
    }

    /**
     * @dataProvider offsetLimitData
     *
     * @param $offset
     * @param $limit
     *
     * @throws \Exception
     */
    public function testPrepareData($offset, $limit)
    {
        $itrator = new ArrayIterator(Post::class);
        $this->apiProvider->prepareData($itrator, $offset, $limit);
        self::assertEquals($limit, $itrator->count());

        /** @var Post $item */
        $i = $offset;
        foreach ($itrator as $item) {
            self::assertEquals($this->posts[$i]['id'], $item->getId());
            self::assertEquals($this->posts[$i]['from_name'], $item->getFromName());
            self::assertEquals($this->posts[$i]['from_id'], $item->getFromId());
            self::assertEquals($this->posts[$i]['message'], $item->getMessage());
            self::assertEquals($this->posts[$i]['type'], $item->getType());
            self::assertEquals(new DateTime($this->posts[$i]['created_time']), $item->getCreatedTime());

            ++$i;
        }
    }

    public function offsetLimitData()
    {
        return [
            [0, 13],
            [0, 1],
            [1, 4],
            [9, 1],
        ];
    }
}

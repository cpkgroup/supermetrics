<?php

namespace App\Service\DataProvider;

use App\Service\Cache\CacheInterface;
use App\Service\Iterator\IteratorInterface;
use App\Service\Logger\LoggerInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ApiDataProvider implements DataProviderInterface
{
    private Client $client;

    private LoggerInterface $logger;

    private CacheInterface $cache;

    /**
     * ApiDataProvider constructor.
     */
    public function __construct(
        Client $client,
        LoggerInterface $logger,
        CacheInterface $cache
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->cache = $cache;
    }

    /**
     * @return bool
     */
    private function getToken()
    {
        try {
            $request = $this->client->post(getenv('REGISTER_URI'), [
                'form_params' => [
                    'client_id' => getenv('CLIENT_ID'),
                    'email' => getenv('CLIENT_EMAIL'),
                    'name' => getenv('CLIENT_NAME'),
                ],
            ]);
            $result = json_decode($request->getBody()->getContents(), true);

            return $result['data']['sl_token'];
        } catch (ClientException $e) {
            // 400 errors
            $this->logger->error('[API][REGISTER_TOKEN][ClientException]: '.$e->getMessage());
        } catch (Exception $e) {
            // 500 errors
            $this->logger->error('[API][REGISTER_TOKEN][Exception]: '.$e->getMessage());
        }

        return false;
    }

    /**
     * @param int $page
     *
     * @return bool
     */
    private function fetchPosts($page = 1)
    {
        $token = $this->getToken();
        if (!$token) {
            $this->logger->error('[API][FETCH_POSTS]: Token was wrong');

            return false;
        }

        try {
            $request = $this->client->get(getenv('FETCH_URI'), [
                'query' => [
                    'sl_token' => $token,
                    'page' => $page,
                ],
            ]);
            $result = json_decode($request->getBody()->getContents(), true);

            return $result['data']['posts'];
        } catch (ClientException $e) {
            // 400 errors
            $this->logger->error('[API][FETCH_POSTS][ClientException]: '.$e->getMessage());
        } catch (Exception $e) {
            // 500 errors
            $this->logger->error('[API][FETCH_POSTS][Exception]: '.$e->getMessage());
        }

        return false;
    }

    /**
     * @return bool|mixed
     */
    private function fetchCachedPosts(int $page)
    {
        $posts = $this->cache->get($page);
        if (!$posts) {
            $posts = $this->fetchPosts($page);
            if ($posts) {
                $this->cache->set($page, $posts);
            }
        }

        return $posts;
    }

    /**
     * Fill posts into the $itrator object by offset and limit.
     */
    public function prepareData(IteratorInterface $itrator, int $offset, int $limit)
    {
        $this->logger->info('[API][PREPARE_DATA] start to prepare data from: '.$offset.' to '.$limit);
        $counter = 0;
        for ($i = getenv('FIRST_PAGE'); $i <= getenv('LAST_PAGE'); ++$i) {
            $posts = $this->fetchCachedPosts($i);
            if (!$posts) {
                $this->logger->error('[API][PREPARE_DATA] Posts not found, page: '.$i);
                continue;
            }
            foreach ($posts as $post) {
                ++$counter;
                if ($offset < $counter) {
                    $itrator->push($post);
                }
                if ($counter >= $offset + $limit) {
                    break 2;
                }
            }
        }
    }
}

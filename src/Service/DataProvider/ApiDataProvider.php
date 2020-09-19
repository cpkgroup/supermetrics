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

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var IteratorInterface
     */
    private IteratorInterface $itrator;

    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ApiDataProvider constructor.
     * @param Client $client
     * @param IteratorInterface $itrator
     * @param CacheInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client,
                                IteratorInterface $itrator,
                                CacheInterface $cache,
                                LoggerInterface $logger
    )
    {
        $this->client = $client;
        $this->itrator = $itrator;
        $this->cache = $cache;
        $this->logger = $logger;
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
                ]
            ]);
            $result = json_decode($request->getBody()->getContents(), true);
            return $result['data']['sl_token'];
        } catch (ClientException $e) {
            // 400 errors
            $this->logger->error('[API][REGISTER_TOKEN][ClientException]: ' . $e->getMessage());
        } catch (Exception $e) {
            // 500 errors
            $this->logger->error('[API][REGISTER_TOKEN][Exception]: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * @param int $page
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
                ]
            ]);
            $result = json_decode($request->getBody()->getContents(), true);

            return $result['data']['posts'];
        } catch (ClientException $e) {
            // 400 errors
            $this->logger->error('[API][FETCH_POSTS][ClientException]: ' . $e->getMessage());
        } catch (Exception $e) {
            // 500 errors
            $this->logger->error('[API][FETCH_POSTS][Exception]: ' . $e->getMessage());
        }

        return false;
    }

    /**
     * @return IteratorInterface
     */
    public function prepareData()
    {
        for ($i = 1; $i <= getenv('LAST_PAGE'); $i++) {
            if (!$pagePosts = $this->cache->get($i)) {
                $pagePosts = $this->fetchPosts($i);
                if ($pagePosts) {
                    $this->cache->set($i, $pagePosts);
                }
            }

            if ($pagePosts) {
                foreach ($pagePosts as $post) {
                    $this->itrator->push($post);
                }
            }
        }

        return $this->itrator;
    }
}

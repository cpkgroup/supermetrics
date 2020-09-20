<?php

namespace App\Tests\Service\Iterator;

use App\Entity\Post;
use App\Service\Iterator\ArrayIterator;
use App\Service\PostStatService;
use PHPUnit\Framework\TestCase;

class PostStatServiceTest extends TestCase
{
    /**
     * @dataProvider getPosts
     *
     * @param $items
     * @param $calculatedData
     */
    public function testPostStatService($items, $calculatedData)
    {
        $statService = new PostStatService();
        $postIterator = new ArrayIterator(Post::class);

        foreach ($items as $item) {
            $postIterator->push($item);
        }

        $result = $statService->averageLengthOfPostsPerMonth($postIterator);
        self::assertEquals($calculatedData['averageLengthOfPostsPerMonth'], $result);

        $result = $statService->averageNumberOfPostsPerUserPerMonth($postIterator);
        self::assertEquals($calculatedData['averageNumberOfPostsPerUserPerMonth'], $result);

        $result = $statService->longestPostLengthPerMonth($postIterator);
        self::assertEquals($calculatedData['longestPostLengthPerMonth'], $result);

        $result = $statService->totalPostsByWeekNumber($postIterator);
        self::assertEquals($calculatedData['totalPostsByWeekNumber'], $result);
    }

    public function getPosts()
    {
        return [
            [
                [
                    [
                        'id' => 'post5f64611cece22_8592507c',
                        'from_name' => 'Macie Mckamey',
                        'from_id' => 'user_11',
                        'message' => 'pressure stress prisoner agile axis hallway',
                        'type' => 'status',
                        'created_time' => '2020-09-18T02:38:46+00:00',
                    ],
                ],
                [
                    'averageLengthOfPostsPerMonth' => [
                        '2020-09' => 43.0,
                    ],
                    'averageNumberOfPostsPerUserPerMonth' => [
                        [
                            'User Id' => 11,
                            'User Name' => 'Macie Mckamey',
                            'Average Posts Per Month' => 1.0,
                        ],
                    ],
                    'longestPostLengthPerMonth' => [
                        '2020-09' => 43.0,
                    ],
                    'totalPostsByWeekNumber' => [
                        '2020-38' => 1,
                    ],
                ],
            ],
            [
                [
                    [
                        'id' => 'post5f64611cece22_8592507c',
                        'from_name' => 'Macie Mckamey',
                        'from_id' => 'user_11',
                        'message' => 'pressure stress prisoner agile axis hallway',
                        'type' => 'status',
                        'created_time' => '2020-09-18T02:38:46+00:00',
                    ],
                    [
                        'id' => 'post5f64611cece3a_caf07475',
                        'from_name' => 'Yolande Urrutia',
                        'from_id' => 'user_15',
                        'message' => 'litigation lip closed due borrow margin complex bottom instrument candle restrict lose drill trail irony sailor location ton format ignite mirror role publisher tract definite date terminal empire throne route resource disk rear sight still escape chocolate palm braid essay suggest theft college ministry talkative climate bar reveal realize west nuance carve dignity',
                        'type' => 'status',
                        'created_time' => '2020-09-17T20:42:50+00:00',
                    ],
                    [
                        'id' => 'post5f64611cece45_d6e53dcc',
                        'from_name' => 'Rosann Eide',
                        'from_id' => 'user_9',
                        'message' => 'roar teacher vessel discrimination absent cigarette hell appear carry excitement ban velvet stand unaware market waste conflict rehabilitation electron scholar body awful awful hate shop language belly diameter crossing agile business west ballot size debt rough fan chief dressing contrast find swim rape kick full hell correspondence reptile transport sample dawn bottom sailor thoughtful pest deficiency lamb size blade letter need candle anger index rib shorts tune horror favourite pump morning representative mood acceptance qualified railroad integration cigarette freedom chain freeze agile speed rally stress bracket handy rare execute',
                        'type' => 'status',
                        'created_time' => '2020-09-17T15:02:34+00:00',
                    ],
                    [
                        'id' => 'post5f64611csdf3cc',
                        'from_name' => 'Rosann Eide',
                        'from_id' => 'user_9',
                        'message' => 'ent ban velvet stand unaware market waste conflict rehabilitation electron scholar body awful awful hate shop language belly diameter crossing agile business west ballot size debt rough fan chief dressing contrast find swim rape kick full hell correspondence reptile transport sample dawn bottom sailor thoughtful pest deficiency lamb size blade letter need candle anger index rib shorts tune horror favourite pump morning representative mood acceptance qualified railroad integration cigarette freedom chain freeze agile speed rally stress bracket handy rare execute',
                        'type' => 'status',
                        'created_time' => '2020-09-17T15:02:34+00:00',
                    ],
                ],
                [
                    'averageLengthOfPostsPerMonth' => [
                        '2020-09' => 406.0,
                    ],
                    'averageNumberOfPostsPerUserPerMonth' => [
                        [
                            'User Id' => 11,
                            'User Name' => 'Macie Mckamey',
                            'Average Posts Per Month' => 1.0,
                        ],
                        [
                            'User Id' => 15,
                            'User Name' => 'Yolande Urrutia',
                            'Average Posts Per Month' => 1.0,
                        ],
                        [
                            'User Id' => 9,
                            'User Name' => 'Rosann Eide',
                            'Average Posts Per Month' => 2.0,
                        ],
                    ],
                    'longestPostLengthPerMonth' => [
                        '2020-09' => 644,
                    ],
                    'totalPostsByWeekNumber' => [
                        '2020-38' => 4,
                    ],
                ],
            ],
            [
                [
                    [
                        'id' => 'post5f64611cece22_8592507c',
                        'from_name' => 'Macie Mckamey',
                        'from_id' => 'user_11',
                        'message' => 'pressure stress prisoner agile axis hallway',
                        'type' => 'status',
                        'created_time' => '2020-09-18T02:38:46+00:00',
                    ],
                    [
                        'id' => 'post5f64611cece3a_caf07475',
                        'from_name' => 'Yolande Urrutia',
                        'from_id' => 'user_15',
                        'message' => 'litigation lip closed due borrow margin complex bottom instrument candle restrict lose drill trail irony sailor location ton format ignite mirror role publisher tract definite date terminal empire throne route resource disk rear sight still escape chocolate palm braid essay suggest theft college ministry talkative climate bar reveal realize west nuance carve dignity',
                        'type' => 'status',
                        'created_time' => '2020-09-17T20:42:50+00:00',
                    ],
                    [
                        'id' => 'post5f64611cece45_d6e53dcc',
                        'from_name' => 'Rosann Eide',
                        'from_id' => 'user_9',
                        'message' => 'roar teacher vessel discrimination absent cigarette hell appear carry excitement ban velvet stand unaware market waste conflict rehabilitation electron scholar body awful awful hate shop language belly diameter crossing agile business west ballot size debt rough fan chief dressing contrast find swim rape kick full hell correspondence reptile transport sample dawn bottom sailor thoughtful pest deficiency lamb size blade letter need candle anger index rib shorts tune horror favourite pump morning representative mood acceptance qualified railroad integration cigarette freedom chain freeze agile speed rally stress bracket handy rare execute',
                        'type' => 'status',
                        'created_time' => '2020-09-17T15:02:34+00:00',
                    ],
                    [
                        'id' => 'post5f64611csdf3cc',
                        'from_name' => 'Rosann Eide',
                        'from_id' => 'user_9',
                        'message' => 'ent ban velvet stand unaware market waste conflict rehabilitation electron scholar body awful awful hate shop language belly diameter crossing agile business west ballot size debt rough fan chief dressing contrast find swim rape kick full hell correspondence reptile transport sample dawn bottom sailor thoughtful pest deficiency lamb size blade letter need candle anger index rib shorts tune horror favourite pump morning representative mood acceptance qualified railroad integration cigarette freedom chain freeze agile speed rally stress bracket handy rare execute',
                        'type' => 'status',
                        'created_time' => '2020-09-17T15:02:34+00:00',
                    ],
                    [
                        'id' => 'post5f64611cedb62_bc40ebb1',
                        'from_name' => 'Leonarda Schult',
                        'from_id' => 'user_3',
                        'message' => 'innocent dog angel facade food belong tumour kick twist sample on prevent food competition series sustain dawn air abortion mess air competition reward memorandum abstract expertise treasurer throne retired integration mile future participate clinic mug eagle use visual tick district paint cottage trade address favourite waste climate far harmful attention housing retirement jurisdiction prestige difficult',
                        'type' => 'status',
                        'created_time' => '2020-05-29T23:39:26+00:00',
                    ],
                    [
                        'id' => 'post5f64611cedb68_930debd3',
                        'from_name' => 'Carson Smithson',
                        'from_id' => 'user_5',
                        'message' => 'church judgment skeleton chocolate publisher test embryo opposition beg gile wreck fist put extend sailor deserve flower slab unfair reliable pavement television terminal fuel donor presidency omission shy syndrome curl constellation virtue reliable radio waste diamond dismissal refuse makeup secretion steward grow satellite sanctuary queen set monopoly witness transmission sigh hiccup',
                        'type' => 'status',
                        'created_time' => '2020-05-29T18:53:13+00:00',
                    ],
                    [
                        'id' => 'post5f64611cedb6e_f4a6f823',
                        'from_name' => 'Filomena Cort',
                        'from_id' => 'user_1',
                        'message' => 'opposite raid final embark resort member development expose fame  run retiree night lie size multimedia evening insert outside linen execute spell shop desert run tract debt use resign sight mess resort swallow snack depend tense indulge tape',
                        'type' => 'status',
                        'created_time' => '2020-05-29T12:58:58+00:00',
                    ],
                    [
                        'id' => 'post5f64611cedb73_ff8f4d3f',
                        'from_name' => 'Carson Smithson',
                        'from_id' => 'user_5',
                        'message' => 'rear magnetic confusion shift margin organize velvet core biology canvas building reptile climb sulphur tune banner crossing direct pillow appetite fail improve force swim option resign syndrome stake abstract carbon story monopoly south television forest space urine initiative air drag pavement straight radio railroad reserve forward conflict stress use think midnight snake squash instal forget still greeting avant-garde generate crossing center kill boat grandmother friend loose gravel sister',
                        'type' => 'status',
                        'created_time' => '2020-05-29T07:15:58+00:00',
                    ],
                ],
                [
                    'averageLengthOfPostsPerMonth' => [
                        '2020-09' => 406.0,
                        '2020-05' => 385.0,
                    ],
                    'averageNumberOfPostsPerUserPerMonth' => [
                        [
                            'User Id' => 11,
                            'User Name' => 'Macie Mckamey',
                            'Average Posts Per Month' => 1.0,
                        ],
                        [
                            'User Id' => 15,
                            'User Name' => 'Yolande Urrutia',
                            'Average Posts Per Month' => 1.0,
                        ],
                        [
                            'User Id' => 9,
                            'User Name' => 'Rosann Eide',
                            'Average Posts Per Month' => 2.0,
                        ],
                        [
                            'User Id' => 3,
                            'User Name' => 'Leonarda Schult',
                            'Average Posts Per Month' => 1.0,
                        ],
                        [
                            'User Id' => 5,
                            'User Name' => 'Carson Smithson',
                            'Average Posts Per Month' => 2.0,
                        ],
                        [
                            'User Id' => 1,
                            'User Name' => 'Filomena Cort',
                            'Average Posts Per Month' => 1.0,
                        ],
                    ],
                    'longestPostLengthPerMonth' => [
                        '2020-09' => 644,
                        '2020-05' => 499,
                    ],
                    'totalPostsByWeekNumber' => [
                        '2020-38' => 4,
                        '2020-22' => 4,
                    ],
                ],
            ],
        ];
    }
}

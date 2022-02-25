<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Tumblr\API\Client;

class UserController extends Controller
{
    private $client;

    public function __construct(Client $client, Document $document)
    {
        $this->client   = $client;
        $this->document = $document;
    }

    /**
     * View blog posts from blog
     *
     */
    public function blog($blogName)
    {
        if (request()->type && (request()->type == "photo" || request()->type == "video")) {
            $options['type'] = request()->type;
        }
        $options['limit']       = request()->input('limit', 10);
        $options['reblog_info'] = request()->input('reblog_info', true);
        $options['offset']      = (request()->input('page', 1) - 1) * $options['limit'];

        try {
            $result = $this->client->getBlogPosts($blogName, $options);
        } catch (Exception $e) {
            if ($e->getCode() == 404) {
                return view('error.404');
            }
        }

        $collection = collect($result->posts);

        $changed = $collection->transform(function ($value, $key) {
            switch ($value->type) {
                case 'photo':
                    if (count($value->photos) > 1) {
                        $value->gallery = true;
                    } else {
                        $value->gallery = false;
                    }
                    foreach ($value->photos as $photo) {
                        $value->src    = $photo->original_size->url;
                        $value->pics[] = $photo->original_size->url;
                    }
                    break;
                case 'video':
                    $dom   = $this->document->loadHtml(last($value->player)->embed_code);
                    $video = $dom->find('video');
                    if (count($video)) {
                        $value->video_height = $video[0]->getAttribute('height');
                        $value->video_width  = $video[0]->getAttribute('width');
                    }
                    $value->video_poster = (optional($value)->thumbnail_url);
                    break;
                case 'text':
                    $dom            = $this->document->loadHtml(optional($value)->body);
                    $media['photo'] = $dom->find('img');
                    $media['video'] = $dom->find('video');
                    $video_info     = $dom->find('figure');
                    foreach ($media as $tag => $sources) {
                        $value->src_type = $value->type;
                        if (!empty($tag)) {
                            switch ($tag) {
                                case "photo":
                                    foreach ($sources as $source) {
                                        $value->type   = "photo";
                                        $value->src    = $source->getAttribute('src');
                                        $value->pics[] = $source->getAttribute('src');
                                        if (count($value->pics) > 1) {
                                            $value->gallery = true;
                                        } else {
                                            $value->gallery = false;
                                        }
                                    }
                                    break;
                                case "video":
                                    foreach ($sources as $source) {
                                        $value->type          = "video";
                                        $value->video_type    = "tumblr";
                                        $value->html5_capable = "true";
                                        foreach ($source->find('source') as $k) {
                                            $value->video_url = $k->getAttribute('src');
                                        }
                                        $value->video_height = $video_info[0]->getAttribute('data-orig-height');
                                        $value->video_width  = $video_info[0]->getAttribute('data-orig-width');
                                        $value->video_poster = $source->getAttribute('poster');
                                    }
                                    break;
                            }
                        }
                    }
                    break;
            }

            return $value;
        });

        $posts = (new LengthAwarePaginator(
            $changed,
            $result->total_posts,
            $options['limit'],
            request()->page,
            [
                'path' => request()->url(),
            ]
        ));

        $blog = $result->blog;

        $blogInfo = $this->client->getBlogInfo($blogName);

        return view('blog.index', compact('blog', 'posts', 'blogInfo'));
    }

    /**
     * Follow a Blog
     *
     */
    public function follow($blogName)
    {
        $follow = $this->client->follow($blogName);

        return redirect()->back();
    }

    /**
     * Unfollow a Blog
     *
     */
    public function unfollow($blogName)
    {

        $unfollow = $this->client->unfollow($blogName);

        return redirect()->back();
    }

    /**
     * Reblog a post
     *
     */
    public function reblog()
    {
        $userInfo = $this->client->getUserInfo();

        $blogName  = $userInfo->user->name;
        $id        = request()->blog_id;
        $reblogKey = request()->reblog_key;

        try {
            $reblog = $this->client->reblogPost($blogName, $id, $reblogKey);
        } catch (Exception $e) {
            report($e);

        }

        return redirect()->back();
    }

    /**
     * Like a post
     *
     */
    public function like()
    {
        $id        = request()->blog_id;
        $reblogKey = request()->reblog_key;

        $like = $this->client->like($id, $reblogKey);

        laraflash('Liked succesfully', 'Some title')->success();

        return redirect()->back();
    }

    /**
     * Unlike a post
     *
     */
    public function unlike()
    {
        $id        = request()->blog_id;
        $reblogKey = request()->reblog_key;

        $unlike = $this->client->unlike($id, $reblogKey);

        laraflash('Unliked succesfully', 'Some title')->danger();

        return redirect()->back();
    }

    /**
     * Get liked posts
     *
     */
    public function likes()
    {
        $likes = $this->client->getLikedPosts(['offset' => (request()->page - 1) * 20]);

        $posts = (new LengthAwarePaginator($likes->liked_posts, $likes->liked_count, 20, request()->page, ['path' => request()->url()]));

        return view('likes', compact('posts'));
    }

    /**
     * Get followed blogs
     *
     */
    public function getFollowedBlogs()
    {
        $following = $this->client->getFollowedBlogs(['offset' => (request()->page - 1) * 20]);

        $posts = (new LengthAwarePaginator($following->blogs, $following->total_blogs, 20, request()->page, ['path' => request()->url()]));

        return view('following', compact('posts'));
    }
}

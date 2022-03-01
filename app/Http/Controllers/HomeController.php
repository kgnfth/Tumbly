<?php

namespace App\Http\Controllers;

use DiDom\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use Tumblr\API\Client;

class HomeController extends Controller
{

    public function __construct(Client $client, Document $document)
    {
        $this->client   = $client;
        $this->document = $document;
    }

    public function index()
    {
        $type = request()->type;

        return $this->getDashboardPosts();

    }

    public function getDashboardPosts()
    {
        $options['limit']  = request()->input('limit', 10);
        $options['offset'] = (request()->input('page', 1) - 1) * $options['limit'];

        if (request()->type && (request()->type == "photo" || request()->type == "video")) {
            $options['type'] = request()->type;
        }

        $result     = $this->client->getDashboardPosts($options);
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

        $dashboardPosts = (new LengthAwarePaginator(
            $changed,
            260,
            $options['limit'],
            request()->page,
            [
                'path' => request()->url(),
            ]
        ));

        return view('home', compact('dashboardPosts'));
    }

    public function show($blog, $id)
    {

        $avatar = $this->client->getBlogAvatar($blog, 512);

        $blogPost = $this->client->getBlogPosts($blog, [
            'id'          => $id,
            'reblog_info' => true,
            'notes_info'  => true,
        ]);

        $blog       = $blogPost->blog;
        $post       = $blogPost->posts;
        $collection = collect($post);
        $changed    = $collection->map(function ($value, $key) {
            switch ($value->type) {
                case "video":
                    $dom                 = $this->document->loadHtml(last($value->player)->embed_code);
                    $video               = $dom->find('video');
                    $value->video_poster = (optional($value)->thumbnail_url);
                    $value->video_height = $video[0]->getAttribute('height');
                    $value->video_width  = $video[0]->getAttribute('width');
                    break;
                case 'text':
                    $dom            = $this->document->loadHtml(optional($value)->body);
                    $media['photo'] = $dom->find('img');
                    $media['video'] = $dom->find('video');
                    $video_info     = $dom->find('figure');
                    foreach ($media as $tag => $sources) {
                        $value->src_type = 'text';
                        if (!empty($tag)) {
                            switch ($tag) {
                                case "photo":
                                    foreach ($sources as $source) {
                                        $value->type           = "photo-text";
                                        $photos                = $value->photos[]                = new \stdClass();
                                        $photos->original_size = new \stdClass();

                                        $photos->original_size->url    = $source->getAttribute('src');
                                        $photos->original_size->height = (int) $source->getAttribute('data-orig-height');
                                        $photos->original_size->width  = (int) $source->getAttribute('data-orig-width');

                                    }
                                    break;
                                case "video":
                                    foreach ($sources as $source) {
                                        $value->type          = "video-text";
                                        $value->video_type    = "tumblr";
                                        $value->html5_capable = "true";
                                        foreach ($source->find('source') as $k) {
                                            $value->video_url = $k->getAttribute('src');
                                        }
                                        $value->video_height  = $video_info[0]->getAttribute('data-orig-height');
                                        $value->video_width   = $video_info[0]->getAttribute('data-orig-width');
                                        $value->thumbnail_url = $source->getAttribute('poster');
                                    }
                                    break;
                            }
                        }
                    }
                    break;
            }

            return $value;
        });
        $post = $changed[0];

        return view('post.show', compact('avatar', 'blog', 'post'));
    }

    public function search($tag)
    {
        $posts = $this->client->getTaggedPosts(
            request()->tag,
            [
                'offset' => (request()->input('page', 1) - 1) * 20,
            ]
        );
        $tagged = (new LengthAwarePaginator(
            $posts,
            280,
            20,
            request()->page, [
                'path' => request()->url(),
            ])
        );

        return view('search.tagged', compact('tagged'));
    }
}

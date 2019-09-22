<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class PublishScheduledPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts according to publish dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::query()
            ->where('status', '=', 'scheduled')
            ->where('publication_date', '<', Carbon::now())
            ->get();

        $posts->each(function (Post $post) {
            $post->withoutActivity()->update(['status' => 'published']);
        });
    }
}

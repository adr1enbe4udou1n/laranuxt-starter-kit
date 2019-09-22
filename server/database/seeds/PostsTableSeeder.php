<?php

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Import de tags
        factory(Tag::class)->times(30)->create();

        $tags = Tag::all();

        $faker = Faker\Factory::create();

        /*
         * Generate 100 posts
         */
        /** @var \Illuminate\Database\Eloquent\Collection $post */
        $post = factory(Post::class)->state('post')->times(500)->create();

        $post->each(function (Post $post) use ($faker, $tags) {
            // Featured image
            $post->addMedia(DatabaseSeeder::randomMediaPath($faker, 'business'))
                ->preservingOriginal()
                ->toMediaCollection('featured_images');

            // Rich text
            $post->body = DatabaseSeeder::generateRichBody($faker);
            $post->save();

            // Tags
            if ($tags) {
                $post->tags()->saveMany($tags->random($faker->numberBetween(0, 3)));
            }
        });

        /*
         * Generate few pages
         */
        collect([
            'FAQ',
            'Help',
            'Support',
            'Terms',
            'Privacy',
            'About Us',
        ])->each(function ($title) use ($faker) {
            /** @var \Illuminate\Database\Eloquent\Collection $post */
            $post = factory(Post::class)->states(['page', 'published'])->create([
                'title' => $title,
            ]);

            $post->each(function (Post $post) use ($faker) {
                // Featured image
                $post->addMedia(DatabaseSeeder::randomMediaPath($faker, 'business'))
                    ->preservingOriginal()
                    ->toMediaCollection('featured_images');

                // Rich text
                $post->body = DatabaseSeeder::generateRichBody($faker);
                $post->save();
            });
        });
    }
}

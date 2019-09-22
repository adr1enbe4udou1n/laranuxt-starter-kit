<?php

use Faker\Generator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
    }

    /**
     * Récupérer le chemin d'un fichier média aléatoire.
     *
     * @param Generator|\Faker\UniqueGenerator $faker
     * @param string                           $type
     * @param string                           $extension
     *
     * @return string
     */
    public static function randomMediaPath($faker, $type, $extension = 'jpg'): string
    {
        $types = [
            'business'    => 30,
        ];

        $i = str_pad($faker->numberBetween(1, $types[$type]), 2, '0', STR_PAD_LEFT);

        return database_path("/seeds/media/{$type}-{$i}.{$extension}");
    }

    /**
     * Générer un body riche.
     *
     * @param Generator|\Faker\UniqueGenerator $faker
     *
     * @return string
     */
    public static function generateRichBody($faker): string
    {
        $html = '';

        $dir = 'public/files/business';

        if (! File::exists($dir)) {
            File::makeDirectory($dir);
        }

        /*
         * Generate 1 title + block
         */
        for ($i = 0; $i < $faker->numberBetween(3, 5); $i++) {
            $title = Str::title($faker->words($faker->numberBetween(5, 10), true));
            $html .= "<h2>$title</h2>";

            /*
             * Generate 1 subtitle + block
             */
            for ($j = 0; $j < $faker->numberBetween(2, 3); $j++) {
                $title = Str::title($faker->words($faker->numberBetween(5, 10), true));
                $html .= "<h3>$title</h3>";

                /*
                 *  Generate many paragraphs
                 */
                for ($k = 0; $k < $faker->numberBetween(2, 5); $k++) {
                    $paragraph = $faker->paragraph(5);
                    $html .= "<p>$paragraph</p>";

                    /*
                     * Add image randomly
                     */
                    if ($faker->boolean(25)) {
                        $source = self::randomMediaPath($faker, 'business');
                        $image = basename($source);
                        $target = "$dir/$image";

                        if (! File::exists($target)) {
                            File::copy($source, $target);
                        }

                        $html .= "<p><img src=\"/files/business/{$image}\" alt=\"\"></p>";
                    }
                }
            }
        }

        return $html;
    }
}

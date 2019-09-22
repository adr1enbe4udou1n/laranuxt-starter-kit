<?php

namespace App\Providers;

use App\Models\Post;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ('production' === config('app.env')) {
            URL::forceScheme('https');
        }

        Relation::morphMap([
            'post' => Post::class,
        ]);

        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, auth()->user()->password);
        }, __('validation.mismatch_password'));

        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            // Le mot de passe doit au moins contenir une lettre majuscule et minuscule, un chiffre ainsi
            // qu'un caractère spécial
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', (string) $value);
        }, __('validation.strong_password'));

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new ReCaptcha(config('recaptcha.secret'));
            $resp = $recaptcha->verify($value);

            return $resp->isSuccess();
        }, __('validation.wrong_recaptcha'));

        Blade::directive('encoreEntryLinkTags', function ($entry) {
            return "<?php echo encore_entry_link_tags($entry) ?>";
        });

        Blade::directive('encoreEntryScriptTags', function ($entry) {
            return "<?php echo encore_entry_script_tags($entry) ?>";
        });

        Request::macro('parseArray', function ($key): array {
            if ($value = request()->get($key)) {
                return is_array($value) ? $value : explode(',', $value);
            }

            return [];
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}

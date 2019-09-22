<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasMediaRequest.
 *
 * Autoinjection des fichiers d'upload dans le modèle depuis une requête HTTP.
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 *
 * @property $mediables Champs médias supportés
 */
trait HasMediaRequest
{
    /**
     * @var string Identifiant de préfixe des données POST à récupérer
     */
    public $mediaRequestPrefix = '';

    public static function bootHasMediaRequest()
    {
        /**
         * Enregistrer les fichiers indiqués dans la request.
         */
        static::saving(function (Model $model) {
            /* @var \App\Models\Traits\HasMediaRequest|\Spatie\MediaLibrary\HasMedia\HasMediaTrait $model */
            foreach ($model->mediables as $attribute => $collection) {
                /*
                 * Supprimer l'image principale si demandé
                 */
                if (request()->input("{$model->mediaRequestPrefix}{$attribute}_delete")) {
                    $model->clearMediaCollection($collection);
                }

                /*
                 * Upload image principal
                 */
                if ($image = request()->file("{$model->mediaRequestPrefix}{$attribute}_file")) {
                    if ($image->isReadable()) {
                        $model->clearMediaCollection($collection)
                            ->addMedia($image)->toMediaCollection($collection);
                    }
                }
            }
        });
    }
}

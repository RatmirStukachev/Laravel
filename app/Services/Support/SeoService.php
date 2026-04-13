<?php

namespace App\Services\Support;

use App\Models\Seo;
use Illuminate\Support\Facades\View;

class SeoService
{
    /**
     * Генерация сео данных
     * @param $model
     */
    public function generate($model): void
    {
        $seo = $model->seo;
        if(!$seo) {
            $seo = new Seo();
        }


        if (request()->has('page')) {
            $numberPageStr = ' – Страница ' . request()->page;
        }
        else {
            $numberPageStr = '';
        }

        if (!$seo->title) {
            $seo->title = $this->setTitle($model);
        }
        if (!$seo->description) {
            $seo->description = $this->setDescription($model);
        }

        $seo->title = $seo->title . $numberPageStr;
        $seo->description = $seo->description  . $numberPageStr;

        View::share(compact('seo'));
    }


    /**
     * Установить title по умолчанию
     * @return string
     */
    public function setTitle($model)
    {
        return $model->title . ' ' .env('APP_NAME');
    }

    /**
     * Установить description по умолчанию
     * @return string
     */
    public function setDescription($model)
    {
        return $model->title . ' ' .env('APP_NAME');
    }
}

<?php

namespace App\Models\Traits;

use App\Models\Seo;

trait UsedFunctions
{
    /**
     * Выбирает активные
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsActive($query){
        return $query->where('is_active', true);
    }


    /**
     * Выбирает все кроме родительских
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsNoMain($query){
        return $query->where('parent_id', '!=', null);
    }

    /**
     * Сортирует по pos
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrderByPos($query){
        return $query->orderBy('pos')->orderBy('id');
    }

    /**
     * Сортирует по create
     * @param $query
     *
     * @return mixed
     */
    public function scopeOrderByDescCreate($query){
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Выбирает верхнее меню в шапке
     * @param $query
     * @return mixed
     */
    public function scopeInTopMenu($query){
        return $query->where('in_top', true);
    }

    /**
     * Выбирает нижнее  меню в шапке
     * @param $query
     * @return mixed
     */
    public function scopeInBottomMenu($query){
        return $query->where('in_bottom', true);
    }

    /**
     * Выбирает меню в подвале
     * @param $query
     * @return mixed
     */
    public function scopeInFooterMenu($query){
        return $query->where('in_footer', true);
    }

    /**
     * Выбирает бокового меню
     * @param $query
     * @return mixed
     */
    public function scopeInAsideMenu($query){
        return $query->where('in_aside', true);
    }

    /**
     * Выбирает меню в шапке
     * @param $query
     * @return mixed
     */
    public function scopeInHeaderMenu($query){
        return $query->where('in_header', true);
    }

    /**
     * Выбирает основных родителей в катеогрии
     * @param $query
     * @return mixed
     */
    public function scopeMainParent($query){
        return $query->where('parent_id', false)->orWhere('parent_id', null);
    }

    public function scopeIsSpec($query){
        return $query->where('is_spec', 1);
    }

    public function scopeHome($query){
        return $query->where('is_home', 1);
    }
    /**
     * Генерация ссылки на категорию
     * @return string
     */
    public function link($parent = null)
    {
        if (!$this->parent_id) {
            return  $this->slug;
        }
        if ($parent) {
            return $parent->slug . '/' . $this->slug;
        }
    }

    public static function buildTree($items)
    {
        $items = $items->sortBy('parent_id')->sortBy('pos');
        $grouped = $items->groupBy('parent_id');

        foreach ($items as $item) {
            if ($grouped->has($item->id)) {
                $item->children = $grouped[$item->id];
            }
        }

        return $items->where('parent_id', 0);
    }


    /**
     * Фильтр
     * @param Builder $builder
     * @param QueryFilter $filters
     * @return mixed\
     */
    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }


    public $imageSizes = [
        'logo' => [245,245],
        'partners' => [450,225],
        'slider' => [235,235],
        'partner_small' => [250,90],
        'news' => [1190,600],
        'news_list' => [1190,600],
        'news_small' => [575,320],
        'cert' => [840,1188],
        'cert_small' => [275,388],
        'review_popup' => [450,225],
        'review_small' => [500,180],
        'life_imag1' => [400,710],
        'life_imag2' => [1060,540],
        'life_imag3' => [520,334],
        'decisions' => [815,815],
        'subdecision' => [1200,800],
    ];

    public function getTextContentAttribute()
    {
        $pattern = $this->getShortcodeRegex();

        if (preg_match_all($pattern, $this->text, $matches)
            && array_key_exists(2, $matches)
            && (in_array('doc', $matches[2]))
        ) {


            for ($i = 0; $i < count($matches[0]); $i++) {
                $shortCode = $matches[0][$i];
                $docId = trim(str_replace('doc ', '', $matches[1][$i]));
                $ids = explode(',', $docId);

                $content = $this->getDocShortcode($ids);

                $this->text = str_replace($shortCode, $content, $this->text);

            }
        }

        return $this->text;
    }

//    public function geth1Attribute()
//    {
//        return $this->h1 ?? $this->title;
//    }
    public function getDocumentsContentAttribute()
    {
        $pattern = $this->getShortcodeRegex();

        if (preg_match_all($pattern, $this->documents, $matches)
            && array_key_exists(2, $matches)
            && (in_array('doc', $matches[2]))
        ) {


            for ($i = 0; $i < count($matches[0]); $i++) {
                $shortCode = $matches[0][$i];
                $docId = trim(str_replace('doc ', '', $matches[1][$i]));
                $ids = explode(',', $docId);

                $content = $this->getDocShortcode($ids);

                $this->documents = str_replace($shortCode, $content, $this->documents);

            }
        }

        return $this->documents;
    }

    public function getShortcodeRegex()
    {
        return '/\[%((doc)(?:[^\]]*)?)%\]/';
    }

    public function seo()
    {
        return $this->morphOne(Seo::class , 'seo');
    }
}

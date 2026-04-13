<?php

namespace App\Services;

use App\Models\News;
use App\Models\Page;
use App\Models\Brand;
use App\Models\Point;
use App\Models\Article;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Services\Support\SeoService;
use App\Services\Support\BreadcrumbsService;
use Filament\Widgets\StatsOverviewWidget\Card;

class PageService
{
    private $seoService;
    private $breadcrumbsService;

    public function __construct(
        SeoService $seoService,
        BreadcrumbsService $breadcrumbsService
    ){
        $this->seoService = $seoService;
        $this->breadcrumbsService = $breadcrumbsService;
    }

    public function setPointPage(Point $point): bool
    {
        $this->seoService->generate($point);
        $this->breadcrumbsService->pagePoint($point)->generate();
        
        return true;
    }

    public function getPageOneNews(string $slug)
    {
        $page = News::with('seo')->isActive()->where('slug', $slug)->firstOrFail();

        $this->seoService->generate($page);
        $this->breadcrumbsService->pageNews($page)->generate();

        return $page;
    }

    public function getPageArticle(string $slug)
    {
        $page = Article::with('seo')->isActive()->where('slug', $slug)->firstOrFail();

        $this->seoService->generate($page);
        $this->breadcrumbsService->pageArticle($page)->generate();

        return $page;
    }

    public function getServicePage(Service $service)
    {
        $this->seoService->generate($service);
        $this->breadcrumbsService->pageService($service)->generate();

        return $service;
    }

    public function getLastServicePage(Service $service)
    {
        $this->seoService->generate($service);
        $this->breadcrumbsService->pageLastService($service)->generate();

        return $service;
    }

    /**
     * Получение отдельной страницы
     * @param $slug
     * @return mixed
     */
    public function getPage(string $slug)
    {
        $page = Page::with('seo')->isActive()->where('slug', $slug)->firstOrFail();

        $this->seoService->generate($page);
        $this->breadcrumbsService->page($page)->generate();

        return $page;
    }

    public function getPageAccount(string $slug)
    {
        $page = Page::with('seo')->isActive()->where('slug', $slug)->firstOrFail();

        $this->seoService->generate($page);
        $this->breadcrumbsService->pageAccount($page)->generate();

        return $page;
    }

    public function setCategoryPage(Category $category)
    {
        $this->seoService->generate($category);
        $this->breadcrumbsService->pageCategory($category)->generate();
        return $category;
    }
    public function setSubCategoryPage(Category $category)
    {
        $this->seoService->generate($category);
        $this->breadcrumbsService->pageSubcategory($category)->generate();
        return $category;
    }
    public function setLastCategoryPage(Category $category): void
    {
        $this->seoService->generate($category);
        $this->breadcrumbsService->pageLastCategory($category)->generate();

    }

    public function setProductPage(Product $product)
    {
        $this->seoService->generate($product);
        $this->breadcrumbsService->pageProduct($product)->generate();
        
        return $product;
    }

    public function setBrandCategoryPage(Category $category): void
    {
        match(true) {
            $category->isFirstLevel() => $this->setCategoryPage($category),
            $category->isSecondLevel() => $this->setSubCategoryPage($category),
            $category->isThirdLevel() => $this->setLastCategoryPage($category)
        };
    }
}

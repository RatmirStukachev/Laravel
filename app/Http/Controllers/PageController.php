<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use App\Mail\CallBackMail;
use App\Services\ItemService;
use App\Services\PageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\Support\TextService;
use App\Http\Requests\CallBackRequest;
use Symfony\Component\HttpFoundation\Response;

use function Illuminate\Support\defer;

class PageController extends Controller
{
    public function __construct(
        private PageService $pageService,
        private ItemService $itemService,
    ){}

    public function getContacts()
    {
        $page = $this->pageService->getPage('contacts');

        return view('contacts', compact('page'));
    }

    public function getPage($slug)
    {
        $page = $this->pageService->getPage($slug);

        return view('page', compact('page'));
    }

    public function getNews()
    {
        $page = $this->pageService->getPage('news-list');
        $news = $this->itemService->getNewsList();

        return view('news-list', compact('page', 'news'));
    }

    public function getOneNews(string $slug)
    {
        $page = $this->pageService->getPageOneNews($slug);

        return view('page', compact('page'));
    }

    public function sendCallback(CallBackRequest $request)
    {
        try {
            $data = $request->except('agree');

            FeedBack::create($data);

            $emails = TextService::getSettingValue('contacts', 'email_callback');

            $emails = array_filter(array_map('trim', explode(',', $emails)));

            if (! empty($emails)) {
                defer(function () use ($emails, $request) {
                    Mail::to($emails)->send(new CallBackMail($request));
                });
            }

            return response()->json(['message' => 'Запрос успешно отправлен'], Response::HTTP_OK);
        } catch (\Throwable $ex) {
              Log::info('ошибка отправки почты' . $ex->getMessage());
            return response()->json(['message' => 'Ошибка при отправке запроса'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

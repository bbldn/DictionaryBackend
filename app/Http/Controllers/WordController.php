<?php

namespace App\Http\Controllers;

use App\Services\WordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class WordController extends Controller
{
    /** @var WordService $wordService */
    protected $wordService;

    /**
     * WordController constructor.
     * @param WordService $wordService
     */
    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required', 'translation' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->wordService->add(
            $request->get('word'),
            $request->get('translation')
        );

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['translation' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->wordService->get(
            $request->get('translation')
        );

        return new JsonResponse($result);
    }

    /**
     * @return Response
     */
    public function getAllAction(): Response
    {
        $result = $this->wordService->getAll();

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getRandomAction(Request $request): Response
    {
        $previousWords = new Collection(explode(',', $request->get('previousWords')));
        $result = $this->wordService->getRandom($previousWords);

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addToArchiveAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->wordService->addToArchive(
            $request->input('word')
        );

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addAllWordsAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['json' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->wordService->addAllWords(
            $request->get('json')
        );

        return new JsonResponse($result);
    }
}

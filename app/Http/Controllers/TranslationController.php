<?php

namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TranslationController extends Controller
{
    /** @var TranslationService $translationService */
    protected $translationService;

    /**
     * TranslationController constructor.
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->translationService->get(
            $request->get('word')
        );

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getRandomAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required', 'limit' => 'required|numeric']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'error' => $e->getMessage()]);
        }

        $result = $this->translationService->getRandom(
            $request->get('word'),
            $request->get('limit')
        );

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function checkAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required', 'translation' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'error' => $e->getMessage()]);
        }

        $result = $this->translationService->check(
            $request->get('word'),
            $request->get('translation')
        );

        return new JsonResponse($result);
    }
}

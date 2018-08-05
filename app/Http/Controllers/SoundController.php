<?php

namespace App\Http\Controllers;

use App\Services\SoundService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SoundController extends Controller
{
    /** @var SoundService $soundService */
    protected $soundService;

    /**
     * SoundController constructor.
     * @param SoundService $soundService
     */
    public function __construct(SoundService $soundService)
    {
        $this->soundService = $soundService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required', 'sound' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->soundService->add(
            $request->get('word'),
            $request->file('sound')
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
            $this->validate($request->all(), ['word' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->soundService->get(
            $request->get('word')
        );

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function existAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'errors' => [$e->getMessage()]]);
        }

        $result = $this->soundService->exist(
            $request->get('word')
        );

        return new JsonResponse($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class StatisticsController extends Controller
{
    /** @var StatisticsService $statisticsService */
    protected $statisticsService;

    /**
     * StatisticsController constructor.
     * @param StatisticsService $statisticsService
     */
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function setAction(Request $request): Response
    {
        try {
            $this->validate($request->all(), ['word' => 'required', 'value' => 'required|numeric']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'error' => $e->getMessage()]);
        }

        $result = $this->statisticsService->set(
            $request->get('value'),
            $request->get('word')
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
            return new JsonResponse(['ok' => false, 'error' => $e->getMessage()]);
        }

        $result = $this->statisticsService->get(
            $request->get('word')
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
            $this->validate($request->all(), ['word' => 'required']);
        } catch (Throwable $e) {
            return new JsonResponse(['ok' => false, 'error' => $e->getMessage()]);
        }

        $result = $this->statisticsService->check(
            $request->get('word')
        );

        return new JsonResponse($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class GameController extends Controller
{
    /** @var GameService $gameService */
    protected $gameService;

    /**
     * GameController constructor.
     * @param GameService $gameService
     */
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function startAction(Request $request): Response
    {
        $previousWords = new Collection(explode(',', $request->get('previousWords')));

        /** @var int|null $limit */
        $limit = $request->get('limit');

        if (false === is_numeric($limit)) {
            $limit = 4;
        }

        $result = $this->gameService->start($previousWords, $limit);

        return new JsonResponse($result);
    }
}

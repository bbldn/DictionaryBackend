<?php

namespace App\Repositories;

use App\Word;
use Illuminate\Support\Collection;

/**
 * @method Word|null find(int $id)
 * @method Collection|Word[] findAll()
 */
class WordRepository extends Repository
{
    /**
     * WordRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Word::class);
    }

    /**
     * @return int
     */
    public function numberArchiveWord(): int
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->className::where('archive', 0)->count();
    }

    /**
     * @param string $word
     * @return Collection|Word[]
     */
    public function findByWord(string $word): Collection
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->className::where('word', $word)->get();
    }

    /**
     * @param string $word
     * @return Word|null
     */
    public function findOneByWord(string $word): ?Word
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->className::where('word', $word)->first();
    }
}
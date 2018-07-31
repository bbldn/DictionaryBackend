<?php

namespace App\Repositories;

use App\Translation;
use Illuminate\Support\Collection;

class TranslationRepository extends Repository
{
    /**
     * TranslationRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Translation::class);
    }

    /**
     * @param int $id
     * @return Collection|Translation[]
     */
    public function findOneByNotId(int $id): Collection
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->className::where('id', '!=', $id)->get();
    }

    /**
     * @param string $translation
     * @return Collection|Translation[]
     */
    public function findByTranslation(string $translation): Collection
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->className::where('translation', $translation)->get();
    }
}
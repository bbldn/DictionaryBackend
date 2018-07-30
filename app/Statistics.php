<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property int|null correctly
 * @property int|null word_id
 * @property Word|null word
 * @method static Statistics|null find(string $id)
 * @method static Collection all(array $columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Statistics create(array $attributes)
 */
class Statistics extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $table */
    protected $table = 'statistics';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable */
    protected $fillable = [
        'id',
        'correctly',
        'word_id',
    ];

    /**
     * @return HasOne
     */
    public function word(): HasOne
    {
        return $this->hasOne(Word::class, 'id', 'word_id');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int|null id
 * @property string|null path
 * @property int|null word_id
 * @property Word|null word
 * @method static Sound|null find(string $id)
 * @method static Collection all(array $columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Sound create(array $attributes)
 */
class Sound extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $table */
    protected $table = 'sounds';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable */
    protected $fillable = [
        'id',
        'path',
        'word_id'
    ];

    /**
     * @return HasOne
     */
    public function word(): HasOne
    {
        return $this->hasOne(Word::class, 'id', 'word_id');
    }
}
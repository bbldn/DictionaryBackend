<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int|null id
 * @property string|null translation
 * @property int|null word_id
 * @property Word|null word
 * @method static Translation|null find(string $id)
 * @method static Collection all(array $columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Translation create(array $attributes)
 */
class Translation extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $table */
    protected $table = 'translations';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable */
    protected $fillable = [
        'id',
        'translation',
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
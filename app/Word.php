<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null id
 * @property string|null word
 * @property int|null archive
 * @property Collection|Translation[] translations
 * @property Collection|Statistics[] statistics
 * @property Collection|Sound[] sounds
 * @method static Word|null find(string $id)
 * @method static Collection|Word[] all(array $columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Word create(array $attributes)
 */
class Word extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $table */
    protected $table = 'words';

    /** @var string $primaryKey */
    protected $primaryKey = 'id';

    /** @var array $fillable */
    protected $fillable = [
        'id',
        'word',
        'archive',
    ];

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'word_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function statistics(): HasMany
    {
        return $this->hasMany(Statistics::class, 'word_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function sounds(): HasMany
    {
        return $this->hasMany(Sound::class, 'word_id', 'id');
    }
}
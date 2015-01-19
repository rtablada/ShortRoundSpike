<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

{% if position %}
use Lookitsatravis\Listify\Listify;
{% endif %}
{% if attachments %}
use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
{% endif %}

class {{ modelUpper }} extends Model {% if attachments %}implements StaplerableInterface{% endif %}

{
    {% if position %}use Listify;{% endif %}

    {% if attachments %}use EloquentTrait;{% endif %}

    /**
     * {@inheritDoc}
     */
    protected $table = '{{ tableName }}';

    /**
     * {@inheritDoc}
     */
    protected $guarded = [
        'id',
    ];

    {% if position or attachments %}
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        {% if position %}static::bootListify();{% endif %}

        {% if attachments %}static::bootStapler();{% endif %}

    }

    public function __construct(array $attributes = [])
    {
        {% for attachment in attachments %}$this->hasAttachedFile('{{ attachment.name }}', [
            'styles' => [
            ]
        ]);
        {% endfor %}

        parent::__construct($attributes);

        {% if position %}$this->initListify();{% endif %}

    }
    {% endif %}

}

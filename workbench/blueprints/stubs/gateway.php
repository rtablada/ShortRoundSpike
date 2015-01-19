<?php namespace App\Gateways;

use App\Models\{{ modelUpper }};
use Illuminate\Contracts\Validation\Factory;

class Db{{ modelUpper }}Gateway
{
    {% if position %}
    use ActsAsList;
    {% endif %}

    /**
     * The Eloquent {{ modelVar }}.
     *
     * @var \App\Models\{{ modelUpper }}
     */
    protected ${{ modelVar }};

    /**
     * Constructor.
     *
     * @param \App\Models\{{ modelUpper }}|string ${{ modelVar }}
     */
    public function __construct({{ modelUpper }} ${{ modelVar }})
    {
        $this->{{ modelVar }} = ${{ modelVar }};
    }

    public function newInstance($attributes = [])
    {
        return $this->{{ modelVar }}->newInstance($attributes);
    }

    public function all()
    {
        return $this
            ->{{ modelVar }}
            ->newQuery()
            {% if position %}->orderBy('position', 'asc'){% endif %}

            ->get();
    }

    public function find($id)
    {
        return $this
            ->{{ modelVar }}
            ->where('id', (int)$id)
            ->first();
    }

    public function create(array $data)
    {
        with($client = $this->{{ modelVar }})->fill($data)->save();

        return $client;
    }

    public function update($id, array $data)
    {
        $client = $this->find($id);

        $client->fill($data)->save();

        return $client;
    }


    public function delete($id)
    {
        if ($client = $this->find($id)) {
            $client->delete();

            return true;
        }

        return false;
    }
}

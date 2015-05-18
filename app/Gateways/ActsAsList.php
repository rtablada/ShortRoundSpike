<?php  namespace App\Gateways;

trait ActsAsList
{

    public function moveHigher($id)
    {
        $model = $this->find($id);

        $model->moveHigher();
    }

    public function moveLower($id)
    {
        $model = $this->find($id);

        $model->moveLower();
    }
}

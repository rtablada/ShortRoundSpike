<?php namespace App\Gateways;


interface MenuGatewayInterface
{

    public function all();

    public function parentsOnly();

    public function childrenForSlug($slug);

    public function forSlug($slug);

}

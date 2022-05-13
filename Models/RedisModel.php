<?php

use Models\Interfaces\Model;
require 'vendor/autoload.php';

class RedisModel implements Model
{
    private Predis\Client $client;
    private Model $model;

    public function __construct(Model $model)
    {
//        var_dump('gh');
//        die();
        $this->client = new Predis\Client();
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $data = [];

        foreach ($this->model->fillable as $property) {
            $data[$property] = $this->model->$property;
        }

        return $data;
    }

    public function save()
    {
        foreach ($this->data() as $key => $value) {
            $this->client->hSet($this->model->table,$key,$value);
        }
    }

    public function get(){

        return $this->client->hgetall($this->model->table);
    }

    public function delete()
    {
        foreach ($this->model->fillable as $key) {
            $this->client->hdel($this->model->table,$key);
        }
    }
}
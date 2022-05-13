<?php
namespace Models;

class Post extends Model
{
    protected string $name;
//    public Predis\Client $client;

    public string $table = 'posts';
    public array $fillable = [
        'name'
    ];

//    public function get()
//    {
//        $asasa = $this->client;
//        var_dump($asasa);
//        die();
//    }

//    public function setName(string $name)
//    {
//        $this->name = $name;
//    }
}
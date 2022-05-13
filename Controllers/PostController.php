<?php
namespace Controllers;

namespace Models\Interfaces;

use Exception;
use Models\Post;

class PostController
{
    /**
     * @throws Exception
     */
    public function getAction(){


        $model = new Post();
        $result = $model->get();

        echo json_encode($result);
    }

    public function store()
    {
        $key = $_POST['key'];
        $value = $_POST['value'];

        $model = new Post();
        $model->fillable = [$key];
        $model->$key = $value;
        $model->save();

        header('Location: /');
    }

    public function delete($params){
        $key = $params['key'];

        $model = new Post();
        $model->fillable = [$key];
        $model->delete();

        header('Location: /');
    }
}
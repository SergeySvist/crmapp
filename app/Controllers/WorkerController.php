<?php

namespace App\Controllers;

use App\Models\Worker;
use Core\CookieManager;

class WorkerController
{
    public function index()
    {
        $sortVal = null;
        $sortDir = null;

        if(isset($_GET['field'])){
            $fields = json_decode($_COOKIE[COOKIE_FIELD],true);
            $sortVal = $_GET['field'];
            $sortDir = $fields[$sortVal];

            $fields[$sortVal]= !$fields[$sortVal];

            setcookie(COOKIE_FIELD, json_encode($fields), time() + COOKIE_LIFE_TIME, '/');
        }

        $workers = Worker::all($sortVal, $sortDir);
        $title = 'Workers list';
        $contentView = ROOT . '/app/views/workers/ListView.php';
        $authUser = CookieManager::$authUser;
        require_once ROOT . '/app/views/layouts/MainLayoutView.php';
    }

    public function get(int $id)
    {
        $worker = Worker::findOne(['id' => $id]);

        if ($worker) {
            header('Content-type: application/json');
            echo json_encode($worker);
        } else {
            http_response_code(404);
        }
    }

    public function update(int $id)
    {
        $worker = Worker::findOne(['id' => $id]);

        if (! $worker) {
            http_response_code(404);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $worker->setState($data)->update();


        http_response_code(203);
    }

    public function create()
    {

        $data = json_decode(file_get_contents('php://input'), true);

        // TODO: validation
        $id = Worker::create($data)->save();

        echo $id;
        http_response_code(201);
    }

    public function delete(int $id)
    {
        if (Worker::delete($id)){
            http_response_code(203);
        }
        else
            http_response_code(404);
    }
}

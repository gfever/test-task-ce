<?php
/**
 * @author d.ivaschenko
 */

namespace App\Controllers;


use App\Models\ModelInterface;
use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;
use App\Response;

class PrizeController
{
    private const AUTH_USER_ID = 1;

    /**
     * @return array
     */
    public function index(): array
    {
        return (new Response())->sendString(file_get_contents(__DIR__ . '/../../views/index.html'));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function get(): array
    {
        $id = $_REQUEST['id'];
        $type = $_REQUEST['type'];

        /** @var ModelInterface $model */
        $model = Repository::getRepositoryByType($type)->getOneBy('id', $id);

        return (new Response())->sendJson($model->getAttributes());
    }

    public function status()
    {
        $id = $_REQUEST['id'];
        $type = $_REQUEST['type'];
        $status = $_REQUEST['status'];

        /** @var RepositoryInterface $repository */
        $repository = Repository::getRepositoryByType($type);
        /** @var ModelInterface $model */
        $model = $repository->getOneBy('id', $id);
        $repository->updateStatus($model, $status);

        return (new Response())->sendJson($model->getAttributes());
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function random()
    {
        $types = ['bonus', 'cash', 'shipment'];
        shuffle($types);
        $type = array_shift($types);

        /** @var RepositoryInterface $repository */
        $repository = Repository::getRepositoryByType($type);

        $data['user_id'] = self::AUTH_USER_ID;
        if ($type !== 'shipment') {
            $data['amount'] = random_int(1, 100);
        } else {
            $data['name'] = 'Random shipment ' . random_int(100000, 10000000);
        }

        $data['status'] = 'suggested';
        $model = $repository->createNew($type, $data);

        return (new Response())->sendJson(['type' => $type, 'data' => $model->getAttributes()]);
    }
}
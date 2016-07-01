<?php


namespace Lchski;


use Lchski\Contracts\Controller;

class MainController extends BaseController implements Controller
{
    public function getShelves()
    {

    }

    public function getShelfBooks()
    {
        return $this->buildResponse(
            $this->callApi('review/list', [
                'v' => 2,
                'id' => $this->args['userId'],
                'shelf' => $this->args['shelfName'],
            ])
        );
    }
}

<?php


namespace Lchski;


use Lchski\Contracts\Controller;

class MainController extends BaseController implements Controller
{
    public function getShelves()
    {
        return $this->buildResponse(
            $this->callApi('shelf/list.xml', [
                'user_id' => $this->args['userId'],
            ])
        );
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

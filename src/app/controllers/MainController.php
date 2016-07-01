<?php


namespace Lchski;


use Lchski\Contracts\Controller;

class MainController extends BaseController implements Controller
{
    public function getShelfBooks()
    {
        return $this->buildResponse(
            $this->c->api->get('review/list',
                ['query' => array_merge($this->c->api->getConfig('query'), [
                    'v' => 2,
                    'id' => $this->args['userId'],
                    'shelf' => $this->args['shelfName'],
                ])]
            )
        );
    }
}

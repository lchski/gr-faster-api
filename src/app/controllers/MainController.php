<?php


namespace Lchski;


use Illuminate\Support\Collection;
use Lchski\Contracts\Controller;

class MainController extends BaseController implements Controller
{
    public function getShelves()
    {
        $data = $this->callApi('shelf/list.xml', [
            'user_id' => $this->args['userId'],
        ]);

        $dataCollection = collect($this->xmlResponseToArray($data)['GoodreadsResponse']['shelves']['user_shelf']);

        $processedData = $dataCollection->map(function ($item, $key) {
            return [
                'id' => $item['id']['$'],
                'name' => $item['name'],
                'book_count' => $item['book_count']['$'],
            ];
        });

        return $this->buildResponse($processedData);
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

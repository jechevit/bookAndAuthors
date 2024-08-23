<?php

namespace core\searchForms\redact;

use app\core\entities\catalog\Book;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class BookSearchForm extends Model
{
    public function search(array $params): ActiveDataProvider
    {
        $query = Book::find();

        $dataProvider = $this->getDataProvider($query);

        $this->load($params, '');
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    private function getDataProvider(ActiveQuery $query): ActiveDataProvider
    {
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
                'pageSizeParam' => 'onPage',
                'pageSizeLimit' => [50, 200]
            ]
        ]);

        return $provider;
    }
}
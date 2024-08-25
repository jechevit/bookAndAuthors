<?php

namespace core\searchForms\redact;

use app\core\entities\catalog\Author;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class AuthorSearchForm extends Model
{
    public $last_name;

    public function rules(): array
    {
        return [
            ['last_name', 'string'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Author::find();

        $dataProvider = $this->getDataProvider($query);

        $this->load($params, '');
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'last_name', $this->last_name]);

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
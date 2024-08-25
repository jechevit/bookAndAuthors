<?php

namespace app\core\searchForms;

use app\core\entities\catalog\Author;
use app\core\entities\catalog\Book;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class AuthorTopSearchForm extends Model
{
    public int | null $year = null;

    public function rules(): array
    {
        return [
            ['year', 'integer'],
            ['year', 'default', 'value' => Book::find()->select('year')->max('year')],
        ];
    }

    /**
     * @param array $params
     * @param array{} | array{
     *     'limit'? : int,
     * } $config
     * @return ActiveDataProvider|array
     * @throws \Exception
     */
    public function search(array $params, array $config = []): ActiveDataProvider|array
    {
        $limit = ArrayHelper::getValue($config, 'limit', 10);
        $authors = Author::find()
            ->select([
                'authors.*',
                'books_per_year' => new Expression('COUNT(books.id)'),
            ]);

        $this->load($params, '');

        $dataProvider = $this->getDataProvider($authors);
        if (!$this->validate()) {
            $authors->where('0=1');
            return $dataProvider;
        }

        $authors->joinWith('books')
            ->andFilterWhere(['year' => $this->year])
            ->orderBy([
                'books_per_year' => SORT_DESC,
                'authors.last_name' => SORT_ASC,
            ])
            ->groupBy('authors.id')
            ->limit($limit);

        return $dataProvider;
    }

    /**
     * @param ActiveQuery $authors
     * @return ActiveDataProvider
     */
    private function getDataProvider(ActiveQuery $authors): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $authors,
            'pagination' => false,
        ]);
    }

    /**
     * Массив всех годов создания книг
     * @return array
     */
    public static function getAllYears(): array
    {
        return Book::find()
            ->distinct()
            ->select('year')
            ->orderBy(['year' => SORT_DESC])
            ->indexBy('year')
            ->column();
    }
}
<?php

namespace app\modules\admin\models;

use app\models\AdvertisementPost;
use app\models\ImagesTrait;
use app\models\User;
use app\modules\admin\models\LinksExtension;
use yii\helpers\Url;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%categories}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $seo_text
 * @property string $link
 * @property int $parent_id
 * @property int $is_blog
 * @property string $options
 * @property string $updated_at
 * @property string $created_at
 */
class Categories extends \yii\db\ActiveRecord
{
    use LinksExtension;
    use ImagesTrait;

    private $catname = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description', 'seo_text', 'options'], 'string'],
            [['parent_id', 'is_blog'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['title', 'link'], 'string', 'max' => 255],
            ['link', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'seo_text' => Yii::t('app', 'Seo Text'),
            'link' => Yii::t('app', 'Link'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'is_blog' => Yii::t('app', 'Is Blog'),
            'options' => Yii::t('app', 'Options'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if(! empty($this->title) ) {
            $this->link = $this->generateLink($this->title);
        }

        return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
    }



    public function beforeValidate()
    {

        $this->link = $this->generateLink($this->title);

        if (! $this->is_blog ) {
            if(empty($this->parent_id)){
                $this->link = 'advertisement/'.$this->link;
            } else{
                $parent = ($this->find()->where(['id'=> $this->parent_id])->one())->link;
                $this->link = $parent.'/'.$this->link;
            }
        }

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }


    public function makeMenuList()
    {
        $menuList = [];
        $catList = $this->find()->asArray()->all();
//        $catList = ArrayHelper::index($catList, 'id');
        foreach ( $catList as $item) {
            $menuList[] = [
                'label' => $item['title'],
                'url' => Url::toRoute(['news/category/'. $item['link']])
            ];
        }
        return $menuList;
    }

    public function setCatName($id)
    {
        $this->catname = ($this->findOne(['id' => $id]))->title;
    }

    public function getCatName()
    {
        return $this->catname;
    }

    public function setCategory($id)
    {
        $this->category = ($this->findOne(['id' => $id]));
    }

    public function getCategory()
    {
        return (! empty($this->category)) ? $this->category : [];
    }

    public function getParentCatList()
    {
        return $this->find()->where(['parent_id' => $this->category->id])->all();
    }

    public function getAdvertisement()
    {
        $advert = ArrayHelper::map($this->find()->where(['is_blog' => 0])->andWhere(['parent_id'=>null])->all(),'id', 'title');
        return $advert;
    }

    public function getSubAdvertisement()
    {
        $sub = $this->find()->where(['is_blog' => 0])->andWhere(['not', ['parent_id' => null]])->all();
        $sub = ArrayHelper::map($sub,'id', 'title');

        return $sub;
    }

    public function setParent($id){
        $this->parent = $id;
    }

    public function getParents() {
        $sub = $this->find()->where(['is_blog' => 0])->andWhere(['parent_id' => $this->parent])->all();
        $sub = ArrayHelper::map($sub,'id', 'title');

        return $sub;
    }

    public function getChildren() {
        $sub = $this->find()->where(['is_blog' => 0])->andWhere(['id' => $this->parent])->all();
        $parent = $this->find()->andWhere(['id' => $sub[0]->parent_id]);

        return $parent;
    }

    public function getAdvList()
    {
        $advParents = $this->advertisement;
        $listArray = [];

        foreach ( $advParents as $item => $val) {
            $this->parent = $item;
            $arr = [
                'title' => $val,
                'subList' => $this->parents,
            ];
            $listArray[$item] = $arr;
        }

        return $listArray;
    }

    public function getAdvertisementCount()
    {
        $cat = $this->category;

        return (new AdvertisementPost())->find()->where(['subCat_id' => $cat->id])->count();
    }

    public function getTotalCount()
    {
        $cat = $this->category;

        return (new AdvertisementPost())->find()->where(['category_id' => $cat->id])->count();
    }
    
    public function catByUser($id)
    {
        $user = User::findOne($id);
        $parents = [];
        $catList = (new AdvertisementPost())
            ->find()
            ->select('`category_id`')
            ->where(['authorId' => $id])
            ->groupBy('category_id')
            ->asArray()
            ->all();

        $i = 0;

        foreach ($catList as $cat) {
            $parents[] = $cat['category_id'];
        }

        $parentsData = $this
            ->find()
            ->where(['is_blog' => 0])
            ->andWhere(['in', 'id', $parents])
            ->all();
        $parentsData = ArrayHelper::map($parentsData, 'id', 'title');

        $parents = [];

        foreach ($parentsData as $item => $title) {
            $parents[$item]['title'] = $title;
        }

        if(! empty($catList)) {
            foreach ($catList as $item) {
                $subList  = (new AdvertisementPost())
                    ->find()
                    ->select('subCat_id')
                    ->where(['authorId' => $id])
                    ->andWhere(['category_id' => $item['category_id']])
                    ->groupBy('subCat_id')
                    ->asArray()
                    ->all();
                $sub = [];
                foreach ($subList as $subItem) {
                    $subData = $this
                        ->find()
                        ->where(['is_blog' => 0])
                        ->andWhere(['in', 'id', $subItem['subCat_id']])
                        ->all();

                    $res = ArrayHelper::map($subData, 'id', 'title');

                    foreach ( $res as $key => $val) {
                        $sub[$key] = $val;
                    }

                }

                $parents[$item['category_id']]['subList'] = $sub;
                $i++;
            }


            return $parents;
        }

        return false;
    }
    
    public function countUserCat($id, $user_id)
    {
        return (new AdvertisementPost())
            ->find()
            ->where(['subCat_id' => $id])
            ->andWhere(['authorId' => $user_id])
            ->count();
    }
}

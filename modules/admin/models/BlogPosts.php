<?php

namespace app\modules\admin\models;

use app\models\ImagesTrait;
use Yii;
use app\modules\admin\models\LinksExtension;
use app\modules\admin\models\BlogImageUpload;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%blog_posts}}".
 *
 * @property int $id
 * @property string $title
 * @property string $uk_title
 * @property string $description
 * @property string $uk_description
 * @property string $link
 * @property int $category_id
 * @property string $post_thumbnail
 * @property string $post_image
 * @property int $author_id
 * @property string $seo_title
 * @property string $uk_seo_title
 * @property string $seo_text
 * @property string $uk_seo_text
 * @property string $options
 * @property string $translation
 * @property string $updated_at
 * @property string $created_at
 */
class BlogPosts extends \yii\db\ActiveRecord
{
    use LinksExtension;
    use ImagesTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%blog_posts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'seo_text', 'options', 'translation'], 'string'],
            [['link', 'author_id'], 'required'],
            [['category_id', 'author_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['post_image', 'post_thumbnail'], 'image', 'skipOnEmpty' => true],

            [['title', 'link', 'seo_title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Заголовок'),
            'description' => Yii::t('app', 'Описание'),
            'link' => Yii::t('app', 'Ссылка'),
            'category_id' => Yii::t('app', 'Категория'),
            'post_thumbnail' => Yii::t('app', 'Миниатюра изображения'),
            'post_image' => Yii::t('app', 'Картинка'),
            'author_id' => Yii::t('app', 'Author ID'),
            'seo_title' => Yii::t('app', 'SEO-заголовок'),
            'seo_text' => Yii::t('app', 'SEO Текст'),
            'options' => Yii::t('app', 'Контент'),
            'translation' => Yii::t('app', 'Перевод'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return BlogPostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogPostsQuery(get_called_class());
    }

    public function beforeValidate()
    {
        $this->link = $this->generateLink($this->title);
        $this->author_id = Yii::$app->user->getId();
        $this->options = (! empty($this->options) )? json_encode($this->options) :'';
        $this->translation = (! empty($this->translation) )? json_encode($this->translation) :'';

        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {

        $image = new BlogImageUpload();
        $post = Yii::createObject(BlogPosts::className())->find()->where(['id' => $this->id])->one();


        $file = UploadedFile::getInstance($this, 'post_image');

        if(! empty( $file ) ) {
            if (! empty($post)) {
                $savedImage = $image->uploadImage($file, $post->post_image);
                $image->deleteCurrentImage($post->post_thumbnail);
                $image->deleteCurrentImage($post->post_image);
            } else {
                $savedImage = $image->uploadImage($file, '');
            }

            $this->post_image = $savedImage['image'];
            $this->post_thumbnail = $savedImage['thumbnails'];
        } else {
            $this->post_image = $post->post_image;
            $this->post_thumbnail = $post->post_thumbnail;
        }

        if(! empty($this->post_image)) {
            return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
        }
    }

    public function delete()
    {
        if (! empty($this->post_image)) {
            $image = new BlogImageUpload();
            $image->deleteCurrentImage($this->post_image);
        }
        return parent::delete(); // TODO: Change the autogenerated stub
    }


    public function setCategory($id)
    {
        $this->category = $id;
    }

    public function getPostsByCat()
    {
        return $this->find(['category_id' => $this->category])->limit(3)
            ->all();
    }
}

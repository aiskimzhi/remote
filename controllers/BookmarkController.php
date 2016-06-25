<?php
namespace app\controllers;
use app\models\Advert;
use app\models\Category;
use app\models\Currency;
use app\models\Region;
use Yii;
use app\models\Bookmark;
use app\models\BookmarkSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * BookmarkController implements the CRUD actions for Bookmark model.
 */
class BookmarkController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['add-to-bookmarks', 'my-bookmarks', 'delete'],
                'rules' => [
                    [
                        'actions' => ['add-to-bookmarks', 'my-bookmarks', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Deletes an existing Bookmark model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['my-bookmarks']);
    }
    /**
     * Finds the Bookmark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bookmark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bookmark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * adds the advert to bookmarks
     *
     * @param $id
     * @throws \Exception
     */
    public function actionAddToBookmarks($id)
    {
        $bookmark = new Bookmark();
        $bookmarkInDB = Bookmark::find()->where([
            'user_id' => Yii::$app->user->identity->getId(),
            'advert_id' => $id
        ])->one();
        if (!empty($bookmarkInDB)) {
            $bookmarkInDB->delete();
            echo 'Add to bookmarks';
        } else {
            $bookmark->user_id = Yii::$app->user->identity->getId();
            $bookmark->advert_id = $id;
            $bookmark->save();
            echo 'Delete ' . 'from bookmarks';
        }
    }
    /**
     * Shows adverts in bookmarks for a certain user
     *
     * @return string
     */
    public function actionMyBookmarks()
    {
        if (Currency::find()->where(['>', 'date', time()])->orderBy(['date' => SORT_DESC])
                ->asArray()->one() == null) {

            if (Currency::currentExchangeRates()) {
                Yii::$app->session->setFlash('warning', 'Exchange rates might differ from actual ones');
            }
        }

        $searchModel = new BookmarkSearch();
        $dataProvider = $searchModel->getMyBookmarks();

        return $this->render('my-bookmarks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
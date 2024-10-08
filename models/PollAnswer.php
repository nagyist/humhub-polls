<?php

namespace humhub\modules\polls\models;

use humhub\components\ActiveRecord;

/**
 * This is the model class for table "poll_answer".
 *
 * The followings are the available columns in table 'poll_answer':
 * @property int $id
 * @property int $poll_id
 * @property string $answer
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property-read Poll $poll
 * @property-read PollAnswerUser[] $votes
 *
 * @package humhub.modules.polls.models
 * @since 0.5
 * @author Luke
 */
class PollAnswer extends ActiveRecord
{
    public $active = true;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'poll_answer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['poll_id', 'answer'], 'required'],
            [['poll_id'], 'integer'],
            [['answer'], 'string', 'max' => 255],
        ];
    }

    public function getPoll()
    {
        return $this->hasOne(Poll::className(), ['id' => 'poll_id']);
    }

    public function getVotes()
    {
        $query = $this->hasMany(PollAnswerUser::className(), ['poll_answer_id' => 'id']);
        return $query;
    }

    public function beforeDelete()
    {
        foreach ($this->votes as $answerUser) {
            $answerUser->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * Returns the percentage of users voted for this answer
     *
     * @return int
     */
    public function getPercent()
    {
        $total = PollAnswerUser::find()->where(['poll_id' => $this->poll_id])->count();
        if ($total == 0) {
            return 0;
        }

        return $this->getTotal() / $total * 100;
    }

    /**
     * Returns the total number of users voted for this answer
     *
     * @return int
     */
    public function getTotal()
    {

        return PollAnswerUser::find()->where(['poll_answer_id' => $this->id])->count();
    }

    public static function filterValidAnswers($answerArr)
    {
        if (empty($answerArr)) {
            return [];
        }

        $result = [];
        foreach ($answerArr as $key => $answerText) {
            if ($answerText != null && $answerText !== '') {
                $result[$key] = $answerText;
            }
        }
        return $result;
    }
}

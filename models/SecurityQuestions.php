<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "security_questions".
 *
 * @property int $id
 * @property string $question
 *
 * @property UserSecurityQuestions[] $userSecurityQuestions
 * @property UserSecurityQuestions[] $userSecurityQuestions0
 * @property UserSecurityQuestions[] $userSecurityQuestions1
 */
class SecurityQuestions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'security_questions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
        ];
    }

    /**
     * Gets query for [[UserSecurityQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSecurityQuestions()
    {
        return $this->hasMany(UserSecurityQuestions::class, ['question1_id' => 'id']);
    }

    /**
     * Gets query for [[UserSecurityQuestions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSecurityQuestions0()
    {
        return $this->hasMany(UserSecurityQuestions::class, ['question2_id' => 'id']);
    }

    /**
     * Gets query for [[UserSecurityQuestions1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSecurityQuestions1()
    {
        return $this->hasMany(UserSecurityQuestions::class, ['question3_id' => 'id']);
    }
}

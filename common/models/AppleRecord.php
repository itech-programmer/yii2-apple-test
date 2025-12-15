<?php

namespace common\models;

use yii\db\ActiveRecord;

final class AppleRecord extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%apple}}';
    }

    public function rules(): array
    {
        return [
            [['color', 'status', 'created_at_unix'], 'required'],
            [['status', 'created_at_unix', 'fell_at_unix'], 'integer'],
            [['eaten_percent'], 'number', 'min' => 0, 'max' => 100],
            [['color'], 'string', 'max' => 20],
        ];
    }
}

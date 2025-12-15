<?php

namespace common\repositories\Apple;

use common\contracts\Apple\AppleRepositoryInterface;
use common\domain\Apple\Apple;
use common\models\AppleRecord;
use RuntimeException;

final class AppleRepository implements AppleRepositoryInterface
{
    public function allWithIds(): array
    {
        $rows = AppleRecord::find()->orderBy(['id' => SORT_DESC])->all();

        $result = [];
        foreach ($rows as $record) {
            $result[(int)$record->id] = $this->toDomain($record);
        }

        return $result;
    }

    public function getById(int $id): Apple
    {
        $record = AppleRecord::findOne($id);
        if ($record === null) {
            throw new RuntimeException("Apple not found: {$id}");
        }
        return $this->toDomain($record);
    }

    public function save(int $id, Apple $apple): void
    {
        $record = AppleRecord::findOne($id);
        if ($record === null) {
            throw new RuntimeException("Apple not found: {$id}");
        }

        $this->fillRecord($record, $apple);

        if (!$record->save()) {
            throw new RuntimeException('Failed to save apple: ' . json_encode($record->errors));
        }
    }

    public function insert(Apple $apple): int
    {
        $record = new AppleRecord();
        $this->fillRecord($record, $apple);

        if (!$record->save()) {
            throw new RuntimeException('Failed to insert apple: ' . json_encode($record->errors));
        }

        return (int)$record->id;
    }

    public function delete(int $id): void
    {
        AppleRecord::deleteAll(['id' => $id]);
    }

    private function toDomain(AppleRecord $record): Apple
    {
        return new Apple(
            color: (string)$record->color,
            status: (int)$record->status,
            createdAtUnix: (int)$record->created_at_unix,
            fellAtUnix: $record->fell_at_unix === null ? null : (int)$record->fell_at_unix,
            eatenPercent: (float)$record->eaten_percent
        );
    }

    private function fillRecord(AppleRecord $record, Apple $apple): void
    {
        $record->color = $apple->color();
        $record->status = $apple->status();
        $record->created_at_unix = $apple->createdAtUnix();
        $record->fell_at_unix = $apple->fellAtUnix();
        $record->eaten_percent = $apple->eatenPercent();
    }
}
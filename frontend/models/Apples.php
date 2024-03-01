<?php

namespace frontend\models;

use common\constants\Colors;
use common\constants\Statuses;
use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string|null $color
 * @property string|null $created_at
 * @property string|null $fell_at
 * @property int|null $status
 * @property float|null $percent_eaten
 */
class Apples extends \yii\db\ActiveRecord
{
    public function isRotten()
    {
        return $this->fell_at && strtotime("now") - strtotime($this->fell_at) > 5 * 60 * 60;
    }

    public function isOnTree()
    {
        return $this->status === Statuses::ON_TREE;
    }

    public function isEatable()
    {
        return !$this->isOnTree() && !$this->isRotten();
    }

    public function getIcon() {
        return $this->color === Colors::GREEN ? '🍏' : '🍎';
    }

    public function getAppleStatus()
    {
        return $this->status === Statuses::ON_TREE ? 'on tree' : ($this->isRotten() ? 'rotten' : 'on ground');
    }

    public function getFellAt()
    {
        $hours = (strtotime("now") - strtotime($this->fell_at)) / (60 * 60);
        return $this->fell_at ? $this->fell_at . " (" . round($hours, 2) . " hours ago)" : null;
    }

    public function getSize()
    {
        return (100 - $this->percent_eaten) / 100;
    }

    public function createApples()
    {
        Apples::deleteAll();

        $appleCount = random_int(5, 15);
        $now = strtotime('now');
        $rows = [];

        for ($i = 0; $i < $appleCount; $i++) {
            $color = rand(0,1000) / 1000 > 0.5 ? Colors::RED : Colors::GREEN;
            $created_at = date('Y-m-d H:i:s', random_int(0, $now));

            $row = [$color, $created_at, null, 1, 0];
            $rows[] = $row;
        }

        $query = Yii::$app->db->createCommand()->batchInsert(
            self::tableName(),
            ['color', 'created_at', 'fell_at', 'status', 'percent_eaten'],
            $rows
        );

        return $query->execute();
    }

    public function fall()
    {
        if ($this->isOnTree()) {
            $this->fell_at = date('Y-m-d H:i:s');
            $this->status = Statuses::ON_GROUND;
            return $this->save();
        } else {
            throw new \Exception('Apple already fallen');
        }
    }

    public function eat($percent)
    {
        if ($this->isEatable() && $percent <= (100 - $this->percent_eaten)) {
            $this->percent_eaten += $percent;

            if ($this->percent_eaten < 100) {
                return $this->save();
            } else {
                return $this->delete();
            }
        } else {
            throw new \Exception('Can\'t eat this apple');
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'fell_at'], 'safe'],
            [['status'], 'integer'],
            [['percent_eaten'], 'number'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'created_at' => 'Created At',
            'fell_at' => 'Fell At',
            'status' => 'Status',
            'percent_eaten' => 'Percent Eaten',
        ];
    }
}

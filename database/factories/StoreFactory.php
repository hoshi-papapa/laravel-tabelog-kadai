<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    protected $model = Store::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company, // 店の名前
            'address' => $this->faker->address, // 住所
            'phone_number' => $this->faker->phoneNumber, // 電話番号
            'email' => $this->faker->unique()->safeEmail, // メールアドレス
            'business_hours' => $this->generateJapaneseBusinessHours(), // 営業日・営業時間
            'description' => $this->generateJapaneseDescription(), // 説明
        ];
    }

    private function generateJapaneseBusinessHours()
    {
        return '月～金: 9:00 - 18:00, 土: 10:00 - 16:00';
    }

    /**
     * Generate a Japanese description string.
     *
     * @return string
     */
    private function generateJapaneseDescription()
    {
        return '駅に近く、満足度も高いです。接待にご利用ください。大人数でのご予約も受け付けております。';
    }
}

<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContactFactory extends Factory
{
    protected $model = Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 性別をランダムに選択
        $gender = $this->faker->randomElement([1, 2, 3]);

        // 性別に基づいて名前を設定
        if ($gender === 1) {
            $firstName = $this->faker->firstNameMale;
        } elseif ($gender === 2) {
            $firstName = $this->faker->firstNameFemale;
        } else {
        $firstName = $this->faker->firstName; // その他の場合は性別に依存しない名前を使用
    }

    $lastName = $this->faker->lastName;
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'email' => $this->faker->unique()->safeEmail,
            'tel' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'building' => $this->faker->buildingNumber,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'detail' => $this->faker->text,
        ];
    }
}

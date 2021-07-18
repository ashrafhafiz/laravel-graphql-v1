<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIDs = User::all()->pluck('id')->toArray();
        return [
            // 'user_id' => rand(1, 10),
            // 'title' => $this->faker->title(),
            // 'title' => $this->faker->name(),
            'user_id' => $this->faker->randomElement($userIDs),
            'title' => $this->faker->realText(25),
            'comment' => $this->faker->realText(180)
        ];
    }
}

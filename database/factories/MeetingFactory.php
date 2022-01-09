<?php

namespace Database\Factories;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->title,
            'location'=>$this->faker->address(),
            'status'=>$this->faker->randomElement([1,2,3,4,5]),
            'doc'=>$this->faker->randomElement,
            'time'=>$this->faker->time('H:i:s','now'),
        ];
    }

    public function add_to_meeting_table()
    {
        $meeting = meeting::factory()->hasAttached(User::factory()->count(2),['user_id'=>true])->count(2)->create();
    }
}

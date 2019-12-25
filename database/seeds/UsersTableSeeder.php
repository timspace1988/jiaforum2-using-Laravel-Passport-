<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Avatar fake data
        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        //Get a instance of Faker
        $faker = app(Faker\Generator::class);

        //Generate fake data set
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user, $index) use ($faker, $avatars)
                                {
                                    //Give each user a random avatar, this can also be done in UserFactory
                                    $user->avatar = $faker->randomElement($avatars);
                                });

        //Make hidden properties visible and put transfered into an array
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        //Insert fake data into database
        User::insert($user_array);

        //Make some change on first user
        $user = User::find(1);
        $user->name = 'JIA';
        $user->email = 'timspace1988@hotmail.com';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();
    }
}

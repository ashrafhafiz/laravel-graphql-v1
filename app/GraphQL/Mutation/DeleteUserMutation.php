<?php

// file name:  App\GraphQL\Mutation\DeleteUserMutation.php

namespace App\GraphQL\Mutation;

use App\Models\User;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteUser',
        'description' => 'Deletes a user'
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::int(),
            ],
            'name' => [
                'name' => 'name',
                'type' =>  Type::string(),
            ],
            'email' => [
                'name' => 'email',
                'type' =>  Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {

        if (isset($args['id'])) {
            $user = User::whereId($args['id'])->get()->first();
        }

        if (isset($args['name'])) {
            $user =  User::whereName($args['name'])->get()->first();
        }

        if (isset($args['email'])) {
            $user =  User::whereEmail($args['email'])->get()->first();
        }
        if (!$user) {
            return null;
        }
        $user->delete();
        return $user;
    }
}

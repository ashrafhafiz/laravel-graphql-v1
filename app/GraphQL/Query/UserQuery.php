<?php

namespace App\GraphQL\Query;

use Closure;
use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                // 'rules' => ['required'],
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                // 'rules' => ['required'],
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                // 'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::whereId($args['id'])->get()->first();
        }

        if (isset($args['name'])) {
            return User::whereName($args['name'])->get()->first();
        }

        if (isset($args['email'])) {
            return User::whereEmail($args['email'])->get()->first();
        }
    }
}

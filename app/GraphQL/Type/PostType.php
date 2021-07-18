<?php

namespace App\GraphQL\Type;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Post',
        'description'   => 'A post',
        'model'         => Post::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the post',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of post',
            ],
            'comment' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The comment of post',
            ],
            'user' => [
                'type' => Type::nonNull(GraphQL::type('User')),
                'description' => 'The owner of post',
            ],
        ];
    }
}

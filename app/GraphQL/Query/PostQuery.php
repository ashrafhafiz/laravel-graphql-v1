<?php

namespace App\GraphQL\Query;

use Closure;
use App\Models\Post;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class PostQuery extends Query
{
    protected $attributes = [
        'name' => 'post',
    ];

    public function type(): Type
    {
        return Type::nonNull(GraphQL::type('Post'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                // 'rules' => ['required']
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                // 'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Post::whereId($args['id'])->get()->first();
        }

        if (isset($args['title'])) {
            return Post::whereTitle($args['title'])->get()->first();
        }
        // return Post::findOrFail($args['id']);
    }
}

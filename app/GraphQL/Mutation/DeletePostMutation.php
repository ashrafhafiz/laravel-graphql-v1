<?php

// file name:  App\GraphQL\Mutation\DeletePostMutation.php

namespace App\GraphQL\Mutation;

use App\Models\Post;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class DeletePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deletePost',
        'description' => 'Deletes a post'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' =>  Type::int(),
            ],
            'title' => [
                'name' => 'title',
                'type' =>  Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            $post = Post::whereId($args['id'])->get()->first();
        }

        if (isset($args['title'])) {
            $post =  Post::whereName($args['title'])->get()->first();
        }

        $post->delete();
        return $post;
    }
}

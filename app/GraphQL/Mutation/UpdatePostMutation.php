<?php

// file name:  App\GraphQL\Mutation\CreatePostMutation.php

namespace App\GraphQL\Mutation;

use App\Models\Post;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class UpdatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updatePost',
        'description' => 'Updates a post'
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
            'comment' => [
                'name' => 'comment',
                'type' =>  Type::string(),
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $post = Post::findOrFail($args['id']);

        $post->fill($args);
        $post->save();
        return $post;
    }
}

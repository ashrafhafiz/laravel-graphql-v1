<?php

// file name:  App\GraphQL\Mutation\CreatePostMutation.php

namespace App\GraphQL\Mutation;

use App\Models\Post;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;

class CreatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createPost',
        'description' => 'Creates a post'
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'name' => 'user_id',
                'type' =>  Type::int(),
                'rules' => ['exists:users,id']
            ],
            'title' => [
                'name' => 'title',
                'type' =>  Type::string(),
                'rules' => ['required']
            ],
            'comment' => [
                'name' => 'comment',
                'type' =>  Type::string(),
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $post = new Post();
        $post->fill($args);
        $post->save();

        return $post;
    }
}

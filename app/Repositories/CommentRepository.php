<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 10/28/2020
 * Time: 9:59 PM
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
    public function store(array  $attributes, $model)
    {
        $comment = new Comment([
            'user_id' => $attributes['user_id'],
            'comment' => $attributes['comment'],
        ]);
        return $model->comments()->save($comment);
    }
}
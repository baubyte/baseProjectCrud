<?php


class Post
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getPosts()
    {
        $this->db->query('SELECT p.id AS post_id, p.user_id, u.name, u.email, p.title, p.body, p.created_at 
                                 FROM posts p 
                                 LEFT JOIN users u ON u.id = p.user_id 
                                 ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    public function getPostById($id)
    {
        $this->db->query('SELECT * FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPostByUserId($user_id)
    {
        $this->db->query('SELECT COUNT(*) as total FROM posts WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (user_id, title, body) VALUES (:user_id, :title, :body)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

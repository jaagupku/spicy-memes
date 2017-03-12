<?php

class Comment_model extends Base_Model {

    public function add($meme_id, $user_id, $message) {
        return $this->_call_procedure('sp_add_comment', array($meme_id, $user_id, $message));
    }

    public function vote($comment_id, $user_id, $vote) {
        return $this->_call_procedure('sp_vote_comment', array($comment_id, $user_id, $vote));
    }
}
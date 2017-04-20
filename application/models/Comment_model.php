<?php

class Comment_model extends Base_Model {
    public function add($meme_id, $user_id, $message) {
        return $this->_call_procedure('sp_add_comment', array($meme_id, $user_id, $message));
    }

    public function vote($comment_id, $user_id, $vote) {
        return $this->_call_procedure('sp_vote_comment', array($comment_id, $user_id, $vote));
    }

    public function delete_vote($comment_id, $user_id) {
        $this->db->where('Comment_Id', $comment_id);
        $this->db->where('User_Id', $user_id);
        $this->db->delete('commentpoints');
    }

    public function get_votes($comment_ids, $user_id) {
        $this->db->from('commentpoints');
        $this->db->select('*');
        $this->db->where('User_Id', $user_id);
        $this->db->where_in('Comment_Id', $comment_ids);

        return $this->db->get()->result();
    }

    public function retrieve($id) {
        $this->db->from('comments');
        $this->db->where('Id', $id);

        return $this->db->get()->row_array();
    }

    public function delete($commentid) {
      $this->db->where('Id', $commentid);
      $this->db->delete('comments');
    }
}

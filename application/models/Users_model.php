<?php
class Users_model extends CI_Model{

  public function can_log_in(){
    $this->db->where('user_email',$this->input->post('email'));
    $this->db->where('user_pass',md5($this->input->post('password')));
    $query = $this->db->get('user');

    if($query->num_rows() == 1){
      return true;
    }else{
      return false;
    }

  }

  public function add_temp_users($key){
    $data = array(
      'user_email' => $this->input->post('email'),
      'user_pass' => md5($this->input->post('password')),
      'key' => $key
      );

    $query = $this->db->insert('temp_user',$data);

    if($query){
      return true;
    }else{
      return false;
    }
  }

  public function is_valid_key($key){
    $this->db->where('key',$key);
    $query = $this->db->get('temp_user');

    if($query->num_rows() == 1){
      return true;
    }else{
      return false;
    }
  }

  public function add_user($key){
    $this->db->where('key', $key);
    $temp_user = $this->db->get('temp_user');

    if($temp_user){
      $row = $temp_user->row();

      $data = array(
        'user_email' => $row->user_email,
        'user_pass' => $row->user_pass
        );

      $did_add_user = $this->db->insert("user", $data);
    }

    if($did_add_user){
      $this->db->where('key', $key);
      $this->db->delete('temp_user');
      return $data['user_email'];
    }else{
      return false;
    }
  }


}



<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api_model extends CI_Model {

	private $bss = false;

	function __construct()
	{
		parent::__construct();

			$this->bss = $this->load->database();

	}
    
	function createTable($data){
        if($this->db->insert('mesas', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

    function deleteTable($id){
		$this->db->where('id', $id);
		if($this->db->delete('mesas') && $this->db->affected_rows() > 0){
            return TRUE;
		}else{
			return FALSE;
		}
	}

    function selectReservation($fecha){

		$sql_get_reservation = "SELECT m.id FROM mesas m JOIN reservas r ON m.id = r.id_mesa WHERE r.fecha = '" . $fecha . "'";
		$query = $this->db->query($sql_get_reservation);
		
		return $query->result();
	}


    function checkAvailability($reservations, $personas){

		$this->db->select('m.nombre');
		$this->db->from('mesas m');
		$this->db->where('m.capacidad_minima <=', $personas);
		$this->db->where('m.capacidad_maxima >=', $personas);
		$this->db->where_not_in('m.id', $reservations);
		$query = $this->db->get();

		return $query->result();
	}

	function createReservation($data){
        if($this->db->insert('reservas', $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}


    function deleteReservation($id_reserva){
		$this->db->where('id_reserva', $id_reserva);
		if($this->db->delete('reservas') && $this->db->affected_rows() > 0){
            return TRUE;
		}else{
			return FALSE;
		}
	}
    
}
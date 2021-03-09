<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model(array('api_model'));
	}

	public function index()
	{
		$this->load->view('index.php');
	}

	public function createTable()
	{

		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		$capacidad_minima = $this->input->post('capacidad_minima');
		$capacidad_maxima = $this->input->post('capacidad_maxima');

		$this->form_validation->set_rules('id', 'id', 'required|numeric');
      	$this->form_validation->set_rules('nombre', 'nombre', 'required');
      	$this->form_validation->set_rules('capacidad_minima', 'capacidad_minima', 'required|numeric|greater_than[0]'); 
		$this->form_validation->set_rules('capacidad_maxima', 'capacidad_maxima', 'required|numeric|greater_than[0]'); 


		//Verifica que el formulario esté validado.
		if ($this->form_validation->run() == TRUE && $capacidad_maxima > $capacidad_minima){

				$data = array(				
					"id" => $id,
					"nombre" => $nombre,
					"capacidad_minima" => $capacidad_minima,
					"capacidad_maxima" => $capacidad_maxima
				);

				$createTable = $this->api_model->createTable($data);

				if($createTable){
					echo "Su mesa ha sido creada correctamente";
				}else{
					echo "Ya existe una mesa con ese identificador";
				}

		}else{
				echo "Los datos introducidos no son validos";
		}

	}

	public function createReservation()
	{

		$id_mesa = $this->input->post('id_mesa');
		$personas = $this->input->post('personas');
		$cliente = $this->input->post('cliente');
		$fecha = $this->input->post('fecha');

		$this->form_validation->set_rules('id_mesa', 'id_mesa', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('personas', 'personas', 'required|numeric|greater_than[0]'); 
		$this->form_validation->set_rules('cliente', 'cliente', 'required'); 
      	$this->form_validation->set_rules('fecha', 'fecha', 'required|callback_checkFormatDate');

		//Verifica que el formulario esté validado.
		if ($this->form_validation->run() == TRUE){

				$fechaFormat = date('Y-m-d', strtotime($fecha));
				$identificador = $id_mesa."-".strtotime($fechaFormat);

				$data = array(			
					"id_reserva" => $identificador,	
					"id_mesa" => $id_mesa,
					"personas" => $personas,
					"cliente" => $cliente,
					"fecha" => $fechaFormat
				);

				$createReservation = $this->api_model->createReservation($data);

				if($createReservation){
					echo "Su reserva ha sido creada correctamente. El identificador de su reserva es: ".$identificador;
				}else{
					echo "Ya existe una reserva para ese día y mesa.";
				}

		}else{
				echo "Los datos introducidos no son validos";
		}

	}


	public function deleteTable()
	{

		$id = $this->input->post('id');
		$this->form_validation->set_rules('id', 'id', 'required|numeric');

		if ($this->form_validation->run() == TRUE){
			$deleteTable = $this->api_model->deleteTable($id);

			if($deleteTable){
				echo "Su mesa ha sido eliminada correctamente";
			}else{
				echo "La mesa que intenta eliminar no existe";
			}
		}else{
			echo "Debe introducir el identificador de la mesa para proceder a eliminar la reserva";
		}

	}

	// REVISAR DESDE AQUI

	public function checkAvailability()
	{

		$fecha = $this->input->post('fecha');
		$personas = $this->input->post('personas');

		$this->form_validation->set_rules('fecha','fecha','required|callback_checkFormatDate');
		$this->form_validation->set_rules('personas', 'personas', 'required|numeric|greater_than[0]');

		if ($this->form_validation->run() == TRUE){

			$fechaFormat = date('Y-m-d', strtotime($fecha)); //Formateamos fecha para guardarla en base de datos
			$selectReservation = $this->api_model->selectReservation($fechaFormat); //Buscamos las reservas de ese día
			$i=0;
			$x=0;
			$reservations[]="0";

			foreach ($selectReservation as $row)
			{
				$reservations[]= $row->id; //Guardamos las reservas del día en un array
				$i++;
			}

			$checkAvailability = $this->api_model->checkAvailability($reservations, $personas); //Seleccionamos las mesas disponibles

			if($checkAvailability){
				
				foreach ($checkAvailability as $row)
				{
					$result[]= $row->nombre; //Guardamos las mesas disponibles en un array
					$x++;
				}
				echo print_r($result, true);

			}else{
				echo "No hay mesas disponibles para esa fecha";
			}

		}else{
			echo 'Los datos introducidos no son validos. Recuerda que debes introducir la fecha con formato "dd-mm-yyyy"';
		}

	}

	function checkFormatDate($fecha)
	{

		$fecha_actual = strtotime(date("d-m-Y"));
		$fecha_entrada = strtotime($fecha);

		if (date('d-m-Y', strtotime($fecha)) == $fecha && $fecha_entrada >= $fecha_actual) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	}

	public function deleteReservation()
	{

		$identificador = $this->input->post('identificador');
		$this->form_validation->set_rules('identificador', 'identificador', 'required');

		if ($this->form_validation->run() == TRUE){
			$deleteReservation = $this->api_model->deleteReservation($identificador);

			if($deleteReservation){
				echo "Su reserva ha sido eliminada correctamente";
			}else{
				echo "La reserva que intenta eliminar no existe";
			}
	
		}else{
			echo "Debe introducir el identificador de reserva para proceder a eliminar la reserva";
		}

	}
}

<?php

use app\Auth;
use Carbon\Carbon;

class Account extends Controller {

	public function __construct() {
		$this->auth = $this->auth();
	}

	public function validateEmail() 
		{

			$is_valid = !User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);
			header('Content-Type: application/json');
			echo json_encode($is_valid);
		}

	public function validateFromDate()
		{
			session_start();
			$user = Auth::getUser();

			$dob = $user['dob'];

			$from_date = Addresses::getFormattedDate($_GET['from_date']);
			$until_date = Addresses::getFormattedDate($_GET['until_date']);

			
			if ($from_date < $dob) {
			$message = 'From date needs to be on/after Date of birth!';
			}

			if ($from_date > $until_date) {
			$message = 'From date needs to be before until date.';
			}

			if ($from_date < $dob && $from_date > $until_date) {
			$message = 'From date needs to be before until date & on/after Date of birth!';
			}

			if ($from_date > $dob && $from_date > $dob && $from_date < $until_date) {
				echo json_encode(
					true);
			}
				
			if (isset($message)) {

			if ($message != null) {
			echo json_encode($message);
				}
			}
		}

	public function validateToDate()
		{
			

			$from_date = Addresses::getFormattedDate($_GET['from_date']);
			$until_date = Addresses::getFormattedDate($_GET['until_date']);

			if ($until_date <= $from_date) {
				$message = "Until date needs to be after from date.";
				echo json_encode($message);
			} else {
				echo json_encode(true);
			}
		}
	}
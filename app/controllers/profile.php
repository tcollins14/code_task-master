<?php

use app\Auth;
use app\Flash;

class Profile extends Controller {

	public function __construct() {
		
		$this->auth = $this->auth();
		$this->flash = $this->flash();

	}

	public function show()
	{
		$this->requireLogin();

		$user = Auth::getUser();

		$this->view('profile/show', ['user' => Auth::getUser(), 'addresses' => Addresses::findAddressesById($user)
	]);
	}

	public function edit()
	{
		$this->requireLogin();
		
		$this->view('profile/edit', ['user' => Auth::getUser()
	]);
	}

	public function update()
	{
		$this->requireLogin();

		$user = Auth::getUser();

		if ($user->updateProfile($_POST)) {
			Flash::addMessage('Changes saved');

			$this->redirect('profile/show');
		} else {

			$this->view('profile/edit', ['user' => $user
		]);	

		}
	}

	public function add()
	{
		$this->requireLogin();

		$this->view('profile/add-address');
	}

	public function add_address()
	{
		$this->requireLogin();

		$user = Auth::getUser();

		if(Addresses::addAddress($_POST, $user)) {
			Flash::addMessage('Address Added');

			$this->redirect('profile/show');
		} else {
			$this->view('profile/add-address', ['address' => $address]);

		}
	}
	

	public function edit_address()
	{
		$this->requireLogin();

		$user = Auth::getUser();

		$this->view('profile/edit-add',['address' => Addresses::findAddressById($_GET['aid'])
	]);
	}

	public function update_address()
	{
		$this->requireLogin();

		$address = Addresses::findAddressById($_POST['address_id']);

		$user = Auth::getUser();

		if($address->updateAddress($_POST, $user)) {
			Flash::addMessage('Address Changed');

			$this->redirect('profile/show');
		} else {
			$this->view('profile/edit-add', ['address' => $address]);
		}
	}

	public function delete()
	{
		$this->requireLogin();

		$aid = $_POST['aid'];

		$deleted = Addresses::deleteAddress($aid);

		echo $deleted;

	}
}

?>
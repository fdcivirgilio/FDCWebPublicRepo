<?php
class MessagesController extends AppController {
	public $uses = ['Message', 'User'];
	public function index() {
		$currentUserID = $this->Auth->user('id');


		$currentUsersMessageList = $this->Message->query(
			'SELECT messages.*, users.name, users.profile_image, users.id FROM messages
			JOIN (
				SELECT MAX(id) as max_id, 
				CASE WHEN sender_id = ' . $currentUserID . ' THEN receiver_id ELSE sender_id END as other_user_id 
				FROM messages
				WHERE (sender_id = ' . $currentUserID . ' OR receiver_id = ' . $currentUserID . ') and (messages.status = 1)
				GROUP BY CASE WHEN sender_id = ' . $currentUserID . ' THEN receiver_id ELSE sender_id END
			) as mm ON messages.id = mm.max_id
			JOIN users ON messages.sender_id = users.id OR messages.receiver_id = users.id
			WHERE users.id != ' . $currentUserID . ' ORDER BY messages.created_at DESC'
		);

		// echo "<pre>";
		// print_r($currentUsersMessageList);
		// die();

		$this->set('messages', $currentUsersMessageList);
		$this->set('currentUserID', $currentUserID);
	}

	public function create() {

		$currentUser = $this->Auth->user('id');

		$users = $this->User->find('all', array(
			'conditions' => array(
				'User.id !=' => $currentUser,
				'User.status' => 1
			)
		));
		$this->set('users', $users);

		if ($this->request->is('post')) {

			$recipientID = $this->request->data['recipient'];
			$message = $this->request->data['content'];

			if (!$message) {
				$this->Flash->error(__('Message cannot be empty.'));
				$this->redirect(array('action' => 'create'));
			}

			if (!$recipientID) {
				$this->Flash->error(__('Recipient cannot be empty.'));
				$this->redirect(array('action' => 'create'));
			}

			$data = array(
				'sender_id' => $currentUser,
				'receiver_id' => $recipientID,
				'message' => $message,
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->Message->create();
			$this->Message->save($data);

			$this->Flash->success(__('Message sent.'));
			return $this->redirect(array('action' => 'view', $recipientID));
		}
	}


	public function view($id = null) {
		$currentUserID = $this->Auth->user('id');
		$recipientID = $id;

		if ($recipientID == $currentUserID) {
			$this->Flash->error(__('You cannot send a message to yourself.'));
			return $this->redirect(array('action' => 'index'));
		}

		$messageDetails = $this->Message->query(
			'SELECT messages.*, sender_users.name as sender_name, sender_users.profile_image, receiver_users.name as receiver_name, receiver_users.profile_image
			FROM messages
			JOIN users as sender_users ON sender_users.id = messages.sender_id
			JOIN users as receiver_users ON receiver_users.id = messages.receiver_id
			WHERE ((messages.sender_id = ' . $currentUserID . ' AND messages.receiver_id = ' . $recipientID . ') 
			OR (messages.sender_id = ' . $recipientID . ' AND messages.receiver_id = ' . $currentUserID . '))
			AND (messages.status = 1)
			ORDER BY messages.created_at ASC'
		);

		$recipientInfo = $this->User->query(
			'SELECT name, profile_image FROM users WHERE id = ' . $recipientID
		);

		// echo "<pre>";
		// print_r($recipientInfo);
		// die();

		$this->set('messageDetails', $messageDetails);
		$this->set('currentUserID', $currentUserID);
		$this->set('recipientID', $recipientID);

		$this->set('recipientImage', $recipientInfo[0]['users']['profile_image']);
		$this->set('recipientName', $recipientInfo[0]['users']['name']);
	}

	public function reply($id = null) {
		$currentUser = $this->Auth->user('id');
		$recipientID = $id;

		if ($this->request->is('post')) {
			$message = $this->request->data['reply'];

			if (empty($message)) {
				$this->Flash->error(__('Message cannot be empty.'));
				$this->render(array('action' => 'view', $recipientID));
			}

			$data = array(
				'sender_id' => $currentUser,
				'receiver_id' => $recipientID,
				'message' => $message,
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->Message->create();
			$this->Message->save($data);

			if ($this->Message->save($data)) {
				$response = array(
					'status' => 'success',
					'message' => 'Message sent.',
					'data' => $data

				);

				echo json_encode($response);
				die();
			} else {
				$this->Flash->error(__('Message was not sent.'));
				return $this->redirect(array('action' => 'view', $recipientID));
			}
		}
	}

	public function delete($id = null) {
		$messageID = $id;

		// echo "<pre>";
		// print_r($messageID);
		// die();

		if (!$messageID) {
			throw new NotFoundException(__('Invalid message'));
		}

		$messageDetail = $this->Message->findById($messageID)['Message'];
		$messageDetail['status'] = 0;

		$this->Message->save($messageDetail);

		if ($this->Message->save($messageDetail)) {
			$response = array(
				'status' => 'success',
				'message' => 'Message deleted.',
				'data' => $messageDetail

			);

			echo json_encode($response);
			die();
		}
		$this->Flash->error(__('Message was not deleted'));
		return $this->redirect(array('action' => 'view', $messageDetail['receiver_id']));
	}

	public function findMessage() {
		$this->autoRender = false;

		$recipientID = $this->request->query['recipientID'];
		$currentUserID = $this->Auth->user('id');
		$word = $this->request->query['findMessage'];

		$foundMessages = $this->Message->query('SELECT Message.message 
                    FROM messages AS Message 
                    WHERE Message.status = 1 
                    AND Message.sender_id = ' . $currentUserID . ' 
                    AND Message.receiver_id = ' . $recipientID . '
                    AND Message.message LIKE ' . "'%" . $word . "%'");

		if ($foundMessages) {
			$response = array(
				'status' => 'success',
				'message' => 'Messages found.',
				'data' => $foundMessages
			);
		} else {
			$response = array(
				'status' => 'error',
				'message' => 'No messages found.'
			);
		}

		$this->response->type('json');
		$this->response->body(json_encode($response));
	}

	public function getUsers() {
		$this->autoRender = false;
		$currentUserID = $this->Auth->user('id');
		$term = $this->request->query['term'];


		$users = $this->User->query(
			"SELECT * FROM users WHERE name LIKE '%$term%' AND status = 1 AND id != $currentUserID"
		);

		$results = array();
		foreach ($users as $user) {
			$imageFile = basename($user['users']['profile_image']);
			$results[] = array(
				'id' => $user['users']['id'],
				'text' => $user['users']['name'],
				'email' => $user['users']['email'],
				'image' => $imageFile
			);
		}

		return json_encode($results);
	}
}

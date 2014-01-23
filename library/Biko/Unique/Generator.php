<?php

namespace Biko\Unique;

use Phalcon\Mvc\User\Component;

class Generator extends Component
{

	/**
	 * Returns a unique ID per session
	 *
	 * @return string
	 */
	public function get()
	{
		if (!$this->session->has('sessionId')) {
            $sessionId = md5(uniqid("sess", true));
            $this->session->set('sessionId', $sessionId);
		} else {
            $sessionId = $this->session->get('sessionId');
		}
		return $sessionId;
	}

}